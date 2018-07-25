<?php

use yii\widgets\DetailView;
use app\models\Calificaciones;

/* @var $this yii\web\View */
/* @var $model app\models\Atenciones */
?>
<div class="atenciones-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'paciente_id',
                'value'=>$model->paciente->nombres.' '.$model->paciente->apellidos,
                'format' => ['raw'],
            ],
            [
                'attribute'=>'doctor_id',
                'value'=> (isset( $model->doctor )) ? $model->doctor->nombres.' '.$model->doctor->apellidos : null,
                'format' => ['raw'],
            ],
            'precio_atencion',
            'fecha_creacion',
            'fecha_pago',
            'metodo_pago',
            'codigo_autorizacion',
            [
                'attribute'=>'estado',
                'value'=>function ($model) {
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
                'format'=>['raw'],
            ],
            'sintomas',
            'diagnostico',
            'cie10',
            'descripcion_cie10',
            'medicamentos',
            'observaciones',
            [
                'attribute'=>'imagen',
                'value'=>function ($model) {
                    if( !is_null( $model->imagen ) ){
                        return '<img width="100%" src="'.$model->imagen.'">';   
                    }
                },
                'format'=>['raw'],
            ],
            // 'fecha_llenado_formulario',
            'tiempo_atencion',
        ],
    ]) ?>

<?php 
    $calificacion = Calificaciones::find()->andWhere( ['atencion_id'=>$model->id] )->one();
    if( is_object( $calificacion ) ){
        echo '<h2>Calificación</h2>';
        echo DetailView::widget([
            'model' => $calificacion,
            'attributes' => [
                'calificacion',
                'observacion',
                'fecha_calificacion',
            ],
        ]);
   }
?>

</div>
