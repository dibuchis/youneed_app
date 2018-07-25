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
                            '<li class="dropdown-header">Monitoreo y Rutas</li>',
                            ['label' => 'Grupos / Flotas', 'url' => ['grupos/index']],
                            ['label' => 'Dispositivos GPS', 'url' => ['dispositivos/index']],
                            ['label' => 'Conductores', 'url' => ['conductores/index']],
                            // ['label' => 'Carreteras', 'url' => '#'],
                            // ['label' => 'Lugares', 'url' => ['lugares/index']],
                            // ['label' => 'Rutas', 'url' => '#'],
                            // ['label' => 'Catálogo de incidencias', 'url' => '#'],
                            '<li class="divider"></li>',
                            '<li class="dropdown-header">Plataforma</li>',
                            ['label' => 'Usuarios', 'url' => ['usuarios/index']],
                            '<li class="dropdown-header">UTIMAPP</li>',
                            ['label' => 'Alianzas', 'url' => ['alianzas/index']],
                            ['label' => 'Ciudades', 'url' => ['ciudades/index']],
                            // ['label' => 'Calificaciones', 'url' => ['calificaciones/index']],
                        ],
                    ],
                    [
                        'label' => 'Pacientes',
                        'url' => ['usuarios/pacientes'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Doctores',
                        'url' => ['usuarios/doctores'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Atenciones',
                        'url' => ['atenciones/index'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Turnos',
                        'url' => ['turnos/index'],
                        // 'linkOptions' => [],
                    ],
                    [
                        'label' => 'Reportes',
                        'items' => [
                            ['label' => 'Historico', 'url' => ['reportes/historico']],
                        ],
                    ],
                    '<li class="dropdown usuario-panel"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::img( Url::to('@web/images/usuario-icono.png'), ['class'=> 'usuario-icono']).' '.Yii::$app->user->identity->nombres.' <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" href="javascript:;" data-target="#modal_licencia"><i class="icon-user"></i> Suscripción</a></li>
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
    }elseif( Yii::$app->user->identity->tipo == 'Operador' ){
        echo NavX::widget([
            'items' => [
                [
                    'label' => 'Monitoreo',
                    'url' => ['site/index'],
                    // 'linkOptions' => [],
                ],
                // [
                //     'label' => 'Turnos',
                //     'url' => ['site/index'],
                //     // 'linkOptions' => [],
                // ],
                [
                    'label' => 'Reportes',
                    'items' => [
                        ['label' => 'Historico', 'url' => ['reportes/historico']],
                    ],
                ],
                '<li class="dropdown usuario-panel"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.Html::img( Url::to('@web/images/usuario-icono.png'), ['class'=> 'usuario-icono']).' '.Yii::$app->user->identity->nombres.' <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a data-toggle="modal" href="javascript:;" data-target="#modal_licencia"><i class="icon-user"></i> Suscripción</a></li>
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
    }elseif( Yii::$app->user->identity->tipo == 'Personal' ){
        echo NavX::widget([
            'items' => [
                '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Cerrar sesión',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
            ],
            'options' => ['class' => 'nav-pills navbar-right'],
            'activateParents' => true,
            'encodeLabels' => false
        ]);
    }    

}

NavBar::end();
?>