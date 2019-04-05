<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Planes */
?>
<div class="planes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:html',
            'pvp',
            'descuento_1',
            'descuento_2',
            'fecha_creacion',
        ],
    ]) ?>

</div>
