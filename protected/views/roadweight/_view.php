<?php
/* @var $this RoadweightController */
/* @var $data Roadweight */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('osm_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->osm_id), array('view', 'id'=>$data->osm_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitude')); ?>:</b>
	<?php echo CHtml::encode($data->latitude); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitude')); ?>:</b>
	<?php echo CHtml::encode($data->longitude); ?>
	<br />


</div>