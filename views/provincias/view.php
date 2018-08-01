<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Provincias */
?>
<div class="provincias-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pais_id',
            'nombre',
        ],
    ]) ?>

</div>
