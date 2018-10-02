<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
?>
<div class="usuarios-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'tipo_identificacion',
            'identificacion',
            [
                'attribute'=>'imagen',
                'value'=>function ($model) {
                    if( !is_null( $model->imagen ) ){
                        return '<img width="200px" src="'.$model->imagen.'">';   
                    }
                },
                'format'=>['raw'],
            ],
            'nombres',
            'apellidos',
            'email:email',
            'numero_celular',
            'telefono_domicilio',
            'estado',
            [
                'attribute'=>'estado',
                'value'=>function ($model) {
                     $color = 'default';
                    $texto = '';
                    if( $model->estado == 1 ){
                        $color = 'success';
                        $texto = 'Activo';
                    }elseif( $model->estado == 0 ){
                        $color = 'warning';
                        $texto = 'Inactivo';
                    }else{
                        $color = 'danger';
                        $texto = 'Sin estado';
                    }
                    return '<span class="btn-block btn-xs btn-'.$color.'"><center>'.$texto.'</center></span>';

                },
                'format'=>['raw'],
            ],
            [
                'attribute'=>'habilitar_rastreo',
                'value'=>function ($model) {
                     $color = 'default';
                    $texto = '';
                    if( $model->estado == 1 ){
                        $color = 'success';
                        $texto = 'Permite rastreo';
                    }elseif( $model->estado == 0 ){
                        $color = 'warning';
                        $texto = 'No permite rastreo';
                    }else{
                        $color = 'danger';
                        $texto = 'No permite rastreo';
                    }
                    return '<span class="btn-block btn-xs btn-'.$color.'"><center>'.$texto.'</center></span>';

                },
                'format'=>['raw'],
            ],
            [
                'attribute'=>'ciudad_id',
                'value'=> ( isset( $model->ciudad ) ) ? $model->ciudad->nombre : null,
                'format' => ['raw'],
            ],
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
