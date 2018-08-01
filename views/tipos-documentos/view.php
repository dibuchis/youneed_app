<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TiposDocumentos */
?>
<div class="tipos-documentos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

</div>
