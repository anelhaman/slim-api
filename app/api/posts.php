<?php
header("Content-type: text/json");

$app->get('/',function(){

  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );
  return json_encode($returnObject);
});

$app->get('/api/posts',function(){
  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );

  $mysqli = new mysqli("localhost","admin","1234","selection");
  $query  = "SELECT * FROM post";
  $result = $mysqli->query($query);

  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }

if (isset($data)) {

  $returnObject['data']     = $data;
  $returnObject['message']  = 'list all apps';

  return json_encode($returnObject);
}

});

$app->get('/api/post/{id}',function($request){
  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );

  $id     = $request->getAttribute('id');
  $mysqli = new mysqli("localhost","admin","1234","selection");
  $query  = "SELECT * FROM post WHERE id=$id";
  $result = $mysqli->query($query);

  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }

if (isset($data)) {

  $returnObject['data']     = $data;
  $returnObject['message']  = 'list id';

  return json_encode($returnObject);
}
else {
  $returnObject['message']  = 'api not working';
  return json_encode($returnObject);
}

});

$app->post('/api/posts',function($request,$responce,$args){
  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );

  // foreach ($_POST as $key => $value) {
  //   echo $key." : ".$value."<br>";
  //   # code...
  // }


  $mysqli = new mysqli("localhost","admin","1234","selection");
  $query  = "INSERT INTO post(msg,c_like) VALUE(?,?)";
  $stmt   = $mysqli->prepare($query);

  $stmt->bind_param("si",$a,$b);

  $a      = $request->getParsedBody()['msg'];
  $b      = $request->getParsedBody()['c_like'];

  $stmt->execute();



  $returnObject['data'] = $mysqli->insert_id;


  return json_encode($returnObject);
});

$app->put('/api/post/{id}',function($request){
  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );

  $id     = $request->getAttribute('id');
  $mysqli = new mysqli("localhost","admin","1234","selection");
  $query  = "UPDATE post SET msg = ? WHERE id = $id";
  $stmt   = $mysqli->prepare($query);

  $stmt->bind_param('s',$a);

  $a      = $request->getParsedBody()['msg'];
  $result = $stmt->execute();

  $returnObject['data'] = $result;

  return json_encode($returnObject);
});

$app->delete('/api/post/{id}',function($request){
  $returnObject = array(
    "apiVersion"  	=> 1.0,
    "method" 		    => $_SERVER['REQUEST_METHOD'],
    // "header"     => $headers,
    "execute"     	=> floatval(round(microtime(true)-StTime,4)),
  );

  $id     = $request->getAttribute('id');
  $mysqli = new mysqli("localhost","admin","1234","selection");
  $query  = "DELETE FROM post WHERE id = $id";
  $result = $mysqli->query($query);

  $returnObject['data'] = $result;

  return json_encode($returnObject);

});

?>
