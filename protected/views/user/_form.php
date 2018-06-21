<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45, 'class'=>"form-control")); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255, 'class'=>"form-control")); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<?php if($model->isNewRecord){ ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255, 'class'=>"form-control")); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<?php } ?>

	<?php if(Yii::app()->user->getLevel()==1){ ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'unit_kerja'); ?>
		<?php echo $form->textField($model,'unit_kerja',array('size'=>60,'maxlength'=>255, 'class'=>"form-control")); ?>
		<?php echo $form->error($model,'unit_kerja'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type_user'); ?>
		<?php echo $form->dropDownList($model,'type_user',
				HelpMe::getTypeUser(),
				array('empty'=>'- Pilih Jenis User-', 'class'=>"form-control")); ?>
		<?php echo $form->error($model,'type_user'); ?>
	</div>
	<?php } ?>


	<div class="box-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>"btn btn-info pull-right")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->