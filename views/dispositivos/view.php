<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dispositivos */
?>
<div class="dispositivos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cuenta_id',
            'grupo_id',
            'categoria_id',
            'nombre',
            'alias',
            'placa',
            'imei',
            'traccar_id',
            'tipo',
        ],
    ]) ?>

</div>
