<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="search-bar-devices">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">
          <span class="glyphicon glyphicon-search"></span>
      </span>
      <input type="text" id="kwd_search" class="form-control" placeholder="Buscar dispositivo" aria-describedby="basic-addon1">
    </div>
</div>

<?=GridView::widget([
    'id'=>'crud-datatable',
    'tableOptions' => [
        'class' => 'tabla-listado-dispositivos',
    ],
    'dataProvider' => Yii::$app->controller->dataProviderDispositivos,
    'filterModel' => Yii::$app->controller->searchModelDispositivos,
    'summary' => '',
    'columns' => [
        [
            // 'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'alias',
            'label' => false,
            'filter'=>false,
            'format'=>'raw',
            'value'=>function ($model, $key, $index, $widget) {
                return $this->render('_vista_dispositivo', [
                    'model' => $model,
                ]);
            },
        ],
    ],         
    
])?>