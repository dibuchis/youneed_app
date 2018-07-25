<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DibujadoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Varela+Round',
        'css/global.css',
        'css/admin.css',
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCWmnu8hgRqQzEIU3Sp35ygYoyq_WOIC6Q&libraries=drawing,places',
        'js/gmaps.js',
        // 'js/dibujado.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
