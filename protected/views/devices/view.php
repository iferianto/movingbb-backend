<?php
/* @var $this DevicesController */
/* @var $model Devices */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->name,
);


?>

<h1>View Devices #<?php echo $model->id; ?></h1>
<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
	'htmlOptions'=>array(
		'class'=>''
	)
));
$this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills',
	'items'=>array(
        array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
		array('label'=>'Update', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('update',array('id'=>$model->id)), 'linkOptions'=>array('class'=>'')),
		array('label'=>'Delete', 'icon'=>'icon-plus', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array('class'=>'')),		
	),
));
$this->endWidget();
?>
<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'uniqueid',
		'status',
		'lastupdate',
		'positionid',
		'notelp',
		'merek',
		'tipe',
		'port',
		'protocol',
		'settingan',
		'u_password',
		'u_fullname',
		'u_email',
		'u_address',
	),
)); ?>
