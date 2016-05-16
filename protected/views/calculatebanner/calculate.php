<?php
if(!empty($alert)){
 echo "<script>function myalert(){alert(\"".$alert."\");};setTimeout(\"myalert\",200);";
 echo "</script>";
}
?><style>
.blue{color:#0000ff}
.firstHeading{border-bottom:1px #000 solid;font-size:20px;color:#000;margin-bottom:10px}
</style>
<h1 class="firstHeading">Devices: #<?php if(isset($info['name'])) echo $info['name'];else echo "Unknown Object";?></h1>
<!--div id="bodyContent">
<p><?php
if(isset($info)){
 foreach($info as $key=>$val){
   echo $key." : <span class='blue'>".$val."</span><br>";
 }
}
?>
</p>
</div-->
<form method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl('calculatebanner');?>">
		<?php $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'date1',
                'name'=>'date1',
                'mode'=>'datetime', //use time,date,datetime
                'language'=>'id',
                'options'=>array(
                    'changeMonth'=>'true',
                    'changeYear'=>'true',
                    'yearRange' => '-99:+2',
                    'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                    'showOn'=>'both', // 'focus', 'button', 'both'
                    'dateFormat'=>'dd/mm/yy',
                    'value'=>date('dd/mm/yy'),
                    'theme'=>'redmond',
                    'buttonText'=>Yii::t('ui','Select form calendar'), 
                    'buttonImage'=>Yii::app()->request->baseUrl.'/images/icons.date.png', 
                    'buttonImageOnly'=>true,
                ),
                'htmlOptions'=>array(
                    'style'=>'vertical-align:top;width:150px',
                    'class'=>'span2',
                ),  
            ));?> To <?php $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'date2',
                'name'=>'date2',
                'mode'=>'datetime', //use time,date,datetime
                'language'=>'id',
                'options'=>array(
                    'changeMonth'=>'true', 
                    'changeYear'=>'true',   
                    'yearRange' => '-99:+2',        
                    'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                    'showOn'=>'both', // 'focus', 'button', 'both'
                    'dateFormat'=>'dd/mm/yy',
                    'value'=>date('dd/mm/yy'),
                    'theme'=>'redmond',
                    'buttonText'=>Yii::t('ui','Select form calendar'), 
                    'buttonImage'=>Yii::app()->request->baseUrl.'/images/icons.date.png', 
                    'buttonImageOnly'=>true,
                ),
                'htmlOptions'=>array(
                    'style'=>'vertical-align:top;width:150px',
                    'class'=>'span2',
                ),  
            ));?> 

<input type=hidden name=deviceid value="<?php if(!empty($info['id'])) echo $info['id'];?>">
<input type=submit value="Calc" class="btn btn-primary">
</form>
Rute Yang dilalui:
<style>
table#customers {
    border-collapse: collapse;
    border-spacing: 0;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 16px;
    width:auto;
}
#customers tr:nth-child(2n) {
    background-color: #f2f2f2;
}
#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
#customers th {
    background-color: #4caf50;
    color: white;
    padding-bottom: 11px;
    padding-top: 11px;
}
.total{font-size:14px;color:#000}
</style>
<?php

if(is_array($passroad) && count($passroad)>0){
  echo "<table id=\"customers\">";
  echo "<tr><th style=\"width:50px\">id</th><th style=\"width:300px\">Street Name</th><th>Score</th></tr>";
  foreach($passroad as $row){
   echo "<tr><td>".$row['osm_id']."</td><td>".$row['name']."</td><td>".$row['score']."</td></tr>";
  }
  echo "</table>";
  echo "<div class=\"total\">Total Score : <b style=\"color:blue\">".$totalscore."</b></div>";
}



?>
