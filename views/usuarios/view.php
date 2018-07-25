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
            // 'cuenta_id',
            [
                'attribute'=>'imagen',
                'value'=>function ($model) {
                    if( !is_null( $model->imagen ) ){
                        return '<img width="100%" src="'.$model->imagen.'">';   
                    }
                },
                'format'=>['raw'],
            ],
            'nombres',
            'apellidos',
            'email:email',
            // 'clave',
            'tipo',
            'fecha_creacion',
            // 'estado_id',
        ],
    ]) ?>

</div>
