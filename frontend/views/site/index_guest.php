<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Person;

/* @var $this yii\web\View */

$this->title = 'Sistema de gestión de usuarios';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Control de usuarios</h1>

        <p class="lead">Plataforma para administrar la información de los empleados y clientes en Osmapigo Corp.</p>
    </div>

    <div class="body-content" align = "center">

        <div class="row">
            <div class="col-lg-4">
                <h2>Ingresa</h2>

                <p>Ingreso como usuario registrado y activo en la plataforma</p>

                <p><?= Html::a('Ingresar', ['/site/login'], ['class' => 'btn btn-success']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Registrate</h2>

                <p>Si aún no haces parte de la plataforma, puedes registrarte y esperar el aviso de activación de la cuenta por parte de un administrador.</p>

                <p><?= Html::a('Registrarme', ['/site/signup'], ['class' => 'btn btn-primary']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Contactanos</h2>

                <p>Si quieres conocer más sobre nosotros, dejanos tus datos de contacto.</p>

                <p><?= Html::a('Contactenos', ['/site/contact'], ['class' => 'btn btn-success']) ?></p>
            </div>
        </div>

    </div>
</div>
