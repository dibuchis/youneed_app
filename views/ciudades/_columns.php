<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\Paises;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'attribute'=>'pais_id', 
        // 'width'=>'520px',
        // 'vAlign'=>'middle',  
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->pais->nombre;
        },
        'filterType'=>GridView::FILTER_SELECT2, 
        'filter'=> ArrayHelper::map(Paises::find()->orderBy('nombre')->asArray()->all(), 'id', 
            function($model, $defaultValue) {
                return $model['nombre'];
            }
        ), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Seleccione'],
        'format'=>'raw'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
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