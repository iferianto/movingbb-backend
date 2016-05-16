<?php
/* @var $this RoadweightController */
/* @var $model Roadweight */
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
	</tr>
</table>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
