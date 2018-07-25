<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Calificaciones */
?>
<div class="calificaciones-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'calificacion',
            'atencion_id',
            'fecha_calificacion',
        ],
    ]) ?>

</div>
