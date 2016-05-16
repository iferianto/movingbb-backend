<?php

	Yii::import('zii.widgets.grid.CGridView');



	/**

	* @author Nikola Kostadinov

	* @license MIT License

	* @version 0.3

	*/	

	class EExcelView extends CGridView

	{

		//Document properties

		public $creator = 'Unsoed';
		public $title = null;
		public $subject = 'Subject';
		public $description = '';
		public $category = '';



		//the PHPExcel object

		public $objPHPExcel = null;

		public $libPath = 'ext.phpexcel.Classes.PHPExcel'; //the path to the PHP excel lib



		//config

		public $autoWidth = true;

		public $exportType = 'Excel5';

		public $disablePaging = true;

		public $filename = null; //export FileName

		public $stream = true; //stream to browser

		public $grid_mode = 'grid'; //Whether to display grid ot export it to selected format. Possible values(grid, export)

		public $grid_mode_var = 'grid_mode'; //GET var for the grid mode

		

		//buttons config

		public $exportButtonsCSS = 'summary';

		public $exportButtons = array('Excel2007');

		public $exportText = 'Export to: ';



		//callbacks

		public $onRenderHeaderCell = null;

		public $onRenderDataCell = null;

		public $onRenderFooterCell = null;

		

		//mime types used for streaming

		public $mimeTypes = array(

			'Excel5'	=> array(

				'Content-type'=>'application/vnd.ms-excel',

				'extension'=>'xls',

				'caption'=>'Export Excel(*.xls)',

			),

			'Excel2007'	=> array(

				'Content-type'=>'application/vnd.ms-excel',

				'extension'=>'xlsx',

				'caption'=>'Export Excel(*.xlsx)',				

			),

			'PDF'		=>array(

				'Content-type'=>'application/pdf',

				'extension'=>'pdf',

				'caption'=>'Export PDF(*.pdf)',								

			),

			'HTML'		=>array(

				'Content-type'=>'text/html',

				'extension'=>'html',

				'caption'=>'Export HTML(*.html)',												

			),

			'CSV'		=>array(

				'Content-type'=>'application/csv',			

				'extension'=>'csv',

				'caption'=>'Export CSV(*.csv)',												

			)

		);

		public $wasuploaded=0;
		public $taskname="";

		public function init()

		{

			if(isset($_GET[$this->grid_mode_var]))
			$this->grid_mode = $_GET[$this->grid_mode_var];

			if(isset($_GET['exportType']))
			$this->exportType = $_GET['exportType'];

			$lib = Yii::getPathOfAlias($this->libPath).'.php';

			if(($this->grid_mode=='export'||$this->grid_mode=='exportsample'||$this->grid_mode=='import') and !file_exists($lib)) {
				$this->grid_mode = 'grid';
				Yii::log("PHP Excel lib not found($lib). Export disabled !", CLogger::LEVEL_WARNING, 'EExcelview');
			}

			
			if($this->grid_mode=='export'||$this->grid_mode=='exportsample'||$this->grid_mode=='import')
			{			
		
				ini_set('memory_limit', -1);
				set_time_limit(0);   
				ini_set('mysql.connect_timeout','0');   
				ini_set('max_execution_time', '0');   
				ignore_user_abort(true);
				

				//parent::init();
				//Autoload fix
				spl_autoload_unregister(array('YiiBase','autoload'));             
				Yii::import($this->libPath, true);

				$this->objPHPExcel = new PHPExcel();
				spl_autoload_register(array('YiiBase','autoload'));  

				if(isset($_FILES['fileimport']) && is_uploaded_file($_FILES['fileimport']['tmp_name']) ){
					$file=$_FILES['fileimport']['tmp_name'];
					$this->handleupload($file);
				}				

				
				$this->title = $this->title ? $this->title : Yii::app()->getController()->getPageTitle();
				
				if($this->grid_mode=='import') parent::init();
				else $this->initColumns();

				

				// Creating a workbook
				$this->objPHPExcel->getProperties()->setCreator($this->creator);
				$this->objPHPExcel->getProperties()->setTitle($this->title);
				$this->objPHPExcel->getProperties()->setSubject($this->subject);
				$this->objPHPExcel->getProperties()->setDescription($this->description);
				$this->objPHPExcel->getProperties()->setCategory($this->category);
			
			
			} else{
				
				parent::init();
			}
			

		}



		public function renderHeader()

		{

			$a=0;

			foreach($this->columns as $column)

			{

				$a=$a+1;

				if($column instanceof CButtonColumn)

					$head = $column->header;

				elseif($column->header===null && $column->name!==null)

				{

					if($column->grid->dataProvider instanceof CActiveDataProvider)

						$head = $column->grid->dataProvider->model->getAttributeLabel($column->name);

					else

						$head = $column->name;

				} else

					$head =trim($column->header)!=='' ? $column->header : $column->grid->blankDisplay;



				$cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a)."1" ,$head, true);

				if(is_callable($this->onRenderHeaderCell))

					call_user_func_array($this->onRenderHeaderCell, array($cell, $head));				

			}			

		}



		public function renderBody()
		{

			if($this->disablePaging) //if needed disable paging to export all data

			$this->dataProvider->pagination = false;
			
			if($this->grid_mode == 'exportsample'){
			 $this->dataProvider->criteria->limit=2;
			 $this->dataProvider->pagination=false;			 
			}
			

			$data=$this->dataProvider->getData();
			
			$n=count($data);

			if($n>0)
			{
				for($row=0;$row<$n;++$row)
					$this->renderRow($row);
			}
            return $n;
		}



		public function renderRow($row)

		{

			$data=$this->dataProvider->getData();			

			$a=0;

			foreach($this->columns as $n=>$column)
			{

				if($column instanceof CLinkColumn)
				{

					if($column->labelExpression!==null)

						$value=$column->evaluateExpression($column->labelExpression,array('data'=>$data[$row],'row'=>$row));

					else

						$value=$column->label;

				} elseif($column instanceof CButtonColumn)

					$value = ""; //Dont know what to do with buttons

				elseif($column->value!==null) 

					$value=$this->evaluateExpression($column->value ,array('data'=>$data[$row]));

				elseif($column->name!==null) { 

					//$value=$data[$row][$column->name];

					$value= CHtml::value($data[$row], $column->name);

				    $value=$value===null ? "" : $column->grid->getFormatter()->format($value,'raw');

                }             



				$a++;

				$cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a).($row+2) , strip_tags($value), true);				

				if(is_callable($this->onRenderDataCell))

					call_user_func_array($this->onRenderDataCell, array($cell, $data[$row], $value));

			}				

		}



		public function renderFooter($row)

		{

			$a=0;

			foreach($this->columns as $n=>$column)

			{

				$a=$a+1;

                if($column->footer)

                {

					$footer =trim($column->footer)!=='' ? $column->footer : $column->grid->blankDisplay;



				    $cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a).($row+2) ,$footer, true);

				    if(is_callable($this->onRenderFooterCell))

					    call_user_func_array($this->onRenderFooterCell, array($cell, $footer));				

                }

			}  

		}		



		public function handleupload($tmpfile){
			$timeid=date('ymdhi');
			$model=$this->dataProvider->model;
			$modelname=$this->dataProvider->id;
			$tablename=$model->tableName();			
			$dest=Yii::getPathOfAlias('webroot')."/protected/runtime/import".$timeid."-".$tablename.".xls";
			$this->taskname="importxls".$timeid;
			if(move_uploaded_file($tmpfile,$dest)){				
				$tasktime=date("H:i:s",time()+10);				
				$endtime=date("H:i:s",time()+100);				
				/*
				$cmd="SCHTASKS /Create /TN \"".$this->taskname."\" /TR \"".$command."\" /ru imam /rp imam /SC once /ST \"".$tasktime."\" /F";
				exec($cmd);
				echo $cmd."<br><br>";
				$cmd="SCHTASKS /run /TN \"".$this->taskname."\"";
				exec($cmd);				
				//d:\xampp\php\php.exe -q d:\xampp\htdocs\eyangexpress.com\cron.php importxlsx index --taskname=importxls1511220203
				echo $cmd."<br><br>";
				*/

				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					$command="d:\\xampp\\php\\php.exe -q d:\\xampp\\htdocs\\eyangexpress.com\\cron.php importxlsx index --taskname=".$this->taskname;
					$WshShell = new COM("WScript.Shell"); 
					$oExec = $WshShell->Run("cmd /C ".$command, 0, false); 
				} else {
					$command="nohup php -q /home/imam/eyang/eyang/cron.php importxlsx index --taskname=".$this->taskname." &";
					system($command);
				}				
				
				$task=new Task();
				$task->taskname=$this->taskname;
				$task->command=$command;
				$task->parameter=serialize(array('xlsfile'=>$dest,'modelname'=>$modelname,'tablename'=>$tablename));
				$task->starttime=date('Y-m-d H:i:s');
				$task->status='start';
				$task->save();
				
			}else{
				echo "<script>alert('Upload gagal');</script>";				
			}
			
			/*
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($tmpfile);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); 
			$highestColumn = $objWorksheet->getHighestColumn(); 
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
			$rows = array();
			
			$this->wasuploaded==-1;
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
				Yii::app()->db->createCommand($sql)->execute();
			}
			*/
			$this->wasuploaded=1;
		}
		
		public function run()
		{
				if($this->grid_mode == 'import'){
					if($this->wasuploaded==1){		
						?>
						<style>
						#progressbar{height:30px;width:500px;color:#0000ff;border:1px #999 solid}
						.onprogress{background:url(images/loading6.gif) 10px 5px no-repeat;padding-left:140px;}
						.doneprogress{background:transparent;padding:4px}
						</style>
						<div id="flash" style="color:blue;font-weight:bold">Data Berhasil di Queque Import #<?php echo $this->taskname?>, Cek progressbar untuk status import</div>
						<div id="progressbar" class="onprogress">on process import, please wait...</div><br><br>
						<script>		
						$(document).ready(function(){
							var refreshId=setInterval(function(){
								var url="<?php 
								echo Yii::app()->createAbsoluteUrl("uploadajax/cekproggress",array("taskname"=>$this->taskname));
								?>";
								$.getJSON(url, function(data) {
								  if(data.status=='done'){
									  $("#progressbar").html("upload selesai");
									  $("#progressbar").removeClass("onprogress").addClass("doneprogress");
									  clearInterval(refreshId);
									  alert("Upload selesai");
									  document.location="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->id."/index");?>";
								  }
								});
								
							}, 500);						
						});						
						</script><?php
					}elseif($this->wasuploaded==-1){		
						?><div id="flash" style="color:red;font-weight:bold">Data Gagal di Upload!</div>
						<?php		
					}
					
					$model=$this->dataProvider->model;
					
					if(!$this->wasuploaded){
					
					?><div class="form" style="margin-bottom:20px;border:1px #999 solid;padding:20px">
					<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'harga-form',
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array('enctype'=>'multipart/form-data')
					)); ?>
					<h1>Upload File Excel</h1>
					<p class="note">Struktur Excel harus sama dengan format <b>Sample Export nya</b></p>
					<div class="row">
					<label>File excel (.xlsx)</label>
					<?php echo CHtml::fileField('fileimport'); ?>
					</div>	
					<div class="row buttons">
						<?php echo CHtml::submitButton('Upload Data',array('class'=>'btn btn-primary')); ?>
						<?php echo CHtml::button('Cancel',array('class'=>'btn btn-warning','onclick'=>"document.location='".Yii::app()->controller->createUrl('index')."'")); ?>
					</div>
					<?php $this->endWidget(); ?>
					</div><!-- form -->					
					<?php
					
					}
					
					parent::run();
					
				}elseif($this->grid_mode == 'export' || $this->grid_mode == 'exportsample'){
					$this->renderHeader();
					$row = $this->renderBody();
					$this->renderFooter($row);
					//set auto width
					if($this->autoWidth)
						foreach($this->columns as $n=>$column)
							$this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($n+1))->setAutoSize(true);
							
					//create writer for saving
					$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->exportType);

					if(!$this->stream) $objWriter->save($this->filename);
					else //output to browser
					{
						if(!$this->filename) $this->filename = $this->title;
						$this->cleanOutput();
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
						header('Content-type: '.$this->mimeTypes[$this->exportType]['Content-type']);
						header('Content-Disposition: attachment; filename="'.$this->filename.'.'.$this->mimeTypes[$this->exportType]['extension'].'"');
						header('Cache-Control: max-age=0');				
						$objWriter->save('php://output');			
						Yii::app()->end();
					}
				} else{
					parent::run();
				}
		}



		/**

		* Returns the coresponding excel column.(Abdul Rehman from yii forum)

		* 

		* @param int $index

		* @return string

		*/

		public function columnName($index)

		{

			--$index;

			if($index >= 0 && $index < 26)

				return chr(ord('A') + $index);

			else if ($index > 25)

				return ($this->columnName($index / 26)).($this->columnName($index%26 + 1));

				else

					throw new Exception("Invalid Column # ".($index + 1));

		}		

		

		public function renderExportButtons()

		{

			foreach($this->exportButtons as $key=>$button)

			{

				$item = is_array($button) ? CMap::mergeArray($this->mimeTypes[$key], $button) : $this->mimeTypes[$button];

				$type = is_array($button) ? $key : $button;

				$url = parse_url(Yii::app()->request->requestUri);

				//$content[] = CHtml::link($item['caption'], '?'.$url['query'].'exportType='.$type.'&'.$this->grid_mode_var.'=export');

				if (key_exists('query', $url))

				    $content[] = CHtml::link($item['caption'], '?'.$url['query'].'&exportType='.$type.'&'.$this->grid_mode_var.'=export');          

				else

				    $content[] = CHtml::link($item['caption'], '?exportType='.$type.'&'.$this->grid_mode_var.'=export');				

			}

			if($content)

				echo CHtml::tag('div', array('class'=>$this->exportButtonsCSS), $this->exportText.implode(', ',$content));	



		}			

		
		public function renderEximButtons()
		{

			foreach($this->exportButtons as $key=>$button)

			{

				$item = is_array($button) ? CMap::mergeArray($this->mimeTypes[$key], $button) : $this->mimeTypes[$button];

				$type = is_array($button) ? $key : $button;

				$url = parse_url(Yii::app()->request->requestUri);

				//$content[] = CHtml::link($item['caption'], '?'.$url['query'].'exportType='.$type.'&'.$this->grid_mode_var.'=export');

				if (key_exists('query', $url)){

				    $content[] = '<li>'.CHtml::link($item['caption'], '?'.$url['query'].'&exportType='.$type.'&'.$this->grid_mode_var.'=export').'</li>';          
				    $content[] = '<li>'.CHtml::link('Sample '.$item['caption'], '?'.$url['query'].'&exportType='.$type.'&'.$this->grid_mode_var.'=exportsample').'</li>';          
				    $content[] = '<li>'.CHtml::link('Import Excel(*.xlsx)', '?'.$url['query'].'&exportType='.$type.'&'.$this->grid_mode_var.'=import').'</li>';          

				}else{

				    $content[] = '<li>'.CHtml::link($item['caption'], '?exportType='.$type.'&'.$this->grid_mode_var.'=export').'</li>';				
				    $content[] = '<li>'.CHtml::link('Sample '.$item['caption'], '?exportType='.$type.'&'.$this->grid_mode_var.'=exportsample').'</li>';				
				    $content[] = '<li>'.CHtml::link('Import Excel(*.xlsx)', '?exportType='.$type.'&'.$this->grid_mode_var.'=import').'</li>';				
				}

			}

			if($content)

				echo CHtml::tag('div', array('class'=>$this->exportButtonsCSS), '<ul class="nav nav-pills">'.implode(' ',$content).'</ul>');	



		}			

		
		

		/**

		* Performs cleaning on mutliple levels.

		* 

		* From le_top @ yiiframework.com

		* 

		*/

		private static function cleanOutput() 

		{

            for($level=ob_get_level();$level>0;--$level)

            {

                @ob_end_clean();

            }

        }		





	}