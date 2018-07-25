<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lugares */
?>
<div class="lugares-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cuenta_id',
            'nombre',
            'tipo',
            'poligono:ntext',
            'wkt:ntext',
            'estado_id',
        ],
    ]) ?>

</div>
