<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alianzas */
?>
<div class="alianzas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            // 'imagen:ntext',
        ],
    ]) ?>

</div>
