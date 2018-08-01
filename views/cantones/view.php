<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cantones */
?>
<div class="cantones-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'provincia_id',
            'nombre',
        ],
    ]) ?>

</div>
