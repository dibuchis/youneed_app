<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\widgets\Select2;

return [
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
    //     'attribute'=>'cuenta_id',
    // ],
    [
        'attribute'=>'imagen',
        'value'=>function ($model, $key, $index, $widget) {
            if( !is_null( $model->imagen ) ){
                return '<img width="150px;" src="'.$model->imagen.'">';    
            }else{
                return '<img width="150px;" src="'.Url::home(true).'images/sin_foto.jpg">';
            }
            
        },
        // 'width'=>'10px;',
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=>[ 'Pago pendiente' => 'Pago pendiente', 'No autorizado' => 'No autorizado', 'Pagado' => 'Pagado', 'Depositado' => 'Depositado'], 
        'format'=>'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'identificacion',
    ],
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
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'clave',
    // ],
    // [
    //     'attribute'=>'tipo', 
    //     // 'width'=>'520px',
    //     // 'vAlign'=>'middle',  
    //     'value'=>function ($model, $key, $index, $widget) { 
    //         return $model->tipo;
    //     },
    //     'filterType'=>GridView::FILTER_SELECT2,
    //     'filter'=> [ 'Superadmin' => 'Superadmin', 'Administrador' => 'Administrador', 'Personal' => 'Personal', 'Operador' => 'Operador', ],
    //     'filterWidgetOptions'=>[
    //         'pluginOptions'=>['allowClear'=>true],
    //     ],
    //     'filterInputOptions'=>['placeholder'=>'Seleccione tipo'],
    //     'format'=>'raw'
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_creacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'estado_id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Geomonitoreo',
                          'data-confirm-message'=>'¿Está seguro de eliminar este elemento?'], 
    ],

];   