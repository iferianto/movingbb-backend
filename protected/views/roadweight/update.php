<?php
/* @var $this RoadweightController */
/* @var $model Roadweight */

$this->breadcrumbs=array(
	'Roadweight'=>array('index'),
	$model->name=>array('view','id'=>$model->osm_id),
	'Update',
);


?>
<h1>Update Roadweight <?php echo $model->osm_id; ?></h1>
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
	),
));
$this->endWidget();
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
