<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */
?>
<div class="grupos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'cuenta_id',
        ],
    ]) ?>

</div>
