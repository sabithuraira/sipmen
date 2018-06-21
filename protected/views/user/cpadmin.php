<div class="box box-info">
	<div class="mailbox-controls">
		<b>Change Password <?php echo $data->username; ?></b>
	</div>

	<div class="box-body">
        <div class="form">

        
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-form',
                'enableAjaxValidation'=>true,
            )); ?>

                <?php echo $form->errorSummary($data); ?>

                <div class="form-group">
                    <?php echo "Password Baru"; ?>
                    <?php echo CHtml::passwordField('baru1','',array('size'=>50,'maxlength'=>50, 'class'=>"form-control")); ?>
                </div>

                <div class="form-group">
                    <?php echo "Password Konfirmasi"; ?>
                    <?php echo CHtml::passwordField('baru2','',array('size'=>50,'maxlength'=>50, 'class'=>"form-control")); ?>
                </div>

                <div class="box-footer">
                    <?php echo CHtml::submitButton('Save', array('class'=>"btn btn-info pull-right")); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
	</div>
</div>