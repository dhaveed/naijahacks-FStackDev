<?php
// Routes

$app->get('/setcookies/{name}', function ($request, $response, $args) {
    // Use app HTTP cookie service
    $this->get('cookies')->set('name', [
        'value' => $args['name'],
        'expires' => '7 days'
    ]);
});


$app->get('/getusers/{id}', function ($request, $response) {
		$sth = $args['id'];
        return $this->response->withJson($sth);
    });

$app->post('/login', function($request, $response){
	$data = json_decode($request->getBody());
	$response = $this->verifyRequiredParams(array('username','password'), $data);
	if(isset($response['error'])){
		$sth = $response;
	    return $this->response->withJson($sth);
	}
	$handler = new Auth;
	$username = $data->username;
	$password = $data->password;
	$orderbyparam = "_id";
	$sth = $handler->login('users', 'imm', 'magnitudea', $userparam, $orderbyparam);
	return $this->response->withJson($sth);
});

$app->post('/register', function($request, $response){
	$data = json_decode($request->getBody());
	$response = $this->verifyRequiredParams(array('username','password'), $data);
	if(isset($response['error'])){
		$sth = $response;
	    return $this->response->withJson($sth);
	}
	$handler = new Auth;
	$username = $data->username;
	$password = $data->password;
	$email = $data->email;
	$mobile_number = $data->mobile_number;
	$about_me = $data->about_me;
	$d_o_b = $data->date_of_birth;
	$date_created = date("Y-m-d h:i:sa");
	$sth = $handler->insert('users', array('username', 'password', 'email', 'mobile_num', 'about_me', 'date_of_birth','date_registered'), array($username, $password, $email, $mobile_number, $about_me, $d_o_b, $date_created));
	return $this->response->withJson($sth);
});


