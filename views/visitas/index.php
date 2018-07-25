<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas';
// $this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<?php if( Yii::$app->user->identity->dispositivo_id > 0 ){ ?>
    <div class="visitas-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'pjax'=>false,
                'export' => false,
                'columns' => require(__DIR__.'/_columns.php'),
                // 'toolbar'=> [
                //     ['content'=>
                //         Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                //         ['role'=>'modal-remote','title'=> 'Crear nuevos Visitas','class'=>'btn btn-default']).
                //         Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                //         ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Recargar']).
                //         '{toggleData}'.
                //         '{export}'
                //     ],
                // ],          
                'striped' => true,
                'condensed' => true,
                'responsive' => true,          
                // 'panel' => [
                //     'type' => 'primary', 
                //     'heading' => '<i class="glyphicon glyphicon-list"></i> Visitas para el '.date('Y-m-d'),                        
                //             '<div class="clearfix"></div>',
                // ]
            ])?>
        </div>
    </div>
<?php }else{ ?>
    <div class="alert alert-info" role="alert">Usuario no tiene asignado dispositivo GPS, comuníquese con soporte.</div>
<?php } ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
