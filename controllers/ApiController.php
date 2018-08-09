<?php 
namespace app\controllers;
 
use Yii;
// use app\models\Pedidos;
use app\models\Geo;
use app\models\Util;
use app\models\Usuarios;
use app\models\Traccar;
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
            'login'=>['post'],
            'register'=>['post'],
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
            $token = Util::getGenerarPermalink( Yii::$app->getSecurity()->generatePasswordHash('YOUNEEDAbitmedia'.date('Y-m-d H:i:s') ) );
            $usuario->token = $token;
            
            if( $usuario->save() ){
              
              if( $usuario->tipo != 'Asociado' && $usuario->tipo != 'Cliente' ){
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Usuario válido en ambiente web solamente'
                      ];
              }

              $this->setHeader(200);
              return [  'status'=>1, 
                        'message'=>'Bienvenido: '.$usuario->nombres,
                        'data'=>[
                          'usuario'=>[
                            'tipo'=>$usuario->tipo,
                            'display_name'=>$usuario->nombres.' '.$usuario->apellidos,
                            'nombres'=>$usuario->nombres,
                            'apellidos'=>$usuario->apellidos,
                            'numero_celular'=>$usuario->numero_celular,
                            'imagen'=>$usuario->imagen,
                            'token'=>$token,
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
      if( isset( $_POST['tipo'] ) ){
        $request = Yii::$app->request;
        $model = new Usuarios();
        $model->fecha_creacion = date('Y-m-d H:i:s');
        $model->tipo_usuario = 1;
        if( isset( $_POST['nombres'] ) && isset( $_POST['apellidos'] ) ){
          $model->codigo_familiar = strtoupper( substr($_POST['nombres'], 0, 3).substr($_POST['apellidos'], 0, 3) ).substr(time(), -4, 4);
        }
        if( $_POST['tipo'] == 'Doctor' ){ //Doctor
          $model->estado_id = 2;
          $model->scenario = 'doctor';
        }elseif( $_POST['tipo'] == 'Paciente' ){
          $model->estado_id = 1;
          $model->scenario = 'paciente';
        }

        if( $model->load($request->post(), '') ){
          
          if( isset( $_POST['validar'] ) && $_POST['validar'] == 1 ){
            $model->validate();

            $this->setHeader(200);
            return [  'status'=>( count($model->getErrors()) == 0 ) ? 1 : 0, 
                      'message'=>'Información de validación',
                      'data'=>[ 'errores'=>$model->getErrors() ],
                  ];
          }else{
            if( $model->save() ){
              $model->clave = Yii::$app->getSecurity()->generatePasswordHash( $model->clave );
              $model->save();
              $dispositivo = new Dispositivos;
              $dispositivo->nombre = $model->identificacion;
              $dispositivo->placa = $model->codigo_familiar;
              $dispositivo->alias = $model->codigo_familiar;
              $dispositivo->imei = strtotime( date('Y-m-d H:i:s') );
              $dispositivo->imei = rand(pow(10, 4-1), pow(10, 4)-1).time();
              $dispositivo->tipo = 'Verde';
              $dispositivo->utim_app_tipo = $_POST['tipo'];
              $dispositivo->tipo_dispositivo = 1;
              $dispositivo->save();
              $response = Traccar::setDevice( $dispositivo, 'POST' );
              $dispositivo->traccar_id = $response['id'];
              $dispositivo->save();

              $model->dispositivo_id = $dispositivo->id;
              $model->save();

              $this->setHeader(200);
              return [  'status'=>1, 
                        'message'=>'Registrado exitosamente',
                    ];
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'Ocurrio un error al registrar doctor',
                        'data'=>[ 'errores'=>$model->getErrors() ],
                    ];
            }
          }
          

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'El valor del parámetro tipo no es correcto, verificar documentación de API',
                ];
        }

      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro tipo es requerido',
              ];
      }
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
}