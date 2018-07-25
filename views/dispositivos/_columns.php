<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\helpers\Html;

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
    // [
    //     'attribute'=>'grupo_id', 
    //     // 'width'=>'520px',
    //     // 'vAlign'=>'middle',  
    //     'value'=>function ($model, $key, $index, $widget) { 
    //         return $model->grupo->nombre;
    //     },
    //     'filterType'=>GridView::FILTER_SELECT2,
    //     'filter'=> ArrayHelper::map(Grupos::find()->orderBy('nombre')->asArray()->all(), 'id', 
    //         function($model, $defaultValue) {
    //             return $model['nombre'];
    //         }
    //     ), 
    //     'filterWidgetOptions'=>[
    //         'pluginOptions'=>['allowClear'=>true],
    //     ],
    //     'filterInputOptions'=>['placeholder'=>'Seleccione'],
    //     'format'=>'raw'
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'categoria_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'alias',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'placa',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'imei',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'traccar_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tipo',
    // ],
    [
        'attribute'=>'tipo', 
        // 'width'=>'520px',
        // 'vAlign'=>'middle',  
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->tipo;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> [ 'Roja' => 'Roja', 'Naranja' => 'Naranja', 'Verde' => 'Verde', ],
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Seleccione tipo'],
        'format'=>'raw'
    ],
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