<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use app\assets\CrudAsset;
use app\assets\MonitoreoAsset;
use app\assets\DibujadoAsset;
use app\assets\ReporteAsset;
use yii\helpers\Url;

if( Yii::$app->controller->id == 'site' ){
  MonitoreoAsset::register($this);
}elseif( Yii::$app->controller->id == 'reportes' ){
  ReporteAsset::register($this);
}elseif( Yii::$app->controller->id == 'lugares' ){
  DibujadoAsset::register($this);
}else{
  CrudAsset::register($this);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'showProgressbar' => true,
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>

<input type="hidden" name="urlRest" id="urlRest" value="<?php echo Yii::$app->params['traccar']['rest_url']; ?>">
<input type="hidden" name="urlSocket" id="urlSocket" value="<?php echo Yii::$app->params['traccar']['socket_url']; ?>">
<input type="hidden" name="userSocket" id="userSocket" value="<?php echo Yii::$app->params['traccar']['usuario']; ?>">
<input type="hidden" name="passSocket" id="passSocket" value="<?php echo Yii::$app->params['traccar']['clave']; ?>">
<input type="hidden" name="base_url" id="base_url" value="<?php echo Url::home(true); ?>">
<?php $this->beginBody() ?>
    <?=$this->render('_partials/_menu_modulos.php')?>

    
        <div id="a" class="split split-horizontal menu-panel">
          <div id="d" class="split content">
            <?=$this->render('_partials/_buscador_form_historico.php')?>
          </div>
        </div>
        <div id="b" class="split split-horizontal">
          <div id="e" class="split content">
              <?= $content ?>
          </div>
          <!-- <div id="f" class="split content alert-panel">
          </div> -->
        </div>
   


<?php $this->endBody() ?>
 <script type="text/javascript">
    Split(['#a', '#b'], {
      gutterSize: 4,
      cursor: 'col-resize',
      sizes: [23, 77]
    });

    Split(['#e'], {
      direction: 'vertical',
      sizes: [100],
      gutterSize: 4,
      cursor: 'row-resize'
    });
  </script>
</body>
</html>
<?php $this->endPage() ?>
