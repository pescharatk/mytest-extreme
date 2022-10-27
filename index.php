<?php
$keypage=1;
$page = (!empty($_GET["page"])) ?$_GET["page"]: "0";
 
 include 'config/config.php';
 
$pageData = array();
$pageData = array(
    "0" => array("name"=>"Home","page"=>""),
    "1" => array("name"=>"Article 1 (CRUD Table)","page"=>"article_1.php"),
    "2" => array("name"=>"Article 2 (Random)","page"=>"article_2.php"),
);

$page_name = '';
$page_include = '';
foreach ($pageData as $key => $value) {
    
    if($key==$page){
        $page_name = $value["name"];
    }
          
   if(!empty($key) && $key==$page){ 
        $page_include = $value["page"];
    }
}
?>

<!DOCTYPE html>
<html>
     <head>
       <title><?=$page_name;?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
   </head>
    
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="?page=0">Test Project</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <?php
                    foreach ($pageData as $key => $value) {
                        $class_active = "";
                        if(!empty($key)){
                            $class_active = ($key==$page) ? "active": "";
                        }else{
                            $class_active = ($key==$page|| empty($page)) ? "active": "";
                        }
                    ?>
                    <li class="<?= $class_active;?>"><a href = "?page=<?=$key;?>"><?=$value["name"];?></a></li>
                <?php } ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="?page=0">Pescharat.K</a></li>
              </ul>
            </div>
          </div>
        </nav>

    <div class="container">
        <div id="divMain">
        <?php
           if($page_include!=""){
             include $page_include; 
         }else{ ?>
             <h2 class="page-header">Welcome</h2>
             <pre>CRUD Table
            ***กำหนดให้ส่ง request ทุกอันเป็น post
            
            
            - Create
            URL:  <a href="<?=URL_API_USER_CREATE;?>" target="_blank"><?=URL_API_USER_CREATE;?></a> 
            อธิบาย: การเพิ่มข้อมูล user ใหม่ โดยพารามิเตอร์ที่ต้องส่งไปคือ username, password, name, surname, email
            ______________________________________________
            - Read
            URL: <a href="<?=URL_API_USER_GETDATA;?>" target="_blank"><?=URL_API_USER_GETDATA;?></a>
            อธิบาย: การเรียกดูข้อมูล user 1 แถว โดยพารามิเตอร์ที่ต้องส่งไปคือ id ที่ต้องการเรียกดู
            
            URL: <a href="<?=URL_API_USER_DATALIST;?>" target="_blank"><?=URL_API_USER_DATALIST;?></a>
            อธิบาย: การเรียกดูข้อมูล user เป็นอาเรย์ ไม่ต้องมีพารามิเตอร์
            ______________________________________________
            - Update
            URL: <a href="<?=URL_API_USER_UPDATE;?>" target="_blank"><?=URL_API_USER_UPDATE;?></a>
            อธิบาย: การแก้ไขข้อมูล user ใหม่ โดยพารามิเตอร์ที่ต้องส่งไปคือ id ที่ต้องการแก้ไข
            และจะส่งพารามิเตอร์เฉพาะฟิลด์ที่ต้องการแก้ไขอย่างน้อย 1 ฟิลด์ คือ username, password, name, surname, email 
            ______________________________________________
            - Delete
            URL: <a href="<?=URL_API_USER_DELETE;?>" target="_blank"><?=URL_API_USER_DELETE;?></a>
             อธิบาย: การลบข้อมูล user โดยพารามิเตอร์ที่ต้องส่งไปคือ id ที่ต้องการลบ
            ______________________________________________";
          </pre>
        <?php
         }
        ?>
        </div>
    </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    </body>
</html>             
