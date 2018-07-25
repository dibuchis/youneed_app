<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\nav\NavX;

NavBar::begin([
    'brandLabel' => Html::img( Url::to('@web/images/logo-admin.png'), ['class'=> 'logo-main']),
    'brandUrl' => Yii::$app->homeUrl,
    'innerContainerOptions'=>['class' => 'container-fluid'],  
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo '<div class="pull-right"><h2>Asignación de doctor/unidad</h2></div>';

NavBar::end();
?>