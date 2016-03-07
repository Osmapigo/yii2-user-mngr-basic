<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Person */

$this->title = 'Actualizar usuario: ' . ' ' . $model->name;
if (!(Yii::$app->user->Identity->role == "Cliente")){
    $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actuaizar';
?>
<div class="person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
      'message' => $message,
      'model' => $model,
      'user' => $user,
    ]) ?>

</div>
