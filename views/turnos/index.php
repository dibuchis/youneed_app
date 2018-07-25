<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turnos';
$this->params['breadcrumbs'][] = $this->title;

// CrudAsset::register($this);

?>
<div class="btn-group pull-right">
    <a class="btn btn-default" href="<?php echo Url::home(true); ?>turnos/create" title="Crear nuevo turno" role="modal-remote"><i class="glyphicon glyphicon-plus"></i></a>
</div>
<?php
$events = array();
  //Testing
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 1;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z');
  $events[] = $Event;
 
  $Event = new \yii2fullcalendar\models\Event();
  $Event->id = 2;
  $Event->title = 'Testing';
  $Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;
 
  ?>
 
  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
        'clientOptions' => [
            'defaultView'=>'agendaWeek',
            'allDaySlot' => false,
            'contentHeight'=>430,
            'firstHour'=>date('H'),
            'lazyFetching'=>true,
          ],
        'ajaxEvents' => Url::to(['/turnos/eventos'])
  ));