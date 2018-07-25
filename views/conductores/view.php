<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Conductores */
?>
<div class="conductores-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cuenta_id',
            'nombres',
            'apellidos',
            'identificacion',
            'telefonos:ntext',
            'observaciones:ntext',
        ],
    ]) ?>

</div>
