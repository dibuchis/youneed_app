<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\UploadedFile;
use app\models\Categorias;
use app\models\Servicios;
use app\models\Util;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use app\models\Trazabilidades;
use app\models\Usuarios;
use app\models\Traccar;

/**
 * EmpresasController implements the CRUD actions for Empresas model.
 */
class AjaxController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionSubirimagencategorias()
    {
        $model = new Categorias();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 300, 300);
                $size = $thumbnail->getSize();
                // if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(300, 300));
                    $thumbnail = $white->paste($thumbnail, new Point(300 / 2 - $size->getWidth() / 2, 300 / 2 - $size->getHeight() / 2));
                // }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 70]);

                $imageData = base64_encode(file_get_contents($path));

                return Json::encode([
                    [
                        'name' => $model->imagen,
                        'size' => $image->size,
                        'url' => $pathweb,
                        'thumbnailUrl' => $path,
                        // 'deleteUrl' => 'image-delete?name=' . $fileName,
                        'deleteType' => 'POST',
                        'base64' => 'data:'.mime_content_type($path).';base64,'.$imageData,
                    ],
                ]);
            }
        }
        return '';
    }

    public function actionSubirimagenservicios()
    {
        $model = new Servicios();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 300, 300);
                $size = $thumbnail->getSize();
                // if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(300, 300));
                    $thumbnail = $white->paste($thumbnail, new Point(300 / 2 - $size->getWidth() / 2, 300 / 2 - $size->getHeight() / 2));
                // }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 70]);

                $imageData = base64_encode(file_get_contents($path));

                return Json::encode([
                    [
                        'name' => $model->imagen,
                        'size' => $image->size,
                        'url' => $pathweb,
                        'thumbnailUrl' => $path,
                        // 'deleteUrl' => 'image-delete?name=' . $fileName,
                        'deleteType' => 'POST',
                        'base64' => 'data:'.mime_content_type($path).';base64,'.$imageData,
                    ],
                ]);
            }
        }
        return '';
    }

    public function actionListadoservicios(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $servicios = Servicios::find()
                  ->innerJoinWith('categoriasServicios', 't.id = categoriasServicios.servicio_id')
                  ->andWhere(['categorias_servicios.categoria_id' => $cat_id])
                  ->all();

                foreach ($servicios as $servicio) {
                    $out [] = ['id'=>$servicio->id, 'name'=>strip_tags($servicio->incluye)]; 
                }
                return Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }

    public function actionSubirfotografia()
    {
        $model = new Usuarios();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 400, 400);
                $size = $thumbnail->getSize();
                // if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(400, 400));
                    $thumbnail = $white->paste($thumbnail, new Point(400 / 2 - $size->getWidth() / 2, 400 / 2 - $size->getHeight() / 2));
                // }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 75]);

                $imageData = base64_encode(file_get_contents($path));

                return Json::encode([
                    [
                        'name' => $model->imagen,
                        'size' => $image->size,
                        'url' => $pathweb,
                        'thumbnailUrl' => $path,
                        // 'deleteUrl' => 'image-delete?name=' . $fileName,
                        'deleteType' => 'POST',
                        'base64' => 'data:'.mime_content_type($path).';base64,'.$imageData,
                    ],
                ]);
            }
        }
        return '';
    }

    public function actionSubirdocumento( $atributo_upload, $atributo_modelo )
    {
        $model = new Usuarios();
        $file = UploadedFile::getInstance($model, $atributo_upload);
        if( $file ){
            $model->$atributo_modelo = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ).'.'.$file->getExtension();
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadFiles']. $model->$atributo_modelo;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadFiles']. $model->$atributo_modelo;

            if( $file->saveAs($path) ){

                return Json::encode([
                    [
                        'name' => $model->$atributo_modelo,
                        'size' => $file->size,
                        'url' => $pathweb,
                        'thumbnailUrl' => $path,
                        // 'deleteUrl' => 'image-delete?name=' . $fileName,
                        'deleteType' => 'POST',
                    ],
                ]);
            }
        }
        return '';
    }

}
