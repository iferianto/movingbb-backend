<?php
/* @var $this RoadweightController */
/* @var $model Roadweight */

$this->breadcrumbs=array(
	'Roadweight'=>array('index'),
	'Create',
);

?>
<h1>Create Roadweight</h1>
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