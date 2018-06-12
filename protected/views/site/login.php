<?php $this->pageTitle=Yii::app()->name . ' - Login'; ?>
    
    <div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <p class="note">Fields with <span class="required">*</span> are required.</p>
    
        <div class="row">
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    
        <div class="row">
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint">
                Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
            </p>
        </div>
    
        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'rememberMe'); ?>
            <?php echo $form->label($model,'rememberMe'); ?>
            <?php echo $form->error($model,'rememberMe'); ?>
        </div>
    
        <div class="row buttons">
            <?php echo CHtml::submitButton('Login',array('class'=>'btn btn btn-primary')); ?>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>

    </div>

</div>


<!--
<form action="../../index2.html" method="post">
    <div class="form-group has-feedback">
    <input type="email" class="form-control" placeholder="Email">
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
    <div class="col-xs-8">
        <div class="checkbox icheck">
        <label>
            <input type="checkbox"> Remember Me
        </label>
        </div>
    </div>

    <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
    </div>

    </div>
</form>

-->