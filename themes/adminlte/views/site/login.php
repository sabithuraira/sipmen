<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

    <div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="form-group has-feedback">
            <?php echo $form->textField($model,'username', array('class'=>'form-control', 'placeholder'=>'Email')); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?php echo $form->error($model,'username'); ?>
        </div>
    
        
        <div class="form-group has-feedback">
            <?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="row">
        
            <div class="col-xs-1"></div>
            <div class="col-xs-7">
                <div class="checkbox icheck">
                <label>
                    <?php echo $form->checkBox($model,'rememberMe'); ?>
                     Remember Me
                </label>
                </div>
            </div>

            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>

        </div>
    
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->



<!--
<form action="../../index2.html" method="post">
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