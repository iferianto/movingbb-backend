<?php
/* @var $this RoadweightController */
/* @var $model Roadweight */

$this->breadcrumbs=array(
	'Roadweights'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roadweight-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Roadweight</h1>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
//$this->widget('zii.widgets.grid.CGridView', array(
$this->widget('ext.EExcelView', array(
	'id'=>'roadweight-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	//'template'=>'{eximbuttons}{summary}{items}{pager}',
	'template'=>'{exportButtons}{summary}{items}{pager}',
	'columns'=>array(
		'osm_id',
		'name',
		'weight',
		'latitude',
		'longitude',
		array(
			'htmlOptions'=>array('style'=>'width:100px'),
                        'class'=>'CButtonColumn',
                        'template'=>'{view}&nbsp;{update}&nbsp;{maps}',
                        'buttons'=>array(
                                'maps'=>array(
                                        'url'=>function($data){ return Yii::app()->createUrl('mapview',array('osm_id'=>$data->osm_id));},
                                        'imageUrl'=>'images/map.png',
                                        'label'=>'view on maps',
                                ),
                        ),


		),
	),
)); ?>
