<?php
/* @var $this DevicesController */
/* @var $model Devices */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<table>
<tr><td>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>254,'placeholder'=>'search...','style'=>'width:300px')); ?>
</td><td><?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?></td>
<td><?php echo CHtml::button('+Create',array('class'=>'btn btn-primary','onclick'=>"document.location='".Yii::app()->controller->createUrl('create')."'")); ?></td>
        </tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
