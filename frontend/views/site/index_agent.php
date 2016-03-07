<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Person;

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
                <h2>Administrar usuarios</h2>

                <p>Administrar los usuarios de la plataforma. </p>

                <p><?= Html::a('Administrar usuarios', ['../person/index'], ['class' => 'btn btn-success']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Administrar mi usuario</h2>

                <p>Administrar los datos de mi propio usuario en la plataforma. </p>

                <p><?= Html::a('Mi usuario', ['/person/view?id='. Person::findOne(['fk_user' => Yii::$app->user->identity->email])->id], ['class' => 'btn btn-success']) ?></p>
            </div>
        </div>

    </div>
</div>
