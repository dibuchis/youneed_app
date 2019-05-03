<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\Models\TiposNotificaciones */

$this->title = 'Create Tipos Notificaciones';
$this->params['breadcrumbs'][] = ['label' => 'Tipos Notificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-notificaciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
