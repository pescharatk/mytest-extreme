<?php
$content = (!empty($_POST["content"])) ?$_POST["content"]: 0;
$action = (!empty($_POST["action"])) ?$_POST["action"]: "";
if(empty($keypage) && $content==0){
     header( "location: index.php" );
     exit(0);
}

if($action=="random"){
    header("Content-Type: application/json; charset=UTF-8");
}

$json="[{'name':'SmallPotionHeal','chance':0.12,'stock':1000},
{'name':'MediumPotionHeal','chance':0.08,'stock':80},
{'name':'BigPotionHeal','chance':0.06,'stock':15},
{'name':'FullPotionHeal','chance':0.04,'stock':10},
{'name':'SmallMPPotion','chance':0.12,'stock':1000},
{'name':'MediumMPPotion','chance':0.08,'stock':80},
{'name':'BigMPPotion','chance':0.06,'stock':15},
{'name':'FullMPPotion','chance':0.04,'stock':8},
{'name':'AttackRing','chance':0.05,'stock':10},
{'name':'DefenseRing','chance':0.05,'stock':10},
{'name':'LuckyKey','chance':0.15,'stock':1000},
{'name':'SilverKey','chance':0.15,'stock':1000}]";

$string = str_replace("'",'"', $json);
$string = str_replace('\n', '', $string);
$array = json_decode($string,1);

$data_name = array();
$data_chance = array();
$data_stock = array();
$data_random = array();

$n = 0;
$max = 0;
$k = 1;
foreach ($array as $key => $value) {
    $data_name[$key] = $value["name"];
    $data_chance[$key] = $value["chance"];
    $data_stock[$key] = $value["stock"];
    
    if($value["stock"]>=1){
        $n+=$value["stock"];
    }
    
    $k++;
}
?>
 <?php if($action==""){?>
    <h2 class="page-header">Random</h2>
    <style>
        #divShow{
            padding: 20px 8px 20px 8px;
        }
        
        ul {
          list-style-type: none;
        }
    </style>
    
    <div class="col-md-6 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="text-align: center;width: 50px;min-width: 50px">No.</th>
                        <th style="text-align: left;min-width: 120px">name</th>
                        <th style="text-align: right;width: 60px;;min-width: 60px">chance</th>
                        <th style="text-align: right;width: 60px;min-width: 60px">stock</th>
                         <th style="text-align: right;width: 100px;min-width: 100px;background-color: yellow">สุ่มได้ (ครั้ง)</th>
                         <th style="text-align: right;width: 100px;min-width: 100px;background-color: yellow">คงเหลือ</th>
                    </tr>
                </thead>
        
                <tbody>
     <?php
     $nn = 1;
    foreach ($data_name as $key2 => $value2) {
     ?>            
                    <tr class="rows" data-key="<?=$key2;?>">
                        <td style="text-align: center"><?=$nn;?></td>
                        <td style="text-align: left"><?=$value2;?></td>
                        <td style="text-align: right"><?=$data_chance[$key2];?></td>
                        <td style="text-align: right"><?=$data_stock[$key2];?></td>
                        <td style="text-align: right;background-color: yellow" class="col-1 cols"></td>
                        <td style="text-align: right;background-color: yellow" class="col-2 cols"></td>
                    </tr>
      
     <?php $nn++; } ?>        
                </tbody>
            </table>        
        </div>  
    </div>
    <div class="col-md-6  col-sm-12">
        <button type="button" class="btn btn-block btn-success btn-random">สุ่ม 100 ครั้ง</button>
    
         <div class="thumbnail margin-top-10">
            <div id="divShow">
            </div>
        </div>
      </div>
      
    <script>
    function addList(id,html,time) { 
          setTimeout(function(x, y) {
               $("#list-"+id).html(html);
          }, time);
     }

    $(document).ready(function() {
        $(".btn-random").click(function(){
             var btn = $(this)
             var div = $("#divShow");
             var rows = $(".rows");
             var cols = $(".cols");
             
            btn.prop("disabled",true);
            btn.html('<i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่...');
            div.html('<center><i class="fa fa-spinner fa-spin"></i> กรุณารอสักครู่...</center>');
            cols.html('<i class="fa fa-spinner fa-spin"></i>'); 
             
            $.ajax({
                data : "&content=1&action=random",
                 url: "article_2.php",
                type : "POST",
                success : function(json) {
                    var datalist = json.datalist;
                    var data_random = json.data_random;
                    var data_sum = json.data_sum;
                    
                    div.html("");
                    var list = div.append('<ul></ul>').find('ul');
                    for (kk in data_random) {
                        var html = "";
                        html += "<li id='list-"+kk+"'>";
                        html += " สุ่มครั้งที่ "+kk;
                        html += ' <i class="fa fa-spinner fa-spin"></i> กำลังสุ่ม';
                        html += "</li>";
                        
                        var list2 = list.append(html);
                    }
                    
                    var time = 200;
                    for (kk in data_random) {
                        var data = datalist[data_random[kk]];
                        var name = data.name;
                        
                        var html = " สุ่มครั้งที่ "+kk;
                        html += " = <b style='color:green'>"+name+"<b>";
                        
                        addList(kk, html, time);
                        time+=40;
                    }
                    
                    setTimeout(function() {
                        btn.prop("disabled",false);
                        btn.html('สุ่ม 100 ครั้ง');
                        
                         rows.each(function(k) {
                             var key = $(this).data("key");
                             var col_1 =   $(this).closest("tr").find('td.col-1');
                             var col_2 =   $(this).closest("tr").find('td.col-2');
                             
                             var data = datalist[key];
                             var stock = data.stock;
                             var sum = data_sum[key];
                             var total = stock-sum;
                             col_1.html(sum);
                             col_2.html(total);
                         }); 
                    }, time);                    
                }
            });
        }); 
    });
    </script>
 <?php }else if($action=="random"){ ?>
<?php
    function w_rand($samples, $weights) {  
        if(count($samples) != count($weights)){ 
            return null; 
        } 
        
        $sum    = array_sum($weights) * 1;
        $rand   = mt_rand(1, $sum);  
        
        foreach ($weights as $i=>$w){  
            $weights[$i] = $w * 1 + ( $i > 0 ? $weights[$i-1] : 0 );  
            if ($rand <= $weights[$i] ) {
                 return $samples[$i]; 
            }  
        }  
    }  

    $max =100;
    $random = array();
    $sum = array();
    $data_random = array();
    $data_stock2 = $data_stock ;
      for($i=1;$i<=$max;$i++){
          //$random2 = w_rand($data_stock2, $data_chance);
          //echo $random2;
          //echo "<br>";
      
         $random =  array_rand($data_stock2); 
          if(isset($sum[$random])){
              $sum[$random]--;
          }else{
              $sum[$random]=$data_stock[$random]-1;
          }
          
          if($sum[$random]==1){
              unset($data_stock2[$random]);
          }
          
          
       $data_random[$i] = $random;
    }
        
    $data_sum = array_count_values($data_random);
    
    echo  json_encode(array("datalist"=>$array,"data_random"=>$data_random,"data_sum"=>$data_sum));
?>
 
 <?php } ?>