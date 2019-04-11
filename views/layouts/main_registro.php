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
use app\assets\RegistroasociadoAsset;
use yii\helpers\Url;


  RegistroasociadoAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/<?= Url::base(''); ?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/<?= Url::base(''); ?>/css/owl.theme.default.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="/<?= Url::base(''); ?>/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/<?= Url::base(''); ?>/css/sweetalert2.min.css">
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
<input type="hidden" name="valor_iva" id="valor_iva" value="<?php echo Yii::$app->params['parametros_globales']['iva_valor'] ?>">
<input type="hidden" name="display_iva" id="display_iva" value="<?php echo Yii::$app->params['parametros_globales']['iva_display'] ?>">

<?php $this->beginBody() ?>

    <?=$this->render('_partials/_menu_modulos.php')?>

    <?= $content ?>

<?php $this->endBody() ?>
<?php if( Yii::$app->controller->id == 'site' ){ ?>
 
<?php } ?>
<script src="<?= Url::base('');  ?>/js/owl.carousel.min.js"></script>
<script>	

    jQuery(document).ready(function(){
        jQuery('.owl-carousel-cat').owlCarousel({
            items: 6,
            margin:45,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
                }
            },
            nav:true
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
