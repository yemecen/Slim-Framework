<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../src/model/Customer.php';

$app = new \Slim\App;

//GET All Customers 
$app->get('/api/customers',function(Request $request,Response $response){

	try {		
		
		return Customer::all()->toJson();

	} catch (PDOException $e) {
		echo '{"error":{"text":'.$e->getMessage().'}}';
	}
});

//GET By ID Customers
$app->get('/api/customers/{id}',function(Request $request,Response $response){
	
	$id=$request->getAttribute('id');
 
	try {
		
		return Customer::find($id)->toJson();
	
	} catch (PDOException $e) {
		echo '{"error":{"text":'.$e->getMessage().'}}';
	}
});

//POST Customer
$app->post('/api/customers/',function(Request $request,Response $response){
	
	$first_name=$request->getParam('first_name');
	$last_name=$request->getParam('last_name');
	$phone=$request->getParam('phone');
	$email=$request->getParam('email');


	try {
		
		$customers = new Customer();
		$customers->first_name=$first_name;
		$customers->last_name=$last_name;
		$customers->phone=$phone;
		$customers->email=$email;
		$customers->save();

		echo '{"notice":{"text":"Customer Post"}}';

	} catch (PDOException $e) {
		echo '{"error":{"text":'.$e->getMessage().'}}';
	}
});

//PUT Customer
$app->put('/api/customers/{id}',function(Request $request,Response $response){

	$id=$request->getAttribute('id');

	$first_name=$request->getParam('first_name');
	$last_name=$request->getParam('last_name');
	$phone=$request->getParam('phone');
	$email=$request->getParam('email');

	try {
		
		$customers = Customer::find($id);
		$customers->first_name=$first_name;
		$customers->last_name=$last_name;
		$customers->phone=$phone;
		$customers->email=$email;
		$customers->save();

		echo '{"notice":{"text":"Customer Update"}}';

	} catch (PDOException $e) {
		echo '{"error":{"text":'.$e->getMessage().'}}';
	}
});

//DELETE
$app->delete('/api/customers/{id}',function(Request $request,Response $response){
	
	$id=$request->getAttribute('id');

	try {
				 
		Customer::destroy($id);

		echo '{"notice":{"text":"Customer Delete"}}';

	} catch (PDOException $e) {
		echo '{"error":{"text":'.$e->getMessage().'}}';
	}
});