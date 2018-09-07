<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    <div class="col-md-3"><?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
     <?php if($model->isNewRecord){?>
    <div class="col-md-3"><?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'confirmpassword')->passwordInput(['maxlength' => true]) ?></div>
    <?php }?>
    </div>
    
    <div class="row">
    <div class="col-md-3"><?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'dateofbirth')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter birth date'],
    'pluginOptions' => [
        'autoclose'=>true,
    		'format' => 'dd-M-yyyy'
    ]
]); ?></div>
    <div class="col-md-3"><?= $form->field($model, 'timeofbirth')->widget(TimePicker::classname(), [
    		'pluginOptions' => [
		    'defaultTime' => false,
    		 'showSeconds' => true,]]); ?></div>
    </div>
    
    <div class="row">
    <div class="col-md-3"><?= $form->field($model, 'placeofbirth')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'current_city')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'current_state')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'current_country')->textInput(['maxlength' => true]) ?></div>
    </div>
    
    <div class="row">
    <div class="col-md-3"><?= $form->field($model, 'dasa_at_birth')->dropDownList($planetlist,['prompt' => 'Select Planet']); ?></div>
    <div class="col-md-3"><?= $form->field($model, 'dasa_end_date')->widget(DateTimePicker::classname(), [
	'options' => ['placeholder' => 'Enter event time ...'],
	'pluginOptions' => [
		'autoclose' => true
	]
]); 
    ?></div>    
    <div class="col-md-3"><?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?></div>
    <div class="col-md-3"><?= $form->field($model, 'status')->dropDownList(['10' => 'Active','0' => 'In-active'],['prompt' => 'Select Status']) ?></div>
    </div>

    

    <div class="form-group col-md-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
