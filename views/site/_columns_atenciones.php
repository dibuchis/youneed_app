<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'paciente_id',
        'format'=>'raw',
        'value'=>function ($model, $key, $index, $widget) {
            return $model->paciente->nombres.' '.$model->paciente->apellidos;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'doctor_id',
        'format'=>'raw',
        'value'=>function ($model, $key, $index, $widget) {
            if( isset( $model->doctor ) ){
                return $model->doctor->nombres.' '.$model->doctor->apellidos;
            }else{
                return null;
            }
        },
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
        'attribute'=>'fecha_creacion',
    ],
    [
        'attribute'=>'estado',
        'filter'=>false,
        'width'=>'140px',
        'hAlign' => 'center',
        'value'=>function ($model, $key, $index, $widget) {
            $color = 'default';
            $texto = '';
            if( $model->estado == 0 ){
                $color = 'danger';
                $texto = 'Nueva atención';
            }elseif( $model->estado == 1 ){
                $color = 'warning';
                $texto = 'Doctor asignado';
            }elseif( $model->estado == 2 ){
                $color = 'success';
                $texto = 'Doctor atendiendo';
            }
            return '<a href="'.Url::to(['site/soporteatencion','id'=>$model->id]).'"><span class="btn-block btn-xs btn-'.$color.'">'.$texto.'</span></a>';
            // return Html::a('Ajax Link Label','#', [
            //     'title' => 'Ajax Title',
            //     'onclick'=>"
            //      $.ajax({
            //     type     :'get',
            //     cache    : false,
            //     data: {id: ".$model->id."},
            //     url  : '".Url::to(['atenciones/update'])."',
            //     success  : function(response) {
            //             console.log('success: '+response.filename);
            //     },
            //     error: function(){
            //       console.log('failure');
            //     }
            //     });return false;",
            //     'aria-label'=>'Atención',
            //     'data-pjax'=>'0',
            //     'role'=>'modal-remote',
            //     'data-toggle'=>'tooltip'
            // ]);

        },
        'format'=>'raw'
    ],
];   