<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Turnos */
?>
<div class="turnos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dispositivo_id',
            'conductor_id',
            'fecha_inicio',
            'fecha_final',
            'observaciones:ntext',
        ],
    ]) ?>

</div>
