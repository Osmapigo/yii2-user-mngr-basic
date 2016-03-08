<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ingresar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ingresar al sistema de administación:</p>

    <?php if ($message != NULL){
        echo "<p> <font color='red' size = '6'>$message </font></p>";
    }
?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>


                <div class="form-group">
                    <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        
        
        <div class="col-lg-5">
            <div align="center">O ingresa con tu cuenta de facebook 
            <?=
        yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/authLogin']
        ])
        ?></div>
        </div>
    </div>
</div>
