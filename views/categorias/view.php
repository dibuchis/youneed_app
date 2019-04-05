<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categorias */
?>
<div class="categorias-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'slug',
            'descripcion:html',
            // 'imagen:html',
            'fecha_creacion',
        ],
    ]) ?>

</div>
