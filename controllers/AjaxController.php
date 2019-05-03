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
use app\models\CategoriasServicios;
use app\models\UsuariosServicios;
use app\models\Notificaciones;
use app\models\Util;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use app\models\Trazabilidades;
use app\models\Usuarios;
use app\models\Traccar;
use app\models\Paises;
use app\models\Ciudades;

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

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    public function actionContratarasociado(){
        $request = Yii::$app->request;
        
        $cliente_id = Yii::$app->request->post('cliente_id');
        $asociado_id = Yii::$app->request->post('asociado_id');
  
        print_r($request);
        exit();
  
        $pedido = Pedidos::find()->andWhere( ['cliente_id'=>$cliente_id, 'asociado_id'=>$asociado_id, 'estado'=>0] )->one();
        
        if( !is_object( $pedido ) ){
          $pedido = new Pedidos();
  
          $cliente = Usuarios::find()->andWhere( ['id'=>Yii::$app->request->post('cliente_id')] )->one();
          $asociado = Usuarios::find()->andWhere( ['id'=>Yii::$app->request->post('asociado_id')] )->one();
          $servicio = Servicios::find()->andWhere( ['id'=>Yii::$app->request->post('servicio_id')] )->one();
  
          if( $pedido->load($request->post(), '') ){
            //$pedido->cliente_id = $cliente->id;
            $pedido->identificacion = $cliente->identificacion;
            $pedido->razon_social = $cliente->nombres.' '.$cliente->apellidos;
            $pedido->email = $cliente->email;
            $pedido->telefono = $cliente->numero_celular;
            $pedido->fecha_creacion = date('Y-m-d H:i:s');
            $pedido->estado = 0;
            $pedido->tipo_atencion = Yii::$app->request->post('tipo_atencion');
  
            if($pedido->save()){
  
              //Email al Cliente
              try{
                  $send = Yii::$app->mailer->compose()
                  ->setFrom('noreply@youneed.com.ec')
                  ->setTo($cliente->email)
                  ->setSubject("YouNeed - Servicio Solicitado")
                  ->setHtmlBody('<div style="background:#2e8a96; margin:0px auto; max-width:650px; height:80px; padding:8px;color:white;"> <img src="https://app.youneed.com.ec/images/logo-admin.png" style="width:156px; height:auto;margin:12px 25px 12px 12px"></div> <div style="padding:25px; margin:0px auto; max-width:650px;"> <h2 style="font-family:Arial, Helvetica, sans-serif; color:#117c8f;">' . $cliente->nombres . ',</h2> <h3 style="font-family:Arial, Helvetica, sans-serif; color:#117c8f;">Solicitud de Servicio</h3> </div> <div style="margin:25px auto; max-width:650px;"><p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">' .
                  'Has solicitado el servicio ' . $servicio->nombre . ' del asociado ' . $asociado->nombres . " " . $asociado->apellidos . ' en breve tendras detalle de tu solicitud.'.            
                  '</p> <p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">Por favor, ingresa a tu perfil para ver los datos de tu solicitud: </p> <p><a style="background-color: #178b89!important; border-color: #178b89!important; line-height: 1.42857143; text-align: center; white-space: nowrap; font-size: 14px; padding: 6px 12px; color: #fff; margin: 35px auto 10px; width: 180px; display: block;" href="https://www.youneed.com.ec/app/login.php">Mi Perfil</a> </p> </div> </div> <div style="font-family:Arial, Helvetica, sans-serif; height:40px; margin:25px auto 0px; max-width:650px; background:#9a999e; text-align:center; padding:7px; padding-top:15px; color:#fff;">YouNeed® Todos los derechos reservados.</div>', 'text/html')
                  ->send();
                  //echo "<script>console.log('" . $send . "');</script>";
              }catch(Exception $e){
                  //echo "<script>console.log('Error de envío de Email');</script>";
              }
  
              //Email al Asociado
              try{
                $send = Yii::$app->mailer->compose()
                ->setFrom('noreply@youneed.com.ec')
                ->setTo($asociado->email)
                ->setSubject("YouNeed - Servicio Solicitado")
                ->setHtmlBody('<div style="background:#2e8a96; margin:0px auto; max-width:650px; height:80px; padding:8px;color:white;"> <img src="https://app.youneed.com.ec/images/logo-admin.png" style="width:156px; height:auto;margin:12px 25px 12px 12px"></div> <div style="padding:25px; margin:0px auto; max-width:650px;"> <h2 style="font-family:Arial, Helvetica, sans-serif; color:#117c8f;">' . $cliente->nombres . ',</h2> <h3 style="font-family:Arial, Helvetica, sans-serif; color:#117c8f;">Solicitud de Servicio</h3> </div> <div style="margin:25px auto; max-width:650px; font-family:Arial, Helvetica, sans-serif; color:#9a999e;">' .
                '<h3>Datos de la Solicitud:</h3>' .
                '<table style="border-color:#e3e3e3;">' .            
                '<tr>' .
                  '<td>Nombre</td>' .
                  '<td>' . $cliente->nombres . " " . $cliente->apellidos . '</td>' .
                '</tr>' .
                '<tr>' .
                  '<td>Servicio</td>' .
                  '<td>' . $servicio->nombre . '</td>' .
                '</tr>' .
                '<tr>' .
                  '<td>Fecha de solicitud</td>' .
                  '<td>' . date('Y/m/d H:i:s') . '</td>' .
                '</tr>' .
                '</table>' .            
                '<p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">Por favor, ingresa a tu perfil para ver los datos de tu solicitud: </p> <p><a style="background-color: #178b89!important; border-color: #178b89!important; line-height: 1.42857143; text-align: center; white-space: nowrap; font-size: 14px; padding: 6px 12px; color: #fff; margin: 35px auto 10px; width: 180px; display: block;" href="https://www.youneed.com.ec/app/login.php">Mi Perfil</a> </p> </div> </div> <div style="font-family:Arial, Helvetica, sans-serif; height:40px; margin:25px auto 0px; max-width:650px; background:#9a999e; text-align:center; padding:7px; padding-top:15px; color:#fff;">YouNeed® Todos los derechos reservados.</div>', 'text/html')
                ->send();
                //echo "<script>console.log('" . $send . "');</script>";
            }catch(Exception $e){
                //echo "<script>console.log('Error de envío de Email');</script>";
            }
  
              $notificacionUsuario = new Notificacion();
              $notificacionUsuario::create($notificacionUsuario->id, 5);
  
              $notificacionAsociado = new Notificacion();
              $notificacionAsociado::create($notificacionAsociado->id, 6);
  
              $this->setHeader(200);
              return [  'status'=>1, 
                  'message'=>'Contrato Realizado'
              ];
  
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                  'message'=>'Error de Sistema'
              ];
            }
          } 
        }
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

    public function actionGetservicio(){
        $out = [];
        if (isset($_REQUEST['serviceID'])) {
            $serviceID = $_REQUEST['serviceID'];

                $cat_id = CategoriasServicios::find()->where(['servicio_id' => $serviceID])->one();

                $servicio =  Servicios::find()->where(['id' => $serviceID])->asArray()->one();

                
                $out = $servicio;
                
                $out["cat_id"] = $cat_id->categoria_id;

                // return Json::encode(['output'=>$out, 'selected'=>'']);
                return Json::encode(['servicio'=>$out]);
        }
    }

    public function actionListadocategorias(){
        $out = [];
            $categorias = Categorias::find()
                ->all();

            foreach ($categorias as $cat) {
                // $out [] = ['id'=>$servicio->servicio_id, 'name'=>strip_tags($servicio->servicio->nombre)]; 
                $out [] = ['id'=>$cat->id, 'nombre'=>$cat->nombre, 'imagen'=>$cat->imagen, 'descripcion'=>$cat->descripcion]; 
                // $out [] = ['item'=>'<div class="serv-item" data-id="' . $servicio->servicio_id . '"><img src="' . $servicio->servicio->imagen . '"><span>' . strip_tags($servicio->servicio->nombre) . '</span></div>']; 
            }
            // return Json::encode(['output'=>$out, 'selected'=>'']);
            return Json::encode(['output'=>$out]);
            return;
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }

    public function actionListadoasociados(){
        $out = [];
        $rows = 10;
        $offset = 0;

        if (isset($_REQUEST['srv_id'])) {
            $srv_id = $_REQUEST['srv_id'];
            if ($srv_id != null) {
                
                if(isset($_REQUEST['page'])){
                    $offset = ($_REQUEST['page'] * $rows) - $rows;
                }

                $total = UsuariosServicios::find()
                  ->andWhere(['in', 'servicio_id', $srv_id ])
                  ->count();

                $pages = ceil($total / $rows);

                $usuariosLista = UsuariosServicios::find()
                  ->andWhere(['in', 'servicio_id', $srv_id ])
                  ->orderBy(['id' => SORT_ASC])
                  ->limit($rows)
                  ->offset($offset)
                  ->all();

                foreach ($usuariosLista as $usuarioItem) {
                    $usuario = Usuarios::findOne($usuarioItem->usuario_id);
                    $ciudad = Ciudades::findOne($usuario->ciudad_id);
                    // $out [] = ['id'=>$servicio->servicio_id, 'name'=>strip_tags($servicio->servicio->nombre)]; 
                    $out [] = ['id'=>$usuario->id, 'nombre'=> $usuario->nombres, 'ciudad' => $ciudad, 'imagen'=> $usuario->imagen]; 
                    // $out [] = ['item'=>'<div class="serv-item" data-id="' . $servicio->servicio_id . '"><img src="' . $servicio->servicio->imagen . '"><span>' . strip_tags($servicio->servicio->nombre) . '</span></div>']; 
                }
                // return Json::encode(['output'=>$out, 'selected'=>'']);
                return Json::encode([
                    'output'=>$out, 
                    'total' => $total, 
                    'pages' => $pages,
                    'offset' => $offset,
                    'rows' => $rows
                ]);
                return;
            }
        }
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }
    
    public function actionListadoservicios(){
        $out = [];
        if (isset($_REQUEST['depdrop_parents'])) {
            $parents = $_REQUEST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents;

                $servicios = CategoriasServicios::find()
                  ->andWhere(['in', 'categoria_id', $cat_id ])
                  ->all();

                foreach ($servicios as $servicio) {
                    // $out [] = ['id'=>$servicio->servicio_id, 'name'=>strip_tags($servicio->servicio->nombre)]; 
                    $out [] = ['id'=>$servicio->servicio_id, 'parent'=> $cat_id, 'imagen'=> $servicio->servicio->imagen, 'nombre'=> $servicio->servicio->nombre, 'precio'=> $servicio->servicio->total, 'body' => '<img src="' . $servicio->servicio->imagen . '"><span>' . strip_tags($servicio->servicio->nombre) . '</span><btn class="btn btn-vermas btn-sm center-block" data-srv="' . $servicio->servicio_id . '">Conocer más</btn><btn class="btn btn-success btn-sm center-block btn_add_service" data-srv="' . $servicio->servicio_id . '" data-cat="' . $cat_id . '" data-name="' . strip_tags($servicio->servicio->nombre) . '" >Escoger</btn>']; 
                    // $out [] = ['item'=>'<div class="serv-item" data-id="' . $servicio->servicio_id . '"><img src="' . $servicio->servicio->imagen . '"><span>' . strip_tags($servicio->servicio->nombre) . '</span></div>']; 
                }
                // return Json::encode(['output'=>$out, 'selected'=>'']);
                return Json::encode(['output'=>$out]);
                return;
            }
        }
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }

    public function actionContarasociados(){
        
        if(isset($_GET['srv_id'])){
            $srv_id = $_GET['srv_id'];
            $servicio = Servicios::findOne($srv_id);
            $count = (new \yii\db\Query())
            ->from('usuarios_servicios')
            ->where(['servicio_id' => $srv_id])
            ->count();

            return Json::encode(['count'=>$count, 'nombre_servicio'=>$servicio->nombre]);
        }else{
            return Json::encode(['count'=>0, 'nombre_servicio'=>$servicio->nombre]);
        }
    }

    public function actionVerasociado(){
        
        if(isset($_REQUEST['api_token'])){

            if(isset($_REQUEST['aso_id']) && $_REQUEST['api_token'] == Yii::$app->params['api_token']){
                $aso_id = $_REQUEST['aso_id'];
                $asociado = Usuarios::find()
                    ->where(['id' => $aso_id])
                    ->select([
                        'id',
                        'imagen',
                        'nombres', 
                        'apellidos', 
                        'estado',
                        'dias_trabajo', 
                        'horarios_trabajo',
                        'observaciones', 
                        'pais_id', 
                        'ciudad_id'
                    ])
                    ->asArray()
                    ->one();

                $asociado['estado'] = Yii::$app->params['estados_genericos'][$asociado['estado']];

                $asociado['pais'] = Paises::findOne($asociado['pais_id']);

                $asociado['ciudad'] = Ciudades::findOne($asociado['ciudad_id']);
                // $asociado = Usuarios::findOne()->one();
                
                return Json::encode($asociado);
            }else{
                return Json::encode(['id'=>null]);
            }
        }else{
            return Json::encode(['id'=>null]);
        }
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

    public function actionCiudades(){
        $out = [];
        if (isset($_REQUEST['depdrop_parents'])) {
            $parents = $_REQUEST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $adicionales = Ciudades::find()->andWhere( ['pais_id'=>$cat_id] )->all();
                foreach ($adicionales as $adicional) {
                    $out [] = ['id'=>$adicional->id, 'name'=>$adicional->nombre]; 
                }
                return Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        return Json::encode(['output'=>'', 'Seleccione'=>'']);
    }

}
