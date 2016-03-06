<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = 'Crear nuevo usuario';
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (Yii::$app->user->identity->role == "Administrador"){
      echo $this->render('_form_admin', [
          'user' => $user,
          'model' => $model,
      ]);
    }else {
      echo "Zona no autorizada";
      die();
    } ?>

</div>
