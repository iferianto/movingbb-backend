<?php

function showcustomformerror($model){
 $error=$model->getErrors();
 ?><div id="popup12">
 <div id="war2">
    <div id="war2title"><div id="war2titlecap">Kesalahan Input Data</div><div id="war2btn"><a href="#" onclick="closewarning()" id="btnwarning">X</a></div></div>
	<div id="war2content">
	  <div id="war2pad"></div>
	</div>
 </div> 
 </div><script>
 function closewarning(){
	 $("#popup12").hide();
 }
 </script><style>
 #popup12{display:none;position:absolute !important;top:0px;left:0px;z-Index:2000;width:100%;height:100%;background:rgba(100,100,100,0.5)}
 #war2{margin:100px auto;width:400px;min-height:100px;border:1px #999 solid;}
 #war2title{float:left;background:#FF0000;color:#fff;width:100%}
 #war2titlecap{float:left;width:350px;padding:2px}
 #war2btn{float:right;width:20px;}
 #war2btn a{color:#fff;text-decoration:none;float:right;padding:2px 10px;background:#333}
 #war2btn a:hover{color:#000;background:#ffff00}
 #war2content{float:left;background:#ffeeee;color:#000;width:100%;min-height:100px}
 #war2pad{padding:4px}
 </style>
 <script>
 var msgx="";
 jQuery(function($){
 <?php 
 if(count($error)>0){ 
 	  echo "msgx+=\"Ada error berikut:<ul>\";";
	  foreach($error as $r=>$msg){
		  echo "msgx+=\"<li>".$msg[0]."</li>\";";
	  }
	  echo "msgx!=\"</ul>\";";
	  echo "\$(\"#war2pad\").html(msgx);";
	  echo "\$(\"#popup12\").show();";
 }
 ?>});</script><?php
 
}
 

function showcustomformerror1($model){
 $error=$model->getErrors();
 if(count($error)>0){ ?><div id="popup12">
 <div id="war2">
    <div id="war2title"><div id="war2titlecap">Kesalahan Input Data</div><div id="war2btn"><a href="#" onclick="closewarning()" id="btnwarning">X</a></div></div>
	<div id="war2content">
	  <div id="war2pad">
	  <?php 
	  echo "Ada error berikut:<ul>";
	  foreach($error as $r=>$msg){
		  echo "<li>".$msg[0]."</li>";
	  }
	  echo "</ul>";
	  ?></div>
	</div>
 </div> 
 </div><script>
 function closewarning(){
	 $("#popup12").hide();
 }
 </script><style>
 #popup12{position:absolute !important;top:0px;left:0px;z-Index:2000;width:100%;height:100%;background:rgba(100,100,100,0.5)}
 #war2{margin:100px auto;width:400px;min-height:100px;border:1px #999 solid;}
 #war2title{float:left;background:#FF0000;color:#fff;width:100%}
 #war2titlecap{float:left;width:350px;padding:2px}
 #war2btn{float:right;width:20px;}
 #war2btn a{color:#fff;text-decoration:none;float:right;padding:2px 10px;background:#333}
 #war2btn a:hover{color:#000;background:#ffff00}
 #war2content{float:left;background:#ffeeee;color:#000;width:100%;min-height:100px}
 #war2pad{padding:4px}
 </style>
 <?php }
}
 
function fixinputrupiah($data){
  $data=str_replace(",","",$data);
  return $data;
}

function is_linux(){
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')return false;
  else return true;
  //if(strpos($_SERVER['DOCUMENT_ROOT'],"/")===false) return false;
  //else return true;
}

function fixrupiahcomma($x){
 $x=str_replace(".",",",$x);
 $x=preg_replace("/\,00$/","",$x);
 return $x;
}

function angkakechar($c){
  $angka="JABCDEFGHI";
  $ret="";
  for($i=0;$i<strlen($c);$i++){
    $e=$c{$i};$ret.=$angka{$e};
  }
  return $ret;
}

function charkeangka($c){
  $angka="JABCDEFGHI";
  $ret="";
  for($i=0;$i<strlen($c);$i++){
    $e=$c{$i};
    $pos=strpos($angka,$e);
    $ret.=$pos;
  }
  return $ret;
}

function tanggaldecode($tgl){
 $t=explode(":",$tgl);
 $ret="";$s="";
 foreach($t as $x){
   $ret.=$s.charkeangka($x);
   $s="/";
 }
 return $ret;
}


function tanggalencode($tgl){
 $a=explode(" ",$tgl);
 if(isset($a[0]))$tgl=$a[0];
 $a=explode("/",$tgl);
 if(is_array($a) && count($a)==3){
   $a0=angkakechar($a[0]);
   $a1=angkakechar($a[1]);
   $a2=angkakechar(substr($a[2],2,2));
   $tgl=$a0.":".$a1.":".$a2;
 }
 return $tgl;
}

function getmyfile($model,$field,$type=''){
  $path=Yii::app()->runtimePath;
  $basepath=Yii::getPathOfAlias('application');
  $savepath=substr($path,strlen($basepath));

  if(is_linux()){ $sp="/"; $sprep="\\";}
  else {$sp="\\"; $sprep="/";}


  $imagepath=$path.$sp."imagedata";
  if(!is_dir($imagepath)){@mkdir($imagepath);@chmod($imagepath,0777);}
  $modelname=get_class($model);
  if($type=='image/jpeg')$ext=".jpg";
  elseif($type=='image/png')$ext=".png";
  elseif($type=='Application/pdf')$ext=".pdf";
  else $ext="";
  
  $data=$model->{$field};
  $len=strlen($data);
  //data is blog image, save to local
  if($len>255){
    $fname=substr($data,50);
    $fileid=md5($data);
    $target=$imagepath.$sp.$modelname."-".$fileid.$ext;  
    $fp=fopen($target,"w+");   fwrite($fp,$data);
    fclose($fp);   
    $targetsave=$savepath.$sp."imagedata".$sp.$modelname."-".$fileid.$ext; 
    $model->{$field}=$targetsave;
    $model->save();
  }else{
    $data=str_replace($basepath,"",$data);
    $data=str_replace($sprep,$sp,$data);
    $target=$basepath.$data;  
  }

  if(file_exists($target)){
    return file_get_contents($target);  
  }

  

}

function save_upload_file($model,$file,$targetname="",$content=""){
  $path=Yii::app()->runtimePath;
  $basepath=Yii::getPathOfAlias('application');
  $savepath=substr($path,strlen($basepath));

  if(is_linux()){ $sp="/"; $sprep="\\";}
  else {$sp="\\"; $sprep="/";}


  $imagepath=$path.$sp."imagedata";
  if(!is_dir($imagepath)){@mkdir($imagepath);@chmod($imagepath,0777);}
  $modelname=get_class($model);$ext=substr($file->name,strrpos($file->name,"."));
  
  $target=$imagepath.$sp.$modelname."-".md5($file->name.$targetname).$ext;
  $targetsave=$savepath.$sp."imagedata".$sp.$modelname."-".md5($file->name.$targetname).$ext;
  
  if(is_file($target))@unlink($target);
  if(strlen($content)>0){
    $fp=@fopen($target,"w+");@fwrite($fp,$content);fclose($fp);
  }else @copy($file->tempName,$target);  
  @chmod($target,0777);
  return $targetsave;
}

function spantext($txt,$length){
  $txt=trim($txt);
  $span_length=$length-strlen($txt);
  if($span_length>0) {
    $span_left=($span_length/2);if($span_left<0)$span_left=0;
    $span_right=$span_length-$span_left;if($span_right<0)$span_right=0;
    $txt=str_repeat(" ",$span_left).$txt.str_repeat(" ",$span_right);
  }
  return $txt;
}


function strcuttime($str=""){
 $pos=strpos($str," ");
 if($pos>0) $str=substr($str,0,$pos);
 return $str;
}
function cuttime($str){return strcuttime($str);}

function getdetailtrjurnal($no_voucher){
 $sql=sprintf("select sum(debet) as sdebet,sum(kredit) as skredit from trjurnal where no_voucher='%s'",$no_voucher);
 $hasil=Yii::app()->db->createCommand($sql)->queryAll();
 if($hasil!=null){
  $ret=$hasil[0]['skredit'];
  $ret2=$hasil[0]['skredit'];
  if($ret<$ret2)$ret=$ret2;
 }else $ret=0;
 return $ret;
}

function getintbulan($sp,$tgl){
 $t=explode($sp,$tgl);
 if(isset($t[1]))$ret=((integer)$t[1]);else $ret=0;
 return $ret;
}

function getallbulanlist(){
 return array(1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember');
}
function dropdownfilterbulan($model,$tgl){
 $bulanlist=getallbulanlist();
 return Chtml::dropDownList('Msjurnal[bulan]',
       $model->bulansel,
       $bulanlist,
       array(
          'empty' => '--pilih--',
          'style'=>'width:100px',
       )
 );
}


function formatrupiah($rp,$decimal=0){
  if(!is_numeric($rp)) $rp=0;
  if(!is_numeric($decimal)) $decimal=0; 
  return number_format($rp,$decimal,',','.'); 
}    


function terbilang($angka) {
    if($angka<0)return "";
    $angka = (float)$angka;
    $bilangan = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
    );
 
    if ($angka < 12) {
        return $bilangan[$angka];
    } else if ($angka < 20) {
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        return sprintf('seratus %s', terbilang($angka - 100));
    } else if ($angka < 1000) {
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        return trim(sprintf('seribu %s', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
 
        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {                        
    // bilangan 'triliun'                          
    $hasil_bagi = $angka / 1000000000000;                          
    $hasil_mod = fmod($angka, 1000000000000);                          
    return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));                      
    } else {                            
      return $angka;
    }                 
}                

function stringDMY2MysqlDate($delim,$str){
        if(is_array($str)) return "";
        $dt=explode($delim,$str);
	$day=(integer)(isset($dt[0])?$dt[0]+0:1);
	$month=(integer)(isset($dt[1])?$dt[1]+0:1);
        $xa=(isset($dt[2])?explode(" ",$dt[2]):"");
        $wk=(isset($xa[1])?" ".$xa[1].":00":"");
		$year=(integer)(isset($xa[0])?trim($xa[0]):2000);
		return $year."-".$month."-".$day.$wk;
}

function stringMysqlDate2TimeInteger($str){
	    $dt=explode("-",$str);
		$day=(integer)(isset($dt[2])?$dt[2]+0:1);
		$month=(integer)(isset($dt[1])?$dt[1]+0:1);
        $xa=(isset($dt[0])?explode(" ",$dt[0]):"");$wk=(isset($xa[1])?" ".$xa[1]:"");
		$year=(integer)(isset($xa[0])?trim($xa[0]):2000);
        $wk=explode(":",$wk);
        $hour=(integer)(isset($wk[0])?$wk[0]:12);
        $min=(integer)(isset($wk[1])?$wk[1]:0);
        $sec=(integer)(isset($wk[2])?$wk[2]:0);
		return mktime($hour, $min, $sec, $month,$day,$year);
	}

function stringMysqlDate2DMY($str){
	    $dt=explode("-",$str);
        $xa=(isset($dt[2])?explode(" ",$dt[2]):"");
		$day=(integer)(isset($xa[0])?$xa[0]+0:1);
        $wk=(isset($xa[1])?" ".$xa[1]:""); 
		$month=(integer)(isset($dt[1])?$dt[1]+0:1);
		$year=(integer)(isset($dt[0])?trim($dt[0]):2000);
		return date('d/m/Y', mktime(12, 0, 0, $month,$day,$year)).$wk;
	}


function stringMysqlDate2DMY2($str){
            $dt=explode("-",$str);
        $xa=(isset($dt[2])?explode(" ",$dt[2]):"");
                $day=(integer)(isset($xa[0])?$xa[0]+0:1);
        $wk=(isset($xa[1])?" ".$xa[1]:"");
                $month=(integer)(isset($dt[1])?$dt[1]+0:1);
                $year=(integer)(isset($dt[0])?trim($dt[0]):2000);
                return date('d/m/Y', mktime(12, 0, 0, $month,$day,$year));
        }


    
function replaceNLR($str){
 $str=str_replace(array("\r","\n")," ",$str);
 return $str;
}

function getnamabulan(){ return array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); }
function tglsekarangdmy(){
 $namabulan=getnamabulan();return date('d')." ".$namabulan[date('m')]." ".date('Y');
}

function Myisfloat($f){ return ($f == (string)(float)$f); }

function myimagecopy_autoresize($imagesource,$imagedest,$maxwidth=100,$maxheight=100,$quality=100){
 /*get image information*/
 $image=getImageSize($imagesource);$width=$image[0];$height=$image[1];$type=$image[2];
 /*select handle*/
 switch($type){
  /* 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP */
  case 1:
   $functionhandle="imagecreatefromgif";
   $createhandle="imagecreatefromgif";
   $outputhandle="imagegif";
   break;
  case 2:
   $functionhandle="imagecreatefromjpeg";
   $createhandle="imagecreatefromjpeg";
   $outputhandle="imagejpeg";
   break;
  case 3:
   $functionhandle="imagecreatefrompng";
   $createhandle="imagecreatefrompng";
   $outputhandle="imagepng";
   break;
  default:
   $createhandle=false;
 }
 /*copy image if not need resize*/
 if(!$createhandle) return false;
 /*calculation resize ratio*/
 if($width<$maxwidth && $height<$maxheight) $ratio=1;
 elseif($width>$height) $ratio=$maxwidth/$width;
 else $ratio=$maxheight/$height;

 $destwidth =$ratio*$width;
 $destheight=$ratio*$height;

 /*create new images*/
 $imgdest=@imagecreatetruecolor ($destwidth,$destheight);
 if(function_exists($functionhandle)){
  $imgsrc=@$createhandle($imagesource);if(!$imgsrc)return false;
  /*flush image information to destination files*/
  $ret=@imagecopyresized($imgdest,$imgsrc,0,0,0,0,$destwidth,$destheight,$width,$height);
  if(!$ret)return false;
  if($quality>0) $ret=@$outputhandle($imgdest,$imagedest,$quality);
  else $ret=@$outputhandle($imgdest,$imagedest);
  return $ret;
 }
 return false;
}



?>