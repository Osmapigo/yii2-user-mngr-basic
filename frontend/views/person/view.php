<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = $model->name;
if (!(Yii::$app->user->Identity->role == "Cliente")){
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?
        if($model->fk_user == \Yii::$app->user->identity->email || \Yii::$app->user->identity->role == "Administrador"){
          echo Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
          ?>
        <? if ($model->fk_user != \Yii::$app->user->identity->email && \Yii::$app->user->identity->role == "Administrador"){
          echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de querer eliminar este usuario?',
                'method' => 'post',
            ],]);
        }


            ?>
        <? if ($model->fk_user != \Yii::$app->user->identity->email && $user_status == "Activo" && \Yii::$app->user->identity->role == "Administrador"){
          echo Html::a('Desactivar', ['deactivate', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        elseif ($model->fk_user != \Yii::$app->user->identity->email && $user_status == "Inactivo" && \Yii::$app->user->identity->role == "Administrador"){
          echo Html::a('Activar', ['activate', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }  ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'phone_number',
            'fk_user',
            'fkUser.status',
            'fkUser.registration_date',
        ],
    ]) ?>

</div>
