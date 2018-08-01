<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paises */
?>
<div class="paises-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

</div>
