<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';
$db = new database();    

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $response= "F";
    $message= "";
    
     $id = (!empty($_POST["id"])) ?$_POST["id"]: 0;
     
     if(!empty($id)){
        $sql = "DELETE FROM user WHERE id='".$id."'";
        $db ->query($sql);
        
        if (!$db->error(2)) {
            $response= "S";
            $message="Success.";
        } else {
           $response= "F";
           $message="Failed.";
        }
    }else{
        $response= "F";
        $message="ID is null.";
    }
    
    echo  json_encode(array('response' => $response, 'message' => $message)); 
}else{
    echo  json_encode(array('response' => "F", 'message' => "Request Method Failed."));
}
?>
    