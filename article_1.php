<?php
$content = (!empty($_POST["content"])) ?$_POST["content"]: 0;
$action = (!empty($_POST["action"])) ?$_POST["action"]: "";
if(empty($keypage) && $content==0){
     header( "location: index.php" );
     exit(0);
}

include 'config/config.php';
?>

 <?php if($action==""){?>
 <?php
 $s_keywords = (isset($_POST["s_keywords"])) ?$_POST["s_keywords"]: "";
 $val_keywords = trim(str_replace(" ", "", $s_keywords));

$json = call_api("POST",URL_API_USER_DATALIST);
$array = json_decode($json,true);
$datalist = json_decode($array["data"],true);

$query = array();
if($val_keywords==""){
    $query = $datalist;
}else{
     if(count($datalist)>=1){
         foreach ($datalist as $row) {
             if(mb_substr($row["username"], 0, strlen($val_keywords), 'UTF-8') ==$val_keywords || 
             mb_substr($row["name"], 0, strlen($val_keywords), 'UTF-8') ==$val_keywords || 
             mb_substr($row["surname"], 0, strlen($val_keywords), 'UTF-8') ==$val_keywords || 
             mb_substr($row["email"], 0, strlen($val_keywords), 'UTF-8') ==$val_keywords){
                 $query[] = $row;
             }
         }
     }
}

 ?>
    <h2 class="page-header">User List</h2>
    <div class="form-inline">
        <div class="form-group">
            <input type="text" class="form-control" name="s_keywords" id="s_keywords" placeholder="ค้นหา..." value="<?=$s_keywords;?>">
       </div>
       
       <div class="form-group">
             <button type="button" class="btn btn-default" onclick="onSearch()">ค้นหา</button>
         </div>
       
        <div class="form-group pull-right">
            <button type="button" class="btn btn-success pull-right" onclick="onAdd()"><i class="fa fa-plus"></i> เพิ่ม</button>
        </div>
    </div>
    
    <div id="divAlert"></div>
    <div class="table-responsive">
        <table class="table table-bordered margin-top-25 ">
                <thead>
                <tr>
                    <th style="text-align: center;width: 50px;min-width: 50px">No.</th>
                    <th style="text-align: left;width: 120px;min-width: 120px">Username</th>
                    <th style="text-align: left;width: 120px;;min-width: 120px">Name</th>
                    <th style="text-align: left;width: 120px;min-width: 120px">Surname</th>
                    <th style="text-align: left;width: 120px;min-width: 120px">Email</th>
                    <th style="text-align: center;width: 140px;min-width: 140px">Created Date</th>
                    <th style="text-align: center;width: 140px;min-width: 140px">Update Date</th>
                    <th style="text-align: center;width:140px;min-width: 140px">Action</th>
                </tr>
            </thead>
    
            <tbody>
 <?php
 $n = 1;
 if(count($query)>=1){
     foreach ($query as $row) {
        $id = $row["id"];
        $username = $row["username"];
        $name = $row["name"];
        $surname = $row["surname"];
        $email = $row["email"];
        $created_date = $row["created_date"];
        $update_date = $row["update_date"];
 ?>            
                <tr>
                    <td style="text-align: center"><?=$n++;?></td>
                    <td style="text-align: left"><?=$username;?></td>
                    <td style="text-align: left"><?=$name;?></td>
                    <td style="text-align: left"><?=$surname;?></td>
                    <td style="text-align: left"><?=$email;?></td>
                    <td style="text-align: center"><?=datetime($created_date);?></td>
                    <td style="text-align: center"><?=datetime($update_date);?></td>
                    <td style="text-align: center">
                        <button type="button" class="btn btn-info btn-xs" onclick="onView(<?=$id;?>);"><i class="fa fa-search"></i> ดู</button>
                        <button type="button" class="btn btn-warning btn-xs" onclick="onEdit(<?=$id;?>);"><i class="fa fa-pencil"></i> แก้ไข</button>
                        <button type="button" class="btn btn-danger btn-xs" onclick="onDelete(<?=$id;?>);"><i class="fa fa-trash-o"></i> ลบ</button>
                    </td>
                </tr>
 <?php
    }
 }else{
 ?>   
            <tr>
                <td colspan="8">ไม่พบข้อมูล</td>
            </tr>
 <?php } ?>        
            </tbody>
        </table>        
    </div>

    <script>
        $(document).ready(function () {
            $("#s_keywords").keypress(function( event ) {
                 if(event.which == 13){
                     onSearch();
                 }
            });
        });
        
        function onSearch() {        
            var s_keywords = $("#s_keywords").val();
            loadPage(s_keywords);
        }
        
        function loadPage( s_keywords=""){
            var divMain = $("#divMain");
            divMain.html("<center><div class='loader'></div></center>");
           
            var para = "s_keywords="+ s_keywords;  
            
             $.ajax({
                data : para+"&content=1",
                type : "POST",
                url: "article_1.php",
                success : function(resPonse) {
                  setTimeout(function() {
                       divMain.html(resPonse);
                  }, 1000);
                }
            });
        }
        
        function onView(id=0){
           var divMain = $("#divMain");
           divMain.html("<center><div class='loader'></div></center>");
              
            $.ajax({
                data : "id="+id+"&content=1&action=view",
                type : "POST",
                url: "article_1.php",
                success : function(resPonse) {
                    divMain.html(resPonse);
                }
            });
        }
        
        function onAdd(){
            var divMain = $("#divMain");
           divMain.html("<center><div class='loader'></div></center>");
              
            $.ajax({
                data : "content=1&action=add",
                type : "POST",
                url: "article_1.php",
                success : function(resPonse) {
                    divMain.html(resPonse);
                }
            });
        }
        
        function onEdit(id=0){
           var divMain = $("#divMain");
           divMain.html("<center><div class='loader'></div></center>");
              
            $.ajax({
                data : "id="+id+"&content=1&action=edit",
                type : "POST",
                url: "article_1.php",
                success : function(resPonse) {
                    divMain.html(resPonse);
                }
            });
        }
        
        
        function onDelete(id=0){
         var divAlert = $("#divAlert");
         if(confirm("คุณต้องการ ลบข้อมูลนี้ ใช่หรือไม่?")){
            $(window).scrollTop(0);
            divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่...</div>');
            $.ajax({
                type: "POST",
                url: "<?=URL_API_USER_DELETE; ?>",
                data : 'id='+id,
                success: function(res){   
                     if($.trim(res.response)=="S"){
                        divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> '+$.trim(res.message)+'</div>');
                        setTimeout(function() {
                             loadPage('<?=$s_keywords;?>');
                        }, 1000);
                    }else{
                        divAlert.html('<div class="alert alert-danger font-sm margin-top-15"><i class="fa-lg fa fa-warning"></i>  '+$.trim(res.message)+'</div>');
                    }
                }
            });
        }
    }
    </script>
<?php }else if($action=="view"){ ?>
<?php
     $id = (isset($_POST["id"])) ?$_POST["id"]: "";
     
    $json = call_api("POST",URL_API_USER_GETDATA,array("id"=>$id));
    $array = json_decode($json,true);
    $row = json_decode($array["data"],true);

    $username = $row["username"];
    $name = $row["name"];
    $surname = $row["surname"];
    $email = $row["email"];
    $created_date = $row["created_date"];
    $update_date = $row["update_date"];
?>
    
      <h3 class="page-header"><i class="fa fa-search"></i>  User</h3>
      <div class="col-md-12 form-action">
          <form action="javascript:void(0)" id="view_form" name="view_form" class="form-horizontal" method="post" role="form" >
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Username</label>
                        <p><?=$username;?></p>
                         <hr>
                    </div>
              </div>
          
        
            <div class="col-md-6 col-sm-offset-3">
               <div class="form-group">
                    <label>Name</label>
                    <p><?=$name;?></p>
                    <hr>
                </div>
          </div>
          
          <div class="col-md-6 col-sm-offset-3">
               <div class="form-group">
                    <label>Surname</label>
                     <p><?=$surname;?></p>
                     <hr>
                </div>
          </div>
        
            <div class="col-md-6 col-sm-offset-3">
               <div class="form-group">
                    <label>Email</label>
                    <p><?=$email;?></p>
                    <hr>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-offset-3">
               <div class="form-group">
                    <label>Created Date </label>
                    <p><?=datetime($created_date);?></p>
                    <hr>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-offset-3">
               <div class="form-group">
                    <label>Update Date  </label>
                    <p><?=datetime($update_date);?></p>
                    <hr>
                </div>
            </div>
          
           <div class="col-md-6 col-sm-offset-3 margin-top-20">
               <div class="form-group">
                    <button type="button" class="btn btn-default" onclick="loadPage()"><i class="fa fa-arrow-left" ></i> กลับ</button>
                </div>
          </div>
    </form>
    </div>
         
     <?php }else if($action=="add"){ ?>
         <h3 class="page-header"><i class="fa fa-plus"></i> เพิ่ม User</h3>
         <div class="col-md-12 form-action">
             <form action="javascript:void(0)" id="add_form" name="add_form" class="form-horizontal" method="post" role="form">
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                       <div id="divAlert"></div>
                        <label>Username<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="username" name="username" required="required">
                    </div>
              </div>
              
               <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Password<span class="required">*</span></label><br>
                        <input type="password" class="form-control" id="password" name="password" required="required" >
                    </div>
              </div>
            
            <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Name<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="name" name="name" required="required">
                    </div>
              </div>
              
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Surname<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="surname" name="surname" required="required">
                    </div>
              </div>
            
             <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Email<span class="required">*</span></label><br>
                        <input type="email" class="form-control" id="email" name="email" required="required" >
                    </div>
              </div>
              
               <div class="col-md-6 col-sm-offset-3 margin-top-20">
                   <div class="form-group">
                        <button type="button" class="btn btn-default bt_cancel" onclick="loadPage()"><i class="fa fa-arrow-left" ></i> ยกเลิก</button>
                        <button type="button" class="btn btn-success bt_save" onclick="onSave()"><i class="fa fa-save" ></i> บันทึก</button>
                    </div>
              </div>
            </form>
        </div>
    
    <script>        
        function onSave(){
            var form_name = "add_form";
            var form     = $('#'+form_name);
            var validator = form.validate();
            var formData = new FormData(document.forms.namedItem(form_name));
            var ck_valid     = $("#"+form_name).valid();    
            var divAlert =  $('#divAlert'); 
            var bt_save =  $(".bt_save");   
            var bt_cancel =  $(".bt_cancel");
            
             if(ck_valid == true){
                if(confirm("คุณต้องการ บันทึกข้อมูล ใช่หรือไม่?")){
                    $(window).scrollTop(0);
                    divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่...</div>');
                    
                    bt_save.prop("disabled",true);
                     bt_cancel.prop("disabled",true);
                    
                    $.ajax({
                        type: "POST",
                        url: "<?=URL_API_USER_CREATE; ?>",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(res){
                            if($.trim(res.response)=="S"){
                                divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> '+$.trim(res.message)+'</div>');
                                setTimeout(function() {
                                     onView($.trim(res.id));
                                }, 1000);
                            }else{
                                 bt_save.prop("disabled",false);
                                 bt_cancel.prop("disabled",false);
                                divAlert.html('<div class="alert alert-danger font-sm margin-top-15"><i class="fa-lg fa fa-warning"></i>  '+$.trim(res.message)+'</div>');
                            }
                        }
                    });
                }           
            }else{
                validator.focusInvalid();
            }

     }
    </script>
     <?php }else if($action=="edit"){ ?>
      <?php
         $id = (isset($_POST["id"])) ?$_POST["id"]: "";
         
        $json = call_api("POST",URL_API_USER_GETDATA,array("id"=>$id));
        $array = json_decode($json,true);
        $row = json_decode($array["data"],true);
    
        $username = $row["username"];
        $password = $row["password"];
        $name = $row["name"];
        $surname = $row["surname"];
        $email = $row["email"];
        $created_date = $row["created_date"];
        $update_date = $row["update_date"];
    ?>
    
         <h3 class="page-header"><i class="fa fa-pencil"></i> แก้ไข User</h3>
         <div class="col-md-12 form-action">
             <form action="javascript:void(0)" id="edit_form" name="edit_form" class="form-horizontal" method="post" role="form">
                 <input type="hidden" name="id" value="<?=$id;?>" />
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                       <div id="divAlert"></div>
                        <label>Username<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="username" name="username" required="required" value="<?=$username;?>">
                    </div>
              </div>
              
               <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Password<span class="required">*</span></label><br>
                        <input type="password" class="form-control" id="password" name="password" required="required" value="<?=$password;?>">
                    </div>
              </div>
            
            <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Name<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="name" name="name" required="required" value="<?=$name;?>">
                    </div>
              </div>
              
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Surname<span class="required">*</span></label><br>
                        <input type="text" class="form-control" id="surname" name="surname" required="required" value="<?=$surname;?>">
                    </div>
              </div>
              
              <div class="col-md-6 col-sm-offset-3">
                   <div class="form-group">
                        <label>Email<span class="required">*</span></label><br>
                        <input type="email" class="form-control" id="email" name="email" required="required" value="<?=$email;?>">
                    </div>
              </div>
            
              
               <div class="col-md-6 col-sm-offset-3 margin-top-20">
                   <div class="form-group">
                        <button type="button" class="btn btn-default bt_cancel" onclick="loadPage()"><i class="fa fa-arrow-left" ></i> ยกเลิก</button>
                        <button type="button" class="btn btn-success bt_save" onclick="onUpdate()"><i class="fa fa-save" ></i> บันทึก</button>
                    </div>
              </div>
            </form>
        </div>
        
      <script>        
        function onUpdate(){
            var form_name = "edit_form";
            var form     = $('#'+form_name);
            var validator = form.validate();
            var formData = new FormData(document.forms.namedItem(form_name));
            var ck_valid     = $("#"+form_name).valid();    
            var divAlert =  $('#divAlert'); 
            var bt_save =  $(".bt_save");   
            var bt_cancel =  $(".bt_cancel");
            
             if(ck_valid == true){
                if(confirm("คุณต้องการ บันทึกข้อมูล ใช่หรือไม่?")){
                    $(window).scrollTop(0);
                    divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่...</div>');
                    
                     bt_save.prop("disabled",true);
                     bt_cancel.prop("disabled",true);
                    $.ajax({
                        type: "POST",
                        url: "<?=URL_API_USER_UPDATE; ?>",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(res){
                            if($.trim(res.response)=="S"){
                                divAlert.html('<div class="alert alert-success font-sm margin-top-15"><i class="fa fa-spinner fa-spin"></i> '+$.trim(res.message)+'</div>');
                                setTimeout(function() {
                                     onView(<?=$id;?>);
                                }, 1000);
                            }else{
                                 bt_save.prop("disabled",false);
                                 bt_cancel.prop("disabled",false);
                                divAlert.html('<div class="alert alert-danger font-sm margin-top-15"><i class="fa-lg fa fa-warning"></i>  '+$.trim(res.message)+'</div>');
                            }
                        }
                    });
                }           
            }else{
                validator.focusInvalid();
            }

     }
    </script>
    <?php } ?>   
