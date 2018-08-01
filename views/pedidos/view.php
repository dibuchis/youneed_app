<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pedidos */
?>
<div class="pedidos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cliente_id',
            'asociado_id',
            'latitud',
            'longitud',
            'identificacion',
            'razon_social',
            'nombres',
            'apellidos',
            'email:email',
            'telefono',
            'fecha_para_servicio',
            'direccion_completa:ntext',
            'observaciones_adicionales:ntext',
            'ciudad_id',
            'forma_pago',
            'tarjeta_id',
            'codigo_postal',
            'tipo_atencion',
            'tiempo_llegada',
            'fecha_creacion',
            'estado',
            'subtotal',
            'iva',
            'iva_0',
            'total',
            'fecha_llegada_atencion',
            'fecha_finalizacion_atencion',
            'valores_transferir_asociado',
            'valores_cancelacion_servicio_cliente',
            'tiempo_aproximado_llegada',
        ],
    ]) ?>

</div>
