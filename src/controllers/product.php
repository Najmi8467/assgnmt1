<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

include __DIR__. '/../function/productsProc.php';

//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){
return $this->response->withJson(array('data' => 'success'), 200);
});

//request table products by condition

$app->get('/products/[{id}]', function ($request, $response, $args){
    
  $productId = $args['id'];
  if (!is_numeric($productId)) {
     return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
  }

$data = getProduct($this->db,$productId);
if (empty($data)) {
  return $this->response->withJson(array('error' => 'no data'), 404);
}
 return $this->response->withJson(array('data' => $data), 200);
});

$app-> post ('/products/inserts', function ($request, $response, $args){
  $form_data = $request->getParsedBody();
  //return $this->response->withJson($form_data, 200);

  $data = createProduct($this->db, $form_data);
  if ($data <= 0){
    return $this->response->withJson(array('error' => 'fail'), 500);
  }
  return $this->response->withJson(array('Successfully inserted. your id is'=> $data), 200);
  
});

//update product
$app-> put('/products/update/[{id}]', function ($request, $response,$args){

  $productId = $args['id'];
    if (!is_numeric($productId)) {
      return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
  $form_data = $request->getParsedBody();
    
  $data = updateProduct($this->db, $form_data, $productId);
    return $this->response->withJson(array('data'=> 'updated dah'), 200);
});

//delete product

$app->delete ('/products/del/[{id}]', function ($request, $response, $args){
  $productId = $args['id'];
  if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
  }
  $data = deleteProduct($this->db, $productId);
  if (empty($data)){
    return $this->response->withJson(array('data' => 'deleted dah'), 200);
  }
});