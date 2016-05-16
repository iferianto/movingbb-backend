<?php

//require php_openssl extension
//d:\xampp\php\php.exe -q cron.php importxlsx index --taskname=test

class ImportxlsxCommand extends CConsoleCommand {
	
	public function actionIndex($taskname){
		
		ini_set('memory_limit', '2000M');
		set_time_limit(0);
		ignore_user_abort(true);
		
		
		//disable autoload yii
		spl_autoload_unregister(array('YiiBase', 'autoload'));

        //load xls
		Yii::import('ext.phpexcel.Classes.PHPExcel', true);

        //load yii
        spl_autoload_register(array('YiiBase', 'autoload'));

		
		$task=Task::model()->findBySql("select * from task where taskname='".$taskname."'");
		if($task==null){			
		  die("taskname ".$taskname." tidak ditemukan");
		}
		
		if(empty($task->starttime)){$task->saveAttributes(array("starttime"=>date('Y-m-d H:i:s')));}
		
		echo "start cronjob import xlsx\r\n";		
		$command=$task->command;
		$parameter=unserialize($task->parameter);
		$excelfile=(isset($parameter["xlsfile"])?$parameter["xlsfile"]:"");
		$modelname=(isset($parameter["modelname"])?$parameter["modelname"]:"");
		$tablename=(isset($parameter["tablename"])?$parameter["tablename"]:"");
		if(empty($excelfile)||(!empty($excelfile) && !file_exists($excelfile))){
			die("File ".$excelfile." tidak ditemukan\r\n");			
		}
		if(!empty($modelname) && !empty($tablename) ){
			$model=new $modelname;			
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($excelfile);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); 
			$highestColumn = $objWorksheet->getHighestColumn(); 
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
			$rows = array();
			$columns=$model->getTableSchema()->getColumnNames();			
			for ($row = 2; $row <= $highestRow; ++$row) {
				$col=0;
				$field="";
				$values="";
				$comma="";
				foreach($columns as $name)
				{
					if(isset($name)){
						$data="";
						if($col<$highestColumnIndex){
							$data=addslashes($objWorksheet->getCellByColumnAndRow($col, $row)->getValue());
						}
						$values.=$comma."'".addslashes($data)."'";
						$field.=$comma.$name;
						$comma=",";				
					}
					$col++;
				}
				$sql="replace into ".$tablename."(".$field.")values(".$values.")";
				//echo $sql."\n";
				Yii::app()->db->createCommand($sql)->execute();
			}
			
			
			$task->status="done";
			$task->endtime=date("Y-m-d H:i:s");
			$task->save();
			
			echo "done import\r\n";
			
			/*
			$cmd="SCHTASKS /end /TN \"".$taskname."\"";
			exec($cmd);		
			//$cmd="SCHTASKS /delete /TN \"".$taskname."\" /F";
			//exec($cmd);
			*/
			
			@unlink($excelfile);

		}
		
		
	}
		
}


?>