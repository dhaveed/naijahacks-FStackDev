<?php

namespace App\Controllers;

use App\Renders\ApiView;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class CustomersController{
    private $view;
    private $logger;
    private $db;

    public function __construct(ApiView $view, LoggerInterface $logger, $cdb)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $cdb;
    }

    /* public function __invoke(Request $request, Response $response, $args){
        $message = "Customer's Be Available ;)";
        $data = ['message' => $message];
        return $this->view->render($request, $response, $data, 200);
    } */

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

    public function create(Request $request, Response $response, $args){
        //create new client {sessionId, adminMail, clientDetails}
    }

    public function all(Request $request, Response $response, $args){
        //get all active client {sessionId, adminMail}
        $input = $request->getParsedBody();

        $verifyParams = $this->verifyRequiredParams($input, array('sessionId', 'adminEmail'));
        if($verifyParams['e']){
            $data = ['message' => substr($verifyParams['m'], 0, -2)];
            return $this->view->render($request, $response, $data, 401);
        }

        // $clientId = strip_tags($input['id']);
        $sessionId = strip_tags($input['sessionId']);
        $adminEmail = strip_tags($input['adminEmail']);

        $adminExists = $this->db->prepare("SELECT * FROM em_admins WHERE email = '$adminEmail' and session_id = '$sessionId'");
        $adminExists->execute();
        
        if($adminExists->rowCount() != 0){
            $getClients = $this->db->prepare("SELECT * FROM em_clients WHERE status = 1 ORDER BY _id DESC");
            $getClients->execute();
            $realClients = $getClients->fetch();

            if($getClients->rowCount() != 0){
                return $this->view->render($request, $response, $realClients, 200);
            } else{
                //no clients exist
                $data = ['message' => "Sorry, no data was found."];
                return $this->view->render($request, $response, $data, 401);
            }
        } else{
            //that admin doesn't exist
            $data = ['message' => "Sorry, unable to authorize your request."];
            return $this->view->render($request, $response, $data, 401);
        }
    }

    public function one(Request $request, Response $response, $args){
        //get one (requested) client {id, sessionId, adminMail}
    }

    public function edit(Request $request, Response $response, $args){
        //edit (requested) client {id, sessId, adminMail}
    }
    public function remove(Request $request, Response $response, $args){
        //remove (requested client) {id, sessId, adminMail}
    }


}