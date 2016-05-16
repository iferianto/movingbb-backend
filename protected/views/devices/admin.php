<?php
/* @var $this DevicesController */
/* @var $model Devices */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#devices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Devices</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('ext.EExcelView', array(
	'id'=>'devices-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	//'template'=>'{eximbuttons}{summary}{items}{pager}',
	'template'=>'{exportButtons}{summary}{items}{pager}',
	'columns'=>array(
		'id',
		'name',
		'uniqueid',
		'status',
		'lastupdate',
		'positionid',
		/*
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
		*/
		array(
			'htmlOptions'=>array('style'=>'width:100px'),
			'class'=>'CButtonColumn',
			'template'=>'{view}&nbsp;{update}&nbsp;{delete}&nbsp;{maps}',
                        'buttons'=>array(
                                'maps'=>array(
                                        'url'=>function($data){ return Yii::app()->createUrl('mapview',array('deviceid'=>$data->id));},
                                        'imageUrl'=>'images/map.png',
                                        'label'=>'view on maps',
                                ),
                        ),

		),
	),
)); ?>
