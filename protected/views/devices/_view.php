<?php
/* @var $this DevicesController */
/* @var $data Devices */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uniqueid')); ?>:</b>
	<?php echo CHtml::encode($data->uniqueid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastupdate')); ?>:</b>
	<?php echo CHtml::encode($data->lastupdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('positionid')); ?>:</b>
	<?php echo CHtml::encode($data->positionid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notelp')); ?>:</b>
	<?php echo CHtml::encode($data->notelp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('merek')); ?>:</b>
	<?php echo CHtml::encode($data->merek); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipe')); ?>:</b>
	<?php echo CHtml::encode($data->tipe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('port')); ?>:</b>
	<?php echo CHtml::encode($data->port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('protocol')); ?>:</b>
	<?php echo CHtml::encode($data->protocol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('settingan')); ?>:</b>
	<?php echo CHtml::encode($data->settingan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('u_password')); ?>:</b>
	<?php echo CHtml::encode($data->u_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('u_fullname')); ?>:</b>
	<?php echo CHtml::encode($data->u_fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('u_email')); ?>:</b>
	<?php echo CHtml::encode($data->u_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('u_address')); ?>:</b>
	<?php echo CHtml::encode($data->u_address); ?>
	<br />

	*/ ?>

</div>