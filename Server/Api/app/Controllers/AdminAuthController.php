<?php
namespace App\Controllers;

use App\Renders\ApiView;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class AdminAuthController{
    private $view;
    private $logger;
    private $db;
    private $session;
    private $passwordHasher;

    public function __construct(ApiView $view, LoggerInterface $logger, $cdb, $sess, $phash){
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $cdb;
        $this->session = $sess;
        $this->passwordHasher = $phash;
    }

    /* public function __invoke(Request $request, Response $response, $args){
        $message = "Another Confirmed";
        $this->logger->info($message);
        
        $admins = $this->db->prepare("SELECT * FROM em_admins");
        try{
            $admins->execute();
            $count = $admins->rowCount();
            $all = $admins->fetchAll();
        } catch(\PDOException $e){
            throw $e;
        }

        $data = ['message' => $message, 'usercount' => $count, 'users' => $all];
        return $this->view->render($request, $response, $data, 200);
    } */

    public function testSession(Request $request, Response $response, $args){
        $sessVal = $request->getParam('sv');
        if($sessVal){
            //set session
            $this->session->set('session_test', $sessVal);
        }

        //get session values
        $getSessVal = "original set value is - " . $this->session->get('session_test');

        //delete session value
            //check if value exists
            // $this->session::destroy();
            $exists = $this->session->exists('session_test');
            if($exists){
                //delete
                // $this->session::destroy();

                //view
                // $updatedSess = $this->session::id();
            } else {
                $updatedSess = "no exist";
            }

        $data = ['message' => $getSessVal, "newsess" => $updatedSess];
        return $this->view->render($request, $response, $data, 200);

    }

    private function verifyRequiredParams($in, $required){
        $faultyFields = ""; $hasFault = false;
        foreach($required as $param){
            if(!isset($in[$param]) || strlen(trim($in[$param])) <= 0){
                $hasFault = true;
                $faultyFields .= $param . ", ";
            }
        }

        if($hasFault){
            $errorMessage = "The following required field(s) is either missing or empty: " . $faultyFields;
            return ['e' => $hasFault, "m" => $errorMessage];
        }

        return ["e" => $hasFault];
    }

    public function login(Request $request, Response $response, $args){
        $input = $request->getParsedBody();

        $verifyParams = $this->verifyRequiredParams($input, array('email', 'password'));        
        if($verifyParams['e']){
            $data = ['message' => substr($verifyParams['m'], 0, -2)];
            return $this->view->render($request, $response, $data, 401);
        }
        
        $uEmail = htmlspecialchars($input['email']);
        $uPass = htmlspecialchars($input['password']);

        $emailExists = $this->db->prepare("SELECT fullname, email, status, login_id FROM em_admins WHERE email = '$uEmail'");
        $emailExists->execute();
        $udet = $emailExists->fetch();

        if($emailExists->rowCount() != 0){
            $getPass = $this->db->prepare("SELECT password FROM em_admins WHERE email = '$uEmail'");
            $getPass->execute();
            $dbp = $getPass->fetch()['password'];
            if($this->passwordHasher->compare($dbp, $uPass)){
                

                $loginTime = date("Y-m-d H:i:s");
                $ipAddr = $_SERVER['REMOTE_ADDR'];

                $sessionExists = $this->session->exists('u');
                if($sessionExists){
                    $data = ['message' => "You're already logged in!"];
                    return $this->view->render($request, $response, $data, 401);
                } else {
                    $updateLoginInfo = $this->db->prepare("UPDATE em_admins SET last_login = ?, last_ip = ? WHERE email = ?");
                    if($updateLoginInfo->execute([$loginTime, $ipAddr, $uEmail])){
                        $updateSessID = $this->db->prepare("UPDATE em_admins SET session_id = ? WHERE email = ?");
                        if($updateSessID->execute([$this->session::id(), $uEmail])){
                            $this->session->set('u', ['fn' => $udet['fullname'], 'email' => $udet['email'], 'stat' => $udet['status'], 'lid' => $udet['login_id']]);
                            $data = ['message' => "Login successful."];
                        } else {
                            $data = ['message' => "An error occured while logging in."];
                            return $this->view->render($request, $response, $data, 401);
                        }
                        
                    } else {
                        $data = ['message' => "An error occured while logging in."];
                        return $this->view->render($request, $response, $data, 401);
                    }
                }

            } else {
                $data = ['message' => "Invalid password."];
                return $this->view->render($request, $response, $data, 401);
            }
        } else {
            $data = ['message' => "Invalid email."];
            return $this->view->render($request, $response, $data, 401);
        }       

        return $this->view->render($request, $response, $data, 200);
    }

    public function logout(Request $request, Response $response, $args){
        $exists = $this->session->exists('u');
        $currentUser = $this->session->get('u')['email'];
        $currentSessHash = $this->db->prepare("UPDATE em_admins SET session_id = ? WHERE email = ? ");

        if($exists){
            if($currentSessHash->execute(['', $currentUser])){
                $this->session::destroy();
                $data = ['message' => "Logout Successful."];
            } else {
                $data = ['message' => "An unexpected error occurred while logging out."];
                return $this->view->render($request, $response, $data, 401);
            }
        } else {
            $data = ['message' => "An unexpected error occurred while logging out."];
            return $this->view->render($request, $response, $data, 401);
        }
        return $this->view->render($request, $response, $data, 200);
    }

    public function session(Request $request, Response $response, $args){
        $exists = $this->session->exists('u');
        if($exists){
            $session = $this->session->get('u');
            $data = ['message' => $session, 'sessId' => $this->session::id()];
        } else {
            $data = ['message' => "You're not logged in."];
            return $this->view->render($request, $response, $data, 401);
        }

        return $this->view->render($request, $response, $data, 200);
    }

    public function userIsLoggedIn(Request $request, Response $response, $args){
        $sessionExists = $this->session->exists('u');
        if($sessionExists){
            $session = $this->session->get('u');
            $verifyFromDb = $this->db->prepare('SELECT * FROM em_admins WHERE email = ? and session_id = ? LIMIT 1');
            if($verifyFromDb->execute([$session['email'], $this->session::id()])){
                if($verifyFromDb->rowCount() == 0){
                    $data = ['message' => "You're logged in."];
                }
            } else {
                $data = ['message' => "You're not logged in."];
                return $this->view->render($request, $response, $data, 401);
            }
            $data = ['message' => "Logged in"];
        } else {
            $data = ['message' => "You're not logged in."];
            return $this->view->render($request, $response, $data, 401);
        }
        return $this->view->render($request, $response, $data, 200);
    }

}
