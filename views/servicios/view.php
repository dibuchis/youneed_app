<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */
?>
<div class="servicios-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'slug',
            'incluye:ntext',
            'no_incluye:ntext',
            'tarifa_base',
            'tarifa_dinamica',
            'aplica_iva',
            'obligatorio_certificado',
            'imagen:ntext',
        ],
    ]) ?>

</div>
