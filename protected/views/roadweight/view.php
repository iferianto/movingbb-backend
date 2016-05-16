<?php
/* @var $this RoadweightController */
/* @var $model Roadweight */

$this->breadcrumbs=array(
	'Roadweights'=>array('index'),
	$model->name,
);


?>

<h1>View Roadweight #<?php echo $model->osm_id; ?></h1>
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
		array('label'=>'Update', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('update',array('id'=>$model->osm_id)), 'linkOptions'=>array('class'=>'')),
	),
));
$this->endWidget();
?>
<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'osm_id',
		'name',
		'weight',
		'latitude',
		'longitude',
	),
)); ?>
