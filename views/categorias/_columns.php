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
    [
        'attribute'=>'imagen',
        'value'=>function ($model, $key, $index, $widget) {
            return '<img width="120px;" src="'.$model->imagen.'">';
        },
        // 'width'=>'10px;',
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=>[ 'Pago pendiente' => 'Pago pendiente', 'No autorizado' => 'No autorizado', 'Pagado' => 'Pagado', 'Depositado' => 'Depositado'], 
        'format'=>'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'slug',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
        'value'=>function ($model, $key, $index, $widget) {
            return strip_tags($model->descripcion);
        },
        'format'=>'raw'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'imagen',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_creacion',
    ],
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