<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Yii::$app->user->Identity->role == "Administrador"){
          echo Html::a('Crear usuario', ['create'], ['class' => 'btn btn-success']);
        } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'phone_number',
            'fk_user',
            'fkUser.status',
            'fkUser.registration_date',

            ['class' => 'yii\grid\ActionColumn',
              'template' => '{view} {update} {activate} {deactivate}{delete}',
              'buttons' => [
                'update' => function ($url){
                  if (Yii::$app->user->Identity->role == User::ROLE_ADMINISTRATOR){
                      return Html::a('<span class = "glyphicon glyphicon-pencil" aria-hidden = "true"></span>', $url);
                  }
                },
                'delete' => function ($url, $model, $key){
                  if (Yii::$app->user->Identity->role == User::ROLE_ADMINISTRATOR && $model->fk_user != Yii::$app->user->Identity->email){
                      return Html::a('<span class = "glyphicon glyphicon-trash" aria-hidden = "true"></span>', $url);
                  }
                },
                'activate' => function ($url, $model, $key){
                  if (Yii::$app->user->Identity->role == User::ROLE_ADMINISTRATOR && $model->fk_user != Yii::$app->user->Identity->email && User::findOne(['email' => $model->fk_user])->status == User::STATUS_INACTIVE){
                      return Html::a('<span class = "glyphicon glyphicon-ok" aria-hidden = "true"></span>', $url);
                  }
                },
                'deactivate' => function ($url, $model, $key){
                    if(Yii::$app->user->Identity->role == User::ROLE_ADMINISTRATOR && $model->fk_user != Yii::$app->user->Identity->email && User::findOne(['email' => $model->fk_user])->status == User::STATUS_ACTIVE){
                        return Html::a('<span class = "glyphicon glyphicon-remove" aria-hidden = "true"></span>', $url);
                    }
                }
              ]
            ],
        ],
    ]); ?>

</div>
