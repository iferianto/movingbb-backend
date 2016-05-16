<?php
/* @var $this RoadweightController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Roadweights',
);

$this->menu=array(
	array('label'=>'Create Roadweight', 'url'=>array('create')),
);
?>

<h1>Roadweights</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
