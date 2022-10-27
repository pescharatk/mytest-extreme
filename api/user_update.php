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
        $col = array("username","password","name","surname","email");
        $count_col = 0;
        $ck_valid = 0;
        $con_save = "";
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
        
        if($count_col>=1){
            if($ck_valid==0){
                $sql = "UPDATE user SET $con_save update_date = NOW() WHERE id='".$id."'";
                $db->query($sql);
                
                if (!$db->error(2)) {
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
    }else{
        $response= "F";
         $message="ID is null.";
    }
        
      echo  json_encode(array('response' => $response, 'message' => $message));
}else{
      echo  json_encode(array('response' => "F", 'message' => "Request Method Failed."));
}
?>
    