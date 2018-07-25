<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\Usuarios;

return [
    [
        'attribute'=>'paciente_id', 
        // 'width'=>'520px',
        // 'vAlign'=>'middle',  
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->paciente->identificacion.' - '.$model->paciente->nombres.' '.$model->paciente->apellidos;
        },
        'filterType'=>GridView::FILTER_SELECT2, 
        'filter'=> ArrayHelper::map(Usuarios::find()->andWhere(['tipo'=>'Paciente'])->orderBy('nombres')->asArray()->all(), 'id', 
            function($model, $defaultValue) {
                return $model['identificacion'].' - '.$model['nombres'].' '.$model['apellidos'];
            }
        ), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Seleccione'],
        'format'=>'raw'
    ],
    [
        'attribute'=>'doctor_id', 
        // 'width'=>'520px',
        // 'vAlign'=>'middle',  
        'value'=>function ($model, $key, $index, $widget) { 
            if( isset( $model->doctor ) ){
                return $model->doctor->identificacion.' - '.$model->doctor->nombres.' '.$model->doctor->apellidos;
            }else{
                return null;
            }
        },
        'filterType'=>GridView::FILTER_SELECT2, 
        'filter'=> ArrayHelper::map(Usuarios::find()->andWhere(['tipo'=>'Doctor'])->orderBy('nombres')->asArray()->all(), 'id', 
            function($model, $defaultValue) {
                return $model['identificacion'].' - '.$model['nombres'].' '.$model['apellidos'];
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
        'attribute'=>'tiempo_atencion',
        'format'=>'raw',
        'value'=>function ($model, $key, $index, $widget) {
            if( $model->tiempo_atencion > 0 ){
                return $model->tiempo_atencion.' min';
            }else{
                return null;
            }
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'precio_atencion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'metodo_pago',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'referencia_placetopay',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'codigo_autorizacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'estado',
        'format'=>'raw',
        'value'=>function ($model, $key, $index, $widget) {
            $color = 'default';
            $texto = '';
            if( $model->estado == 0 || $model->estado == 6 || $model->estado == 7 ){
                $color = 'danger';
                $texto = 'En asignación de doctor';
            }elseif( $model->estado == 1 ){
                $color = 'warning';
                $texto = 'Doctor asignado';
            }elseif( $model->estado == 2 ){
                $color = 'success';
                $texto = 'Doctor atendiendo';
            }elseif( $model->estado == 8 ){
                $color = 'danger';
                $texto = 'Pendiente de pago';
            }elseif( $model->estado == 3 ){
                $color = 'success';
                $texto = 'Pagado';
            }elseif( $model->estado == 4 ){
                $color = 'danger';
                $texto = 'Cancelado por el paciente';
            }elseif( $model->estado == 5 ){
                $color = 'danger';
                $texto = 'Rechazada por Evolution';
            }
            return '<span class="btn-block btn-xs btn-'.$color.'"><center>'.$texto.'</center></span>';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_creacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_pago',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {delete}',
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