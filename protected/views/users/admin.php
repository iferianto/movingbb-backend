<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Operator Users</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('ext.EExcelView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	//'template'=>'{eximbuttons}{summary}{items}{pager}',
	'template'=>'{exportButtons}{summary}{items}{pager}',
	'columns'=>array(
		'id',
		array('name'=>'name','htmlOptions'=>array('style'=>'width:100px')),
		array('name'=>'email','htmlOptions'=>array('style'=>'width:200px')),
		//'hashedpassword',
		//'salt',
		//'readonly',
		/*
		'admin',
		'map',
		'language',
		'distanceunit',
		'speedunit',
		'latitude',
		'longitude',
		'zoom',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
