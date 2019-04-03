<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\nav\NavX;

NavBar::begin([
    'brandLabel' => Html::img( Url::to('@web/images/logo2.png'), ['class'=> 'logo-main']),
    'brandUrl' => Yii::$app->homeUrl,
    'innerContainerOptions'=>['class' => 'container-fluid'],  
    'options' => [
        'class' => 'navbar navbar-fixed-top navbar-asociado',
    ],
]);
if( !Yii::$app->user->isGuest ){

    if( Yii::$app->user->identity->es_asociado == 1 ){
        echo NavX::widget([
            'items' => [
                '<li><input class="nav-menu-item nav-search" name="search">',
                '<li><span class="nav-menu-item"><i class="material-icons">email</i> </span></li>',
                '<li><span class="nav-menu-item"><i class="material-icons">notifications</i> </span></li>',
                '<li class="dropdown usuario-panel"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::img( Url::to('@web/images/usuario-icono.png'), ['class'=> 'usuario-icono']).' <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Bienvenido</li>
                        <li><a href="'.Url::to('@web/site/asociadoperfil').'"><i class="icon-user"></i> Mi Perfil</a></li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Cerrar sesión',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>
                    </ul>
                </li>',
            ],
            'options' => ['class' => 'nav-pills navbar-right'],
            'activateParents' => true,
            'encodeLabels' => false
        ]);
    } 

}

NavBar::end();
?>