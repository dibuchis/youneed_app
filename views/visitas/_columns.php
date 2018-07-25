<?php
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'dispositivo_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'lat',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'lng',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fecha_creacion',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fecha_inicio',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_final',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'cumplimiento',
    // ],
    [
        'attribute'=>'cumplimiento',
        'header'=>'Listado de visitas',
        'filter'=>false,
        'width'=>'140px',
        'hAlign' => 'center',
        'value'=>function ($model, $key, $index, $widget) {
            $color = 'default';
            $estado = 'Sin visitar - '.date('H:i', strtotime($model->fecha_creacion));
            if( $model->cumplimiento == 0 ){
                $color = 'warning';
                return "<a href='".Url::to(['visitas/view', 'id' => $model->id])."'><span class='btn-block btn btn-".$color."'> ".$estado ."</span></a>";
            }else{
                $color = 'success';
                $estado = 'Visitado';
                return "<span class='btn-block btn btn-".$color."'> ".$estado ."</span>";
            }
            
        },
        // 'width'=>'8%',
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=>[ 'Pago pendiente' => 'Pago pendiente', 'No autorizado' => 'No autorizado', 'Pagado' => 'Pagado', 'Depositado' => 'Depositado'], 
        'format'=>'raw'
    ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>'Geomonitoreo',
    //                       'data-confirm-message'=>'¿Está seguro de eliminar este elemento?'], 
    // ],

];   