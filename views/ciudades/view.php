<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ciudades */
?>
<div class="ciudades-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pais_id',
            'nombre',
        ],
    ]) ?>

</div>
