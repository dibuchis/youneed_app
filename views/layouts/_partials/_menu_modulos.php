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
if( !Yii::$app->user->isGuest ){

    if( Yii::$app->user->identity->tipo == 'Superadmin' ){

            echo NavX::widget([
                'items' => [
                    [
                        'label' => 'Monitoreo',
                        'url' => ['site/index'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Administración',
                        'items' => [
                            '<li class="dropdown-header">Catálogos generales</li>',
                            ['label' => 'Países', 'url' => ['paises/index']],
                            ['label' => 'Provincias', 'url' => ['provincias/index']],
                            ['label' => 'Cantones', 'url' => ['cantones/index']],
                            ['label' => 'Ciudades', 'url' => ['ciudades/index']],
                            ['label' => 'Tipos de Documentos', 'url' => ['tipos-documentos/index']],
                            ['label' => 'Bancos', 'url' => ['bancos/index']],
                            ['label' => 'Categorías de servicios', 'url' => ['categorias/index']],
                            ['label' => 'Servicios', 'url' => ['servicios/index']],
                            ['label' => 'Planes', 'url' => ['planes/index']],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header">Plataforma</li>',
                            ['label' => 'Usuarios', 'url' => ['usuarios/index']],
                            ['label' => 'Configuración Global', 'url' => ['configuraciones/update']],
                        ],
                    ],
                    [
                        'label' => 'Clientes',
                        'url' => ['usuarios/clientes'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Asociados',
                        'url' => ['usuarios/asociados'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Pedidos',
                        'url' => ['pedidos/index'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Reportes',
                        'items' => [
                            ['label' => 'Historico Asociados', 'url' => ['reportes/historico']],
                        ],
                    ],
                    '<li class="dropdown usuario-panel"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::img( Url::to('@web/images/usuario-icono.png'), ['class'=> 'usuario-icono']).' '.Yii::$app->user->identity->nombres.' <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Bienvenido</li>
                            <li><a href="'.Url::to('@web/site/micuenta').'"><i class="icon-user"></i> Mi cuenta</a></li>
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
    }elseif( Yii::$app->user->identity->tipo == 'Asociado' ){
        echo NavX::widget([
            'items' => [
                [
                    'label' => 'Mis documentos',
                    'url' => ['site/index'],
                    // 'linkOptions' => [],
                ],
                '<li class="dropdown usuario-panel"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::img( Url::to('@web/images/usuario-icono.png'), ['class'=> 'usuario-icono']).' '.Yii::$app->user->identity->nombres.' <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Bienvenido</li>
                        <li><a href="'.Url::to('@web/site/micuenta').'"><i class="icon-user"></i> Mi cuenta</a></li>
                        <li class="divider"></li>
                        <li><a target="_blank" href="http://soporte.abitmedia.com/"><i class="icon-envelope"></i> Soporte técnico</a></li>
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