<?php 
namespace app\controllers;
 
use Yii;
// use app\models\Pedidos;
use app\models\Geo;
use app\models\Util;
use app\models\Usuarios;
use app\models\Traccar;
use app\models\Configuraciones;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\Url;
use \yii\web\Response;

class ApiController extends Controller
{
 
    public function behaviors()
    {
    return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
            'getinfoapp'=>['get'],
            'login'=>['post'],
            'register'=>['post'],
            'recoverpassword'=>['get'],
            'termsconditions'=>['get'],
        ],
 
        ]
    ];
    }
 
 
    public function beforeAction($event)
    {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $action = $event->id;
      if (isset($this->actions[$action])) {
          $verbs = $this->actions[$action];
      } elseif (isset($this->actions['*'])) {
          $verbs = $this->actions['*'];
      } else {
          return $event->isValid;
      }
      $verb = Yii::$app->getRequest()->getMethod();
   
        $allowed = array_map('strtoupper', $verbs);
   
        if (!in_array($verb, $allowed)) {
   
          $this->setHeader(400);
          return array('status'=>0,'error_code'=>400,'message'=>'Método no encontrado');
          exit;
   
      }  
      return true;  
    }

    private function setHeader($status)
    {
 
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type="application/json; charset=utf-8";
 
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "Abitmedia <abitmedia.com>");
      header("Access-Control-Allow-Origin: *");
    }

    private function _getStatusCodeMessage($status)
    {
      // these could be stored in a .ini file and loaded
      // via parse_ini_file()... however, this will suffice
      // for an example
      $codes = Array(
          200 => 'OK',
          400 => 'Bad Request',
          401 => 'Unauthorized',
          402 => 'Payment Required',
          403 => 'Forbidden',
          404 => 'Not Found',
          500 => 'Internal Server Error',
          501 => 'Not Implemented',
      );
      return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function actionGetinfoapp( $token = null ){
      if( is_null( $token ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Error al recuperar información de conectividad GPS',
              ];
      }else{
        $this->setHeader(200);
        return [  'status'=>1, 
                  'message'=>'Información global de APP',
                  'data'=>[
                    // 'traccar_user'=>Yii::$app->params['traccar']['usuario'],
                    // 'traccar_pass'=>Yii::$app->params['traccar']['clave'],
                    'traccar_server'=>Yii::$app->params['traccar']['transmision_url'],
                    // 'traccar_server_rest'=>Yii::$app->params['traccar']['rest_url'],
                  ]
              ];
        
      }
    }

    public function actionLogin(){
      if ( Yii::$app->request->post('email') && Yii::$app->request->post('clave') ) {
          $usuario = Usuarios::find()->andWhere( ['email'=>Yii::$app->request->post('email'), 'estado'=>1] )->one();

          if( !is_object( $usuario ) ){
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Usuario no encontrado o desactivado'
                  ];
          }else{
            if (!$usuario || !$usuario->validatePassword( Yii::$app->request->post('clave') )) {
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Email o contraseña incorrectos'
                      ];
            }
          }

          if( is_object( $usuario ) ){
            
            if( $usuario->save() ){
              
              if( $usuario->tipo != 'Asociado' && $usuario->tipo != 'Cliente' ){
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Usuario válido en ambiente web solamente'
                      ];
              }

              $this->setHeader(200);
              return [  'status'=>1, 
                        'message'=>'Bienvenid@: '.$usuario->nombres,
                        'data'=>[
                          'usuario'=>[
                            'tipo'=>$usuario->tipo,
                            'display_name'=>$usuario->nombres.' '.$usuario->apellidos,
                            'nombres'=>$usuario->nombres,
                            'apellidos'=>$usuario->apellidos,
                            'numero_celular'=>$usuario->numero_celular,
                            'imagen'=>$usuario->imagen,
                            'token'=>$usuario->token,
                            'traccar_id'=>$usuario->traccar_id,
                          ]
                        ]
                    ];
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'Ocurrio un error al ingresar',
                        'data'=>[ 'errors'=>$usuario->getErrors() ],
                    ];
            }

          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Usuario no encontrado o desactivado'
                  ];
          }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Email y contraseña son requeridos',
              ];
      }
    }

    public function actionRegister(){
      $request = Yii::$app->request;
      $model = new Usuarios();
      
      if( $model->load($request->post(), '') ){
        
        if( Yii::$app->request->post('tipo') == 'Asociado' ){
          $model->scenario = 'Asociado';
        }elseif( Yii::$app->request->post('tipo') == 'Cliente' ){
          $model->scenario = 'Cliente';
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'El parámetro tipo puede ser: Asociado o Cliente',
                ];
        }

        if( isset( $_POST['validate'] ) && $_POST['validate'] == 1 ){
          $model->validate();

          $this->setHeader(200);
          return [  'status'=>( count($model->getErrors()) == 0 ) ? 1 : 0, 
                    'message'=>'Información de validación',
                    'data'=>[ 'errors'=>$model->getErrors() ],
                ];
        }else{
          if( $model->save() ){
            $model->token = Util::getGenerarPermalink( Yii::$app->getSecurity()->generatePasswordHash('YOUAbitmedia'.$model->id.date('Y-m-d H:i:s') ) );
            $model->clave = Yii::$app->getSecurity()->generatePasswordHash( $model->clave );
            $model->imei = rand(pow(10, 4-1), pow(10, 4)-1).time();
            $model->save();

            $response = Traccar::setDevice( $model, 'POST' );
            $model->traccar_id = $response['id'];
            $model->save();

            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Registrado exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al registrar usuario',
                      'data'=>[ 'errores'=>$model->getErrors() ],
                  ];
          }
        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Parámetros recibidos incorrectos',
              ];
      }
    }

    public function actionRecoverpassword( $email = null ){
      if( is_null( $email ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Ingrese su email',
              ];
      }else{
        $model = Usuarios::find()->andWhere( [ 'email'=>$email ] )->one();
        if( is_object( $model ) ){
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Se le envió un email con una clave temporal, le recomendamos cambiarla',
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No encontramos un usuario con el email ingresado',
                ];
        }
      }
    }

    public function actionTermsconditions(){
      $config = Configuraciones::findOne(1);
      $this->setHeader(200);
      return [  'status'=>1, 
                'message'=>'Términos y condiciones',
                'data'=>$config->politicas_condiciones,
            ]; 
    }

}