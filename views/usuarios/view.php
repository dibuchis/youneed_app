<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
?>
<div class="usuarios-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tipo_identificacion',
            'identificacion',
            'imagen:ntext',
            'nombres',
            'apellidos',
            'email:email',
            'numero_celular',
            'telefono_domicilio',
            'clave',
            'tipo',
            'estado',
            'token_push:ntext',
            'habilitar_rastreo',
            'token:ntext',
            'ciudad_id',
            'categoria_id',
            'fecha_creacion',
            'fecha_activacion',
            'fecha_desactivacion',
            'causas_desactivacion:ntext',
            'plan_id',
            'fecha_cambio_plan',
            'banco_id',
            'tipo_cuenta',
            'numero_cuenta',
            'preferencias_deposito',
            'observaciones:ntext',
            'dias_trabajo',
            'horarios_trabajo',
            'estado_validacion_documentos',
            'traccar_id',
            'imei',
        ],
    ]) ?>

</div>
