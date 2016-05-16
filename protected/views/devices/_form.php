<?php
/* @var $this DevicesController */
/* @var $model Devices */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'devices-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),			
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uniqueid'); ?>
		<?php echo $form->textField($model,'uniqueid',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'uniqueid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastupdate'); ?>
		<?php echo $form->textField($model,'lastupdate'); ?>
		<?php echo $form->error($model,'lastupdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'positionid'); ?>
		<?php echo $form->textField($model,'positionid'); ?>
		<?php echo $form->error($model,'positionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notelp'); ?>
		<?php echo $form->textField($model,'notelp',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'notelp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'merek'); ?>
		<?php echo $form->textField($model,'merek',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'merek'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipe'); ?>
		<?php echo $form->textField($model,'tipe',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tipe'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'port'); ?>
		<?php echo $form->textField($model,'port'); ?>
		<?php echo $form->error($model,'port'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'protocol'); ?>
		<?php echo $form->textField($model,'protocol',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'protocol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'settingan'); ?>
		<?php echo $form->textArea($model,'settingan',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'settingan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_password'); ?>
		<?php echo $form->textField($model,'u_password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'u_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_fullname'); ?>
		<?php echo $form->textField($model,'u_fullname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'u_fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_email'); ?>
		<?php echo $form->textField($model,'u_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'u_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_address'); ?>
		<?php echo $form->textField($model,'u_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'u_address'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(($model->isNewRecord ? 'Create' : 'Save'),array('class'=>'btn btn-primary')); ?>
		<?php echo CHtml::button('Cancel',array('class'=>'btn btn-warning','onclick'=>"document.location='".Yii::app()->controller->createUrl('index')."'")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->