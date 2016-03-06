<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <? if ($user_status == "Activo"){
          echo Html::a('Desactivar', ['deactivate', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }
        else{
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
