<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<h4>Dashboard</h4>

<div class="row">
    <div class="dashboard-panel col-md-6">
        <div class="dashboard-panel-wrapper">
            <div class="dashboard-panel-header">Pedidos</div>
            <div class="dashboard-panel-content">
                <div class="dashboard-panel-content-item">
                <i>Por el momento no tiene ningún pedido.</i>
                </div>
            </div>
            <div class="dashboard-panel-footer">
                Ver todos los pedidos
            </div>
        </div>
    </div>

    <div class="dashboard-panel col-md-6">
        <div class="dashboard-panel-wrapper">
            <div class="dashboard-panel-header">Historial</div>
            <div class="dashboard-panel-content">
                <div class="dashboard-panel-content-item">
                <i>Por el momento no tiene ninguna notificación.</i>
                </div>
            </div>
            <div class="dashboard-panel-footer">
                Ver historial completo
            </div>
        </div>
    </div>
    

</div>