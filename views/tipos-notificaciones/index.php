<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\TiposNotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tipos Notificaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'categoria',
            'descripcion',
            'mensaje',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
