<?php
//$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//	'Login',
//);
//?>
<!---->
<!--<h1>Login</h1>-->
<!---->
<!--<p>Please fill out the following form with your login credentials:</p>-->
<!---->
<!--<div class="form">-->
<?php //$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'login-form',
//	'enableClientValidation'=>true,
//	'clientOptions'=>array(
//		'validateOnSubmit'=>true,
//	),
//)); ?>
<!---->
<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'username'); ?>
<!--		--><?php //echo $form->textField($model,'username', array('class' => 'username')); ?>
<!--		--><?php //echo $form->error($model,'username'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'password'); ?>
<!--		--><?php //echo $form->passwordField($model,'password'); ?>
<!--		--><?php //echo $form->error($model,'password'); ?>
<!--		<p class="hint">-->
<!--			Hint: You may login with <tt>demo/demo</tt> or <tt>admin/admin</tt>.-->
<!--		</p>-->
<!--	</div>-->
<!---->
<!--	<div class="row rememberMe">-->
<!--		--><?php //echo $form->checkBox($model,'rememberMe'); ?>
<!--		--><?php //echo $form->label($model,'rememberMe'); ?>
<!--		--><?php //echo $form->error($model,'rememberMe'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row buttons">-->
<!--		--><?php //echo CHtml::submitButton('Login'); ?>
<!--	</div>-->
<!---->
<?php //$this->endWidget(); ?>
<!--</div><!-- form -->
<br>
<br>
<br>
<br>
<br>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <img class="img-responsive center-block" src="<?php echo Yii::app()->request->baseUrl; ?>/images/signup/adbanner.png">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="well text-center" style="background: #D79829; border: none; color: white">
            <h3 style="margin-top: 0px">SIGN UP NOW</h3>
            <hr/>
            <p>Hey, Good news! This website is free! Enjoy swapping stuff with others now!</p>
            <div class="text-align-left">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="first_name">First Name</label><br>
                        <input style="width: 263px" type="text" class="form-control" id="first_name" placeholder="John">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label><br>
                        <input style="width: 263px" type="text" class="form-control" id="last_name" placeholder="Doe">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label><br>
                        <input style="width: 263px" type="text" class="form-control" id="gender" placeholder="Male">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label><br>
                        <input style="width: 263px" type="email" class="form-control" id="birthday" placeholder="1988-02-16">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label><br>
                        <input style="width: 526px" type="email" class="form-control" id="email" placeholder="jane.doe@example.com">
                    </div>
                    <br><br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Register Now!</button>
                    </div>

                </form>
            </div>
            <br>
            or
            <br><br>
            <a class="btn btn-primary"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
            <a class="btn btn-danger"><i class="fa fa-google"></i> Sign in with Gmail</a>
        </div>
    </div>
</div>
