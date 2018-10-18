<?php
// Routes
$app->get('/testget/{params}', function ($request, $response, $args) {
        $sth = $args['params'];
        return $this->response->withJson($sth);
    });

$app->post('/testpost', function($request, $response){
	$data = json_decode($request->getBody());
	$sth = $data;
	return $this->response->withJson($data);
});
