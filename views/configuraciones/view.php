<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */
?>
<div class="configuraciones-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'politicas_condiciones:ntext',
            'porcentaje_cancelacion_cliente',
            'beneficios_ser_asociado:ntext',
            'promociones_asociados:ntext',
            'ayuda:ntext',
        ],
    ]) ?>

</div>
