<?php 
namespace app\controllers;
 
use Yii;
// use app\models\Pedidos;
use app\models\Geo;
use app\models\Util;
use app\models\Usuarios;
use app\models\Traccar;
use app\models\Configuraciones;
use app\models\Categorias;
use app\models\Servicios;
use app\models\Pedidos;
use app\models\Items;
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
            'getinfoapp'=>['get'], //Información global de la plataforma para rastreo y variables internas
            'login'=>['post'], //Ingreso de usuarios
            'register'=>['post'], //Registro de usuarios
            'recoverpassword'=>['get'], //Recuperar la clave de la cuenta
            'termsconditions'=>['get'], //Información de terminos y condiciones
            'getcategories'=>['get'], //Listado de categorias si se especifica el parametro categoria_id muestra la informacion de la misma
            'getassociates'=>['get'], //Listado de asociados
            'getservices'=>['get'], //Listado de servicios
            'setitemcart'=>['post'], //Permite agregar un item al carrito de compras
            'deleteitemcart'=>['get'], //Permite borrar un item del carrito de compras
            'getshoppingcart'=>['get'], //Devuelve el carrito de compras de un usuario
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

              $items_cart = 0;
              $pedido = Pedidos::find()->andWhere( ['cliente_id'=>$usuario->id, 'estado'=>0] )->one();
              
              if( is_object( $pedido ) ){
                $items_cart = count( $pedido->items );
              }

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
                            'email'=>$usuario->email,
                            'numero_celular'=>$usuario->numero_celular,
                            'imagen'=>$usuario->imagen,
                            'token'=>$usuario->token,
                            'traccar_id'=>$usuario->traccar_id,
                            'traccar_transmision'=>Yii::$app->params['traccar']['transmision_url'],
                            'imei'=>$usuario->imei,
                            'items_cart'=>$items_cart,
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

            // $response = Traccar::setDevice( $model, 'POST' );
            // $model->traccar_id = $response['id'];
            // $model->save();

            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Registrado exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al registrar usuario',
                      'data'=>[ 'errors'=>$model->getErrors() ],
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

    public function actionGetcategories( $categoria_id = null ){
      
      if( is_null( $categoria_id ) ){
        $array_categorias = [];
        $categorias = Categorias::find();
        $categorias->orderBy(['rand()' => SORT_DESC]);
        // $categorias->limit(10);
        $categorias = $categorias->all();
        foreach ($categorias as $categoria) {
          $array_categorias[] = [
                                  'id' => $categoria->id,
                                  'nombre' => mb_convert_encoding( trim(substr( $categoria->nombre, 0, 100 )).'...' , 'UTF-8', 'UTF-8' ),
                                  'descripcion' => mb_convert_encoding( trim( substr( strip_tags($categoria->descripcion), 0, 80 ) ).'...', 'UTF-8', 'UTF-8' ),
                                  'imagen' => $categoria->imagen,
                                ];
        }
        $this->setHeader(200);
        return [  'status'=>1, 
                  'message'=>'Listado de categorías',
                  'data'=>[ 'categorias'=>$array_categorias ],
              ];  
      }else{
        $categoria = Categorias::findOne( $categoria_id );
        if( is_object( $categoria ) ){

          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Información de categoria',
                    'data'=>[ 'categoria'=>$categoria->attributes ],
                ];  
        
        }else{

          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Categoria no encontrada',
                ];

        }
      }
      
    }

    public function actionGetassociates( $categoria_id = null, $servicio_id = null, $asociado_id = null ){
      
      $array_asociados = [];
      $asociados = Usuarios::find();
      
      if( !is_null( $categoria_id ) ){
        $asociados->andWhere( [ 'categoria_id'=>$categoria_id ] );
      }
      if( !is_null( $servicio_id ) ){
        $asociados->innerJoinWith('usuariosServicios', 't.id = usuariosServicios.usuario_id');
        $asociados->andWhere( [ 'usuarios_servicios.servicio_id'=>$servicio_id ] );
      }
      if( !is_null( $asociado_id ) ){
        $asociados->andWhere( [ 'id'=>$asociado_id ] );
      }

      $asociados->andWhere( [ 'tipo'=>'Asociado', 'estado'=>1 ] );
      // $categorias->limit(10);
      $asociados = $asociados->all();
      foreach ($asociados as $asociado) {
        $array_asociados[] = $asociado->attributes;
      }
        
      $this->setHeader(200);
      return [  'status'=>1, 
                'message'=>'Listado de asociados',
                'data'=>[ 'asociados'=>$array_asociados, 'total'=>count( $array_asociados ), 'servicio_id'=>$servicio_id ],
            ];  
      
    }

    public function actionGetservices( $servicio_id = null, $asociado_id = null ){
      
      $array_servicios = [];
      $array_asociado = [];

      if( !is_null( $asociado_id ) ){
        $asociado = Usuarios::findOne( $asociado_id );
        if( is_object( $asociado ) ){
          $array_asociado = [ 'id' => $asociado->id, 'nombres' => $asociado->nombres, 'apellidos' => $asociado->apellidos ];
        }
      }

      $servicios = Servicios::find();
      $servicios->andWhere( [ 'mostrar_app'=>1 ] );
      if( !is_null( $servicio_id ) ){
        $servicios->andWhere( [ 'id'=>$servicio_id ] );
      }
      // $categorias->limit(10);
      $servicios = $servicios->all();
      foreach ($servicios as $servicio) {
        $array_servicios[] = [
                                'id' => $servicio->id,
                                'nombre' => ( is_null( $servicio_id ) ) ? mb_convert_encoding( trim(substr( $servicio->nombre, 0, 100 )).'...' , 'UTF-8', 'UTF-8' ) : $servicio->nombre,
                                'incluye' => ( is_null( $servicio_id ) ) ? mb_convert_encoding( trim( substr( strip_tags($servicio->incluye), 0, 80 ) ).'...', 'UTF-8', 'UTF-8' ) : $servicio->incluye,
                                'imagen' => $servicio->imagen,
                                'no_incluye' => $servicio->no_incluye,
                                'aplica_iva' => $servicio->aplica_iva,
                                'subtotal' => $servicio->subtotal,
                                'total' => $servicio->total,
                                'subtotal_diagnostico' => (float)Yii::$app->params['parametros_globales']['valor_visita_diagnostico'] / (float)Yii::$app->params['parametros_globales']['iva_valor'] ,
                                'total_diagnostico' => Yii::$app->params['parametros_globales']['valor_visita_diagnostico'],
                                'asociado' => $array_asociado,
                              ];
      }
        
      $this->setHeader(200);
      return [  'status'=>1, 
                'message'=>'Listado de asociados',
                'data'=>[ 'servicios'=>$array_servicios, 'total'=>count( $array_servicios ) ],
            ];
      
    }

    public function actionSetitemcart(){
      // token
      // servicio_id
      // cantidad
      // costo_unitario
      // es_diagnostico
      // tipo_atencion  
      // asociado_id   
      $request = Yii::$app->request;
      $model = new Items();
      
      if( $model->load($request->post(), '') ){

        if( Yii::$app->request->post('token') ){ //Token de usuario

          $usuario = Usuarios::find()->andWhere( ['token'=>Yii::$app->request->post('token')] )->one();
          if( is_object( $usuario ) ){

            $pedido = Pedidos::find()->andWhere( ['cliente_id'=>$usuario->id, 'estado'=>0] )->one();
            
            if( !is_object( $pedido ) ){
              $pedido = new Pedidos();
              $pedido->cliente_id = $usuario->id;
              $pedido->identificacion = $usuario->identificacion;
              $pedido->razon_social = $usuario->nombres.' '.$usuario->apellidos;
              $pedido->email = $usuario->email;
              $pedido->telefono = $usuario->numero_celular;
              $pedido->fecha_creacion = date('Y-m-d H:i:s');
              $pedido->estado = 0;
              $pedido->tipo_atencion = Yii::$app->request->post('tipo_atencion');
              $pedido->save();
            }
            
            $item = null;
            if( Yii::$app->request->post('es_diagnostico') != 1 ){
              $item = Items::find()->andWhere(['pedido_id'=>$pedido->id, 'servicio_id'=>Yii::$app->request->post('servicio_id'), 'es_diagnostico'=>0])->one();
            }
            
            if( is_object( $item ) ){
              $item->cantidad = (int)$item->cantidad + Yii::$app->request->post('cantidad');
              $item->costo_unitario = Yii::$app->request->post('costo_unitario');
              if( $item->save() ){
                Util::calcularPedido( $pedido->id );
                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Registrado exitosamente',
                          'data'=>['items_cart'=>count( $pedido->items )]
                      ];
              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Ocurrio un error al registrar item',
                          'data'=>[ 'errors'=>$item->getErrors() ],
                      ];
              }

            }else{
              
              $model->pedido_id = $pedido->id;

              if( $model->save() ){

                Util::calcularPedido( $pedido->id );

                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Registrado exitosamente',
                          'data'=>['items_cart'=>count( $pedido->items )]
                      ];

              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Ocurrio un error al registrar item',
                          'data'=>[ 'errors'=>$model->getErrors() ],
                      ];
              }

            }

          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Usuario no encontrado',
                  ];
          }

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'El parámetro token es necesario',
                ];
        }
        
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Parámetros recibidos incorrectos',
              ];
      }
    }

    public function actionDeleteitemcart( $item_id = null ){
      $item = Items::findOne( $item_id );
      if( is_object( $item ) ){
        $pedido_id = $item->pedido_id;
        if ( \app\models\Util::borrarRegistrosRecursivos( $item ) ){
          Util::calcularPedido( $pedido_id )
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Item eliminado correctamente',
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Ocurrio un error, vuelva a intentarlo',
                ];
        }
      }
    }

    public function actionGetshoppingcart( $token = null ){
      $usuario = Usuarios::find()->andWhere( [ 'token'=>$token ] )->one();
      if( is_object( $usuario ) ){
        $items = [];
        $pedido = Pedidos::find()->andWhere( ['cliente_id'=>$usuario->id, 'estado'=>0] )->one();
        if( is_object( $pedido ) ){
          foreach ($pedido->items as $item) {
            
            $items [] = [ 'id'=>$item->id,
                          'descripcion'=>( $item->es_diagnostico == 1 ) ? $item->servicio->nombre.' - '.Yii::$app->params['parametros_globales']['texto_visita_diagnostico'] : $item->servicio->nombre, 
                          'cantidad'=>$item->cantidad, 
                          'costo_unitario'=>$item->costo_unitario, 
                          'costo_total'=>$item->costo_total
                        ];
          }

          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Carrito de compras',
                    'data'=>[ 'pedido'=>$pedido->attributes, 'items'=>$items, 'total'=>count( $pedido->items ) ],
                ];

        }else{
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Carrito de compras',
                    'data'=>[ 'total'=> 0 ],
                ];
        }

      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Usuario no encontrado'
              ];
      }
    }

}