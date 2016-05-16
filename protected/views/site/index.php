<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
Welcome <?php echo (isset(Yii::app()->session['name'])?Yii::app()->session['name']:" user "); ?>
<br>
