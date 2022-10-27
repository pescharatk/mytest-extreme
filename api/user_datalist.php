<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';
$db = new database();    

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $response= "F";
    $message= "";
    $data = "";
    
    $sql = "SELECT * FROM user";
    $result = $db->query($sql)->result();   
    
     if (!$db->error(2)) {
        $data = $result;
        $response= "S";
        $message="Success.";
    } else {
       $response= "F";
       $message="Failed.";
    }
   
    echo json_encode(array('response' => $response, 'message' => $message,"data"=>$data));
}
?>
    