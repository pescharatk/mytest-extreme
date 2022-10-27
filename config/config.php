<?php
$folder_name = "mytest-extreme";
if($_SERVER["SERVER_NAME"]==$folder_name.".herokuapp.com"){
    $pageURL = 'http';
    if (isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    $pageURL .= $_SERVER["SERVER_NAME"];
    $pageURL .= "/";
    $environment = "deploy";
}else{
    $pageURL = 'http://'.$_SERVER["SERVER_NAME"]."/".$folder_name;
    $environment = "testing";
}
    
if (!defined('URL_API_USER_GETDATA'))
    define('URL_API_USER_GETDATA', $pageURL."/api/user_getdata.php");
if (!defined('URL_API_USER_DATALIST'))
    define('URL_API_USER_DATALIST', $pageURL."/api/user_datalist.php");
if (!defined('URL_API_USER_CREATE'))
    define('URL_API_USER_CREATE', $pageURL."/api/user_create.php");
if (!defined('URL_API_USER_UPDATE'))
    define('URL_API_USER_UPDATE', $pageURL."/api/user_update.php");
if (!defined('URL_API_USER_DELETE'))
    define('URL_API_USER_DELETE', $pageURL."/api/user_delete.php");
?>
