<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
USE common\models\User;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor ingrese los siguentes campos:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'phone_number') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'role')->radioList([User::ROLE_ADMINISTRATOR => 'Administrador', User::ROLE_AGENT => 'Agente', 'User::ROLE_CUSTOMER' => 'Cliente']) ?>

            <div class="form-group">
                    <?= Html::submitButton('Regístrate', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="col-lg-5" align = "center">
            O regístrate con tu cuenta de facebook 
            <?=
            yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/authSign']
            ])
            ?>
        </div>
        
        
            
        
    </div>
</div>
