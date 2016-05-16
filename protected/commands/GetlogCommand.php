<?php

//require php_openssl extension
//d:\xampp\php53\php.exe" -q d:\xampp\htdocs\yukdatang\cron.php importxlsx


class GetlogCommand extends CConsoleCommand {
	
	function ping($host)
	{
		exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
		return $rval === 0;
	}
	
	function test_content($host_port){
		// 900 Seconds = 15 Minutes
		$timeout=60; //1 menit timeout
		$url="http://".$host_port;
		//$url="http://www.google.com/";
		$result=false;
		try {
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$isi=curl_exec($ch);
			curl_close($ch);	
			if(!empty($isi) && $isi!=false)$result=true;			
		} catch (Exception $e) {
			$result=false;
		}	  
		return $result;
	}

    public function sendmail2($to,$subject,$content,$headers){
		//disable autoload yii
		spl_autoload_unregister(array('YiiBase', 'autoload'));

        //load swiftmailer
		require_once('protected/external/swiftmailer5/lib/swift_required.php');

        //load yii
        spl_autoload_register(array('YiiBase', 'autoload'));

		//$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
		//->setUsername('')
		//->setPassword('');
		$transport = Swift_SmtpTransport::newInstance('localhost', 25);
		
		$to=explode(",",$to);		
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance($subject)
		->setFrom(array('automailer@yukdatang.com' => 'automailer yukdatang'))
		->setTo($to)
		->setBody($content);
		//$result = $mailer->send($message);	
	}	

    public function sendmail($to,$subject,$content,$headers){
	   mail($to,$subject,$content,$headers);
	}	

	
	public function actionIndex(){
		$ceklog=$this->cek();

		ini_set('memory_limit', '2000M');
		set_time_limit(0);
		ignore_user_abort(true);
		
		echo "start cronjob absen\r\n";
		
        $mesinsx = Mesin::model()->findAll();
		$error="";
        foreach ($mesinsx as $m) {
	        $totallog = 0;
			$totalbaru = 0;
            $ip = $m->ippublik;
			$namamesin=$m->namamesin;
			$id=$m->id;
			$mulai = date('d/m/Y H:i:s');
			//$ipxa=explode(":",$ip);$ipx=$ipxa[0];
			$alive=$this->test_content($ip);			
			if(!$alive){
				$error.="-mesin ".$ip." / ".$namamesin." tidak bisa diakses\r\n";

echo "-mesin ".$ip." / ".$namamesin." tidak bisa diakses\r\n";

			}else{
				echo "@".$mulai.": request to ".$ip."\r\n";
				$options = array('location' => 'http://' . $ip . '/iWsService', 'uri' => 'http://www.zksoftware/Service/message/');
				//$client = new SoapClient($wsdl, array("connection_timeout" => 15));
				$client = new SoapClient(null, $options);
				$soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
				$response = $client->__doRequest($soapRequest, 'http://' . $ip . '/iWsService', '', '1.1');
				if (!empty($response)) {
					$c = simplexml_load_string($response);
					$totallog = $totallog + sizeof($c->Row);
					foreach ($c->Row as $data) {
						//insert ke database, cek dulu apakah log sudah ada
						$totalbaru++;
						$sql=sprintf("select insert_templog('%s','%s','%s',%d)",$data->DateTime,$data->PIN,$ip,$id);
						//echo $sql.";\r\n";
						Yii::app()->db->createCommand($sql)->execute();						
						//echo "coba insert \r\n";
					}
					
				}
				$akhir = date('d/m/Y H:i:s');
				echo "@".$akhir.": ".$ip." , finish\r\n";			
				
				
				//delete absen log in devices
				if($id>2){

/*
					$options = array('location' => 'http://' . $ip . '/iWsService', 'uri' => 'http://www.zksoftware/Service/message/');
					$client = new SoapClient(null, $options);
					$soapRequest = "<ClearData><ArgComKey xsi:type=\"xsd:integer\">ComKey</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
					$response = $client->__doRequest($soapRequest, 'http://' . $ip . '/iWsService', '', '1.1');
					if(!empty($response)){
						$c=simplexml_load_string($response);
						list($data)=$c->Row;
						echo "Result:".$data->Information."\n";
					}else{
						echo "Result:delete failed\n";
					}
*/

				}else{


 echo "ambil dari mesin lama yang belum diproses\r\n";


//$alive=$this->test_content("http://203.148.85.146:87/cekabsenlama.php");

$alive=$this->test_content("http://192.168.1.168/cekabsenlama.php");


if($alive){


 //ambil dari mssql log
// $url="http://203.148.85.146:87/cekabsenlama.php?tgl=".date("Y-m-d");

$url="http://192.168.1.168/cekabsenlama.php?tgl=".date("Y-m-d");
 $content=file_get_contents($url);
 if(!empty($content)){
  $dom = new DOMDocument();
  $dom->loadHTML($content);
  $els = $dom->getElementsByTagName('tr');
  $i=1;
  foreach($els as $el){
   if($i>1){
    $nodeName = strtolower($el->nodeName);
    if($nodeName=='tr'){
	  $tds=$el->getElementsByTagName('td');
	  $ar=array();
      foreach($tds as $td){
	    $ar[]=$td->nodeValue;
	  }
	  $pin=(isset($ar[1])?$ar[1]:'');
	  $waktu=(isset($ar[0])?$ar[0]:'');

	  $ip='mesinlama-lamabelumprocess';

	  $id=1;
	  if(!empty($pin) && !empty($waktu)){
 		$sql=sprintf("select insert_templog('%s','%s','%s',%d)",$waktu,$pin,$ip,$id);
		Yii::app()->db->createCommand($sql)->execute();
	  }
	}
   }
   $i++;
  }
 }
 //end ambil url


echo "ambil sudah proses\r\n";
// $url="http://203.148.85.146:87/cekabsenlama2.php?tgl=".date('Y-m-d');
 $url="http://192.168.1.168/cekabsenlama2.php?tgl=".date('Y-m-d');

 $content=file_get_contents($url);
 if(!empty($content)){
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $els = $dom->getElementsByTagName('tr');
        $i=1;
        foreach($els as $el){
           if($i>1){
            $nodeName = strtolower($el->nodeName);
            if($nodeName=='tr'){
                  $tds=$el->getElementsByTagName('td');
                  $ar=array();
                  foreach($tds as $td){
                    $ar[]=$td->nodeValue;
                  }
                  $pin=(isset($ar[1])?$ar[1]:'');
                  $waktu=(isset($ar[0])?$ar[0]:'');
//                  $ip='203.148.85.146:87';
	  $ip='mesinlama-lamasudahrocess';
                  $id=1;
                  if(!empty($pin) && !empty($waktu)){
                    $sql=sprintf("select insert_templog('%s','%s','%s',%d)",$waktu,$pin,$ip,$id);
                    Yii::app()->db->createCommand($sql)->execute();
               //     echo $sql.";\r\n";
                  }
            }
          }
          $i++;
        }
 }


}






				}
				//end id
			
}

        }



		if(!empty($error) && $ceklog){
			echo "sending error log\r\n";
			$headers = 'From: automailer@yukdatang.com' . "\r\n" .
			'Reply-To: iferianto@yahoo.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			$subject="Error finger @".date('d/m/Y H:i:s')."  tidak bisa diakses";
			$to="iferianto@yahoo.com,wenny@javadigital.co.id,eko@indotrans.net.id";
			$error="Pesan otomatis ini akan dikirimkan tiap 30 menit ketika ada erorr koneksi ke mesin, berikut detailnya:\r\n\r\n".$error."\r\n\r\nTolong dibantu, terimakasih";
			$this->sendmail($to,$subject,$error,$headers);
		}
		echo "total row inserted ".$totallog."\r\n";
		echo "@".date('H:i:s').": all done\r\n";

		//update lc dan A
		$time1="22:00:00";
		$time2="23:50:00";
		$now=date('H:i:s');
		if( strtotime($time1)<=strtotime($now) &&  strtotime($now)<=strtotime($time2)  )
		{
			$sql="update presensiharian set alasan=(case
			when ((tapmasuk>jadwalmasukakhir) and (potongan>0)) then 'LC'
			when ((tapkeluar<jadwalkeluarawal) and (potongan>0)) then 'LC'
			when ((tapmasuk is not null) and (tapkeluar is null)) then 'LC'		
			when ((tapmasuk is null) and (tapkeluar is not null)) then 'LC'		
			when ((tapmasuk is null) and (tapkeluar is null)) then 'A'		
			end)::text where (tanggal<=(now())::date) and alasan is null";
			Yii::app()->db->createCommand($sql)->execute();


                     $sql="select updatestatusmanual(idpresensiharian,'A') from presensiharian where
			(tapmasuk is null and tapkeluar is null) and (alasan='A') and (tanggal<=(now())::date)";
			Yii::app()->db->createCommand($sql)->execute();
	        }

	}

	//CEK LAST MAILER
	function cek(){
	      //delete sinkron log
	      //$sql="delete from logsinkron";
	      //$ret=Yii::app()->db->createCommand($sql)->execute();

              //get last sinkron
	      $sql="select getlastsinkrontime()";
 	      $ret=Yii::app()->db->createCommand($sql)->queryScalar();
	      $now=date('H:i:s');
	      $time1="05:00:00";$time2="06:00:00";
	      $time3="15:00:00";$time4="14:30:00";
              if($ret && strtotime($time1)<=strtotime($now) &&  strtotime($now)<=strtotime($time2)) return true;
	      elseif($ret && strtotime($time3)<=strtotime($now) &&  strtotime($now)<=strtotime($time4)) return true;
	      else return false;
	}

}



?>
