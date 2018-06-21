<div class="box-body">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>

		<div class="form-group">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45, 'class'=>"form-control")); ?>
		</div>

		<div class="box-footer">
			<?php echo CHtml::submitButton('Search', array('class'=>"btn btn-info pull-right")); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div>
</div>
