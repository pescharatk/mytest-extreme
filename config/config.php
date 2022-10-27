<?php
$folder_name = "mytest-extreme";

if (!defined('URL_API_USER_GETDATA'))
    define('URL_API_USER_GETDATA', "http://localhost/".$folder_name."/api/user_getdata.php");
if (!defined('URL_API_USER_DATALIST'))
    define('URL_API_USER_DATALIST', "http://localhost/".$folder_name."/api/user_datalist.php");
if (!defined('URL_API_USER_CREATE'))
    define('URL_API_USER_CREATE', "http://localhost/".$folder_name."/api/user_create.php");
if (!defined('URL_API_USER_UPDATE'))
    define('URL_API_USER_UPDATE', "http://localhost/".$folder_name."/api/user_update.php");
if (!defined('URL_API_USER_DELETE'))
    define('URL_API_USER_DELETE', "http://localhost/".$folder_name."/api/user_delete.php");

include 'config/function.php';
?>