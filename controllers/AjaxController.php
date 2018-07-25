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
use app\models\Alianzas;
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


    public function actionSubirimagencatalogos()
    {
        $model = new Catalogos();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 250, 150);
                $size = $thumbnail->getSize();
                if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(250, 150));
                    $thumbnail = $white->paste($thumbnail, new Point(250 / 2 - $size->getWidth() / 2, 150 / 2 - $size->getHeight() / 2));
                }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 69]);

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

    public function actionSubiriconocatalogos()
    {
        $model = new Catalogos();
        $image = UploadedFile::getInstance($model, 'imagen_upload_icono');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.png';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 250, 150);
                $size = $thumbnail->getSize();
                if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(250, 150));
                    $thumbnail = $white->paste($thumbnail, new Point(250 / 2 - $size->getWidth() / 2, 150 / 2 - $size->getHeight() / 2));
                }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 69]);

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

    public function actionSubirimagenalianza()
    {
        $model = new Alianzas();
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
                $thumbnail->save(Yii::getAlias($path), ['quality' => 65]);

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

    public function actionSubirimagenusuarios()
    {
        $model = new Usuarios();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 250, 150);
                $size = $thumbnail->getSize();
                if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(250, 150));
                    $thumbnail = $white->paste($thumbnail, new Point(250 / 2 - $size->getWidth() / 2, 150 / 2 - $size->getHeight() / 2));
                }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 69]);

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

    public function actionSubirimagenempresas()
    {
        $model = new Empresas();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 250, 150);
                $size = $thumbnail->getSize();
                if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(250, 150));
                    $thumbnail = $white->paste($thumbnail, new Point(250 / 2 - $size->getWidth() / 2, 150 / 2 - $size->getHeight() / 2));
                }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 69]);
                
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

    public function actionSubirimagencatalogosfront()
    {
        $model = new CatalogosFront();
        $image = UploadedFile::getInstance($model, 'imagen_upload');
        if( $image ){
            $model->imagen = Util::getGenerarPermalink( Yii::$app->security->generateRandomString() ). '.jpg';
            $path = \Yii::getAlias('@webroot') .Yii::$app->params['uploadImages']. $model->imagen;
            $pathweb = \Yii::getAlias('@web') .Yii::$app->params['uploadImages']. $model->imagen;
            if( $image->saveAs($path) ){

                $thumbnail = Image::thumbnail($path, 250, 150);
                $size = $thumbnail->getSize();
                if ($size->getWidth() < 250 or $size->getHeight() < 150) {
                    $white = Image::getImagine()->create(new Box(250, 150));
                    $thumbnail = $white->paste($thumbnail, new Point(250 / 2 - $size->getWidth() / 2, 150 / 2 - $size->getHeight() / 2));
                }
                $thumbnail->save(Yii::getAlias($path), ['quality' => 69]);

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

    public function actionGeocercasglobal(){
        $arrayParadasNo = array();
        $pas = Envios::find()->all();
        foreach ($pas as $pa) {
            $arrayParadasNo [] = json_decode( $pa->coordenadas_geocercas );
        }

        return Json::encode( $arrayParadasNo );
    }

    public function actionInfopedido(){
        if( isset( $_POST['pedido_id'] ) ){
            $pedido_id = $_POST['pedido_id'];
            $pedido = Pedidos::findOne( $pedido_id );
            $items_arrays = [];
            foreach ($pedido->items as $item) {
                $adicionales_arrays = [];
                foreach ($item->itemsAdicionales as $adicionale) {
                    $adicionales_arrays[] = $adicionale->adicional->nombres.' ('.$adicionale->adicional->pvp.')';
                }
                $items_arrays[] = ['imagen'=>$item->producto->imagen, 'nombre'=>$item->producto->nombre, 'costo_total'=>$item->costo_total, 'adicionales'=>$adicionales_arrays];
            }
            $traccar_id = 0;
            $repartidor = null;
            if( !is_null($pedido->repartidor_id) ){
                $traccar_id = $pedido->repartidor->traccar_id;
                $repartidor = $pedido->repartidor->attributes;
            }
            return $this->renderAjax('pedido_detalle', ['pedido'=>$pedido->attributes, 'direccion_entrega'=>$pedido->ubicacion->calle_principal.' ('.$pedido->ubicacion->referencia.')' , 'empresa'=>$pedido->empresa->attributes, 'items'=>$items_arrays, 'consumidor'=>$pedido->consumidor->attributes, 'repartidor'=>$repartidor, 'traccar_id'=>$traccar_id]);
        }elseif ( isset( $_POST['usuario_id'] ) ) {
            $usuario_id = $_POST['usuario_id'];
            $usuario = Usuarios::findOne( $usuario_id );
            return $this->renderAjax('usuario_detalle', ['model'=>$usuario->attributes]);
        }
        // return json_encode( [ 'empresa'=>$pedido->empresa->attributes, 'pedido'=>$pedido->attributes ] );
    }

    public function actionInfopedidorestaurante(){
        if( isset( $_POST['pedido_id'] ) ){
            $pedido_id = $_POST['pedido_id'];
            $pedido = Pedidos::findOne( $pedido_id );
            $items_arrays = [];
            foreach ($pedido->items as $item) {
                $adicionales_arrays = [];
                foreach ($item->itemsAdicionales as $adicionale) {
                    $adicionales_arrays[] = $adicionale->adicional->nombres.' ('.$adicionale->adicional->pvp.')';
                }
                $items_arrays[] = ['imagen'=>$item->producto->imagen, 'nombre'=>$item->producto->nombre, 'costo_total'=>$item->costo_total, 'adicionales'=>$adicionales_arrays];
            }
            $traccar_id = 0;
            $repartidor = null;
            // if( !is_null($pedido->repartidor_id) ){
            //     $traccar_id = $pedido->repartidor->traccar_id;
            //     $repartidor = $pedido->repartidor->attributes;
            // }
            return $this->renderAjax('pedido_detalle_restaurante', ['pedido'=>$pedido->attributes, 'direccion_entrega'=>$pedido->ubicacion->calle_principal.' ('.$pedido->ubicacion->referencia.')' , 'empresa'=>$pedido->empresa->attributes, 'items'=>$items_arrays, 'consumidor'=>$pedido->consumidor->attributes, 'repartidor'=>$repartidor, 'traccar_id'=>$traccar_id]);
        }
        // return json_encode( [ 'empresa'=>$pedido->empresa->attributes, 'pedido'=>$pedido->attributes ] );
    }

    public function actionActualizardispositivo(){
        $lat = 0;
        $lng = 0;
        $llegada_rest = 0;
        $salida_rest = 0;
        $llegada_cliente = 0;
        $salida_cliente = 0;

        $traccar_id = $_POST['traccar_id'];
        $device = Traccar::getDevice( $traccar_id );  
        
        if( isset( $device[0]['positionId'] ) ){
            $posicion = Traccar::getPosition( $device[0]['positionId'] );
            if( isset( $posicion[0] ) ){
              $lat = $posicion[0]['latitude'];
              $lng = $posicion[0]['longitude'];
            }
        }

        if( isset( $_POST['pedido_id'] ) ){
            if( $_POST['pedido_id'] > 0 ){
                $trazabilidad = Trazabilidades::find()->andWhere(['pedido_id'=>$_POST['pedido_id']])->one();
                if( is_object( $trazabilidad ) ){
                    $llegada_rest = $trazabilidad->restaurant_llegada;
                    $salida_rest = $trazabilidad->restaurant_salida;
                    $llegada_cliente = $trazabilidad->cliente_llegada;
                    $salida_cliente = $trazabilidad->cliente_salida;
                }
            }
        }

        return json_encode( ['lat'=>$lat, 'lng'=>$lng, 'llegada_rest'=>$llegada_rest, 'salida_rest'=>$salida_rest, 'llegada_cliente'=>$llegada_cliente, 'salida_cliente'=>$salida_cliente] );
    }

    public function actionAdicionalesempresa(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $adicionales = Adicionales::find()->andWhere( ['empresa_id'=>$cat_id] )->all();
                foreach ($adicionales as $adicional) {
                    $out [] = ['id'=>$adicional->id, 'name'=>$adicional->nombres.' ($'.$adicional->pvp.' USD)']; 
                }
                return Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }

    public function actionOcultarpedido(){
        $pedido_id = $_POST['pedido_id'];
        $pedido = Pedidos::findOne( $pedido_id );
        if( is_object( $pedido ) ){
            $pedido->mostrar_monitoreo = 0;
            if( $pedido->save() ){
                return json_encode( ['error'=>0] );
            }else{
                return json_encode( $pedido->getErrors() );
            }
        }
    }

    public function actionExtornarcancelarpedido(){
        $pedido_id = $_POST['pedido_id'];
        $pedido = Pedidos::findOne( $pedido_id );
        if( is_object( $pedido ) ){

            $url = Yii::$app->params['payphone_reverso'];
            $data='{"clientId":"'.$pedido->client_transaction_id.'",}';
            $headers = array(
              'Content-Type: application/json',
              sprintf('Authorization: Bearer %s', Yii::$app->params['payphone_token'])
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            

        }
    }

    public function actionAsignarmotorizadomanualmente(){
        $repartidor_id = $_POST['repartidor_id'];
        $pedido_id = $_POST['pedido_id'];
       
        $repartidor = Usuarios::find()->andWhere( ['id'=>$repartidor_id, 'en_ruta'=>0] )->one();
        
        if( is_object( $repartidor ) ){
            NotificacionesPushPedidos::deleteAll( [ 'pedido_id'=>$pedido_id ] );
            $noti = new NotificacionesPushPedidos();
            $noti->usuario_id = $repartidor_id;
            $noti->pedido_id = $pedido_id;
            $noti->fecha = date('Y-m-d');
            $noti->save();
            Util::enviarNotificacionesPush( [$repartidor->token_push], Util::getMensajePush(1) );
            return json_encode( ['error'=>0, 'message'=>'Se envio una solicitud al repartidor para que acepte el pedido.'] );
        }else{
            return json_encode( ['error'=>1, 'message'=>'El repartidor ya fue asignado a otro pedido.'] );
        }
    }

    public function actionGetdatamarker( $id = null ){
        if( is_null( $id ) ){
            // return [ 'status'=>0, 'message'=>'No se encontró información del doctor, vuelva a intentarlo' ];
        }else{
            $doctor = Usuarios::findOne( $id );
            if( is_object( $doctor ) ){

                if( !is_null( $doctor->dispositivo->traccar_id ) ){
                    $dispositivo = Traccar::getDevice( $doctor->dispositivo->traccar_id );
                    if( isset( $dispositivo[0] ) ){
                      $posicion_id = $dispositivo[0]['positionId'];
                      $posicion = Traccar::getPosition( $posicion_id );
                      if( isset( $posicion[0] ) ){
                        $lat_doctor = $posicion[0]['latitude'];
                        $lon_doctor = $posicion[0]['longitude'];
                      }
                    }
                }                
                if( isset( $lat_doctor ) ){
                    return json_encode( [ 'status'=>1, 'doctor'=>[ 'nombres'=>$doctor->nombres, 'apellidos'=>$doctor->apellidos, 'numero_celular'=>$doctor->numero_celular, 'lat'=>$lat_doctor, 'lon'=>$lon_doctor ] ] );
                }
            }else{
                return json_encode( [ 'status'=>0, 'message'=>'Ocurrio un error, vuelva a intentarlo' ] );
            }
        }
    }

}
