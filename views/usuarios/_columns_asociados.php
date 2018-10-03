<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tipo_identificacion',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'identificacion',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'imagen',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombres',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellidos',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numero_celular',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'telefono_domicilio',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'clave',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tipo',
    ],
    [
        'attribute'=>'estado',
        'filter'=>false,
        // 'hAlign' => 'left',
        // 'width'=>'240px',
        'value'=>function ($model, $key, $index, $widget) {
            return Yii::$app->params['parametros_globales']['estados'][$model->estado];
        },
        // 'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> array_merge( [ ''=>'Todos'], Yii::$app->params['parametros_globales']['estados'] ), 
        'format'=>'raw'
    ],
    [
        'attribute'=>'estado_validacion_documentos',
        'filter'=>false,
        // 'hAlign' => 'left',
        // 'width'=>'240px',
        'value'=>function ($model, $key, $index, $widget) {
            return Yii::$app->params['parametros_globales']['estados_condiciones'][$model->estado_validacion_documentos];
        },
        // 'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> array_merge( [ ''=>'Todos'], Yii::$app->params['parametros_globales']['estados_condiciones'] ), 
        'format'=>'raw'
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'token_push',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'habilitar_rastreo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'token',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ciudad_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'categoria_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_creacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_activacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_desactivacion',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'causas_desactivacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'plan_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_cambio_plan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'banco_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tipo_cuenta',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'numero_cuenta',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'preferencias_deposito',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'observaciones',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dias_trabajo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'horarios_trabajo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'estado_validacion_documentos',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'traccar_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'imei',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   