<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Util;
use app\models\Traccar;
CrudAsset::register($this);

$this->title = 'Geomonitoreo';
?>


<div id="a" class="split split-horizontal menu-panel">
  <div id="d" class="split content">
    <?=$this->render('../layouts/_partials/_menu_monitoreo.php')?>
  </div>
</div>
<div id="b" class="split split-horizontal">
  
  <div id="e" class="split content">    
      <div id="map_canvas" class="map_canvas"></div>
        <div id="search-options">
          <?php 
              // $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
              //     'name'=>'auto_complete_producto_busqueda_rapida',
              //     'source'=>$this->createUrl('ajax/listadozonasmapa'),
              //       'options'=>array(
              //         'showAnim'=>'fold',
              //         'select' => 'js:function(event, ui){ centrar_poligono(ui.item.poligono) }',
              //         'change' => 'js:function(event, ui){
              //           if(ui.item===null){
              //             $("#auto_complete_producto_busqueda_rapida").val("");
              //           }            
              //         }',
              //       ),
              //       'htmlOptions'=>array(
              //         'class'=>'pac-input', 
              //         'placeholder'=>'Buscar lugares ...',
              //       ),
              // ));
            ?>

          <input id="pac-input" class="pac-input" type="text" placeholder="Buscar lugares ...">
          <!-- <select id="pac-input-select">
            <option value="G">Google</option>
            <option value="Z">Zonas</option>
          </select> -->
        </div>
  </div>

  <div id="f" class="split content alert-panel">
    
    <div class="atenciones-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns_atenciones.php'),
                'toolbar'=> [
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                        ['role'=>'modal-remote','title'=> 'Create new Atenciones','class'=>'btn btn-default']).
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                        '{toggleData}'.
                        '{export}'
                    ],
                ],          
                'striped' => true,
                'condensed' => true,
                'responsive' => true,          
                'panel' => [
                    'type' => 'primary', 
                    'heading' => '<i class="glyphicon glyphicon-list"></i> Atenciones Historial',
                    // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                    // 'after'=>BulkButtonWidget::widget([
                    //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                    //                 ["bulk-delete"] ,
                    //                 [
                    //                     "class"=>"btn btn-danger btn-xs",
                    //                     'role'=>'modal-remote-bulk',
                    //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    //                     'data-request-method'=>'post',
                    //                     'data-confirm-title'=>'Are you sure?',
                    //                     'data-confirm-message'=>'Are you sure want to delete this item'
                    //                 ]),
                    //         ]).                        
                    //         '<div class="clearfix"></div>',
                ]
            ])?>
        </div>
    </div>
    <?php Modal::begin([
        "id"=>"ajaxCrudModal",
        "footer"=>"",// always need it for jquery plugin
    ])?>
    <?php Modal::end(); ?>

  </div>
</div>

<style type="text/css">
.kv-panel-before, .kv-panel-after{
  display: none;
}
.panel-primary{
  border-color: transparent;
}
a:hover{
  text-decoration: none!important;
}
.panel{
  margin-bottom: 0!important;
}
</style>