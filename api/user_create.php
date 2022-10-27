<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';
$db = new database();    

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $response= "F";
    $message= "";
    
    $col = array("username","password","name","surname","email");
    $count_col = 0;
    $ck_valid = 0;
    $con_save = "";
    $insert_id = 0;
    foreach ($col as $value) {
        if(isset($_POST[$value])){
            $count_col+=1;
            if($_POST[$value]!=""){
                $con_save .= $value."='".$_POST[$value]."',";
            }else{
                 $ck_valid +=1;
            }
        }
    }
    
    if($count_col==count($col)){
        if($ck_valid==0){
            $sql = "INSERT INTO user SET $con_save created_date=NOW()";
            $db->query($sql);
            
            if (!$db->error(2)) {
                $insert_id = $db->insert_id();
                $response= "S";
                $message="Success.";
            } else {
               $response= "F";
               $message="Failed.";
            }
        }else{
             $response= "F";
             $message="Parameter is null.";
        }
    }else{
         $response= "F";
         $message="Parameter is null.";
    }
    
    echo json_encode(array('response' => $response, 'message' => $message,"id"=>$insert_id));
}else{
    echo  json_encode(array('response' => "F", 'message' => "Request Method Failed."));
}
?>
    