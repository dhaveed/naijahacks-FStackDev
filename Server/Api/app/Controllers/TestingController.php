<?php
namespace App\Controllers;

use App\Renders\ApiView;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class TestingController
{
    private $view;
    private $logger;
    private $db;

    public function __construct(ApiView $view, LoggerInterface $logger, $cdb)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $cdb;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
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
        $data = ['message' => "Easter eggs found!!"];

        // $data = ['message' => $message, 'usercount' => $count, 'users' => $all];
        return $this->view->render($request, $response, $data, 200);
    }
}
