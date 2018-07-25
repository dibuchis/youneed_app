<?php 
namespace app\controllers;
 
use Yii;
// use app\models\Pedidos;
use app\models\Geo;
use app\models\Util;
use app\models\Usuarios;
use app\models\Alianzas;
use app\models\Atenciones;
use app\models\Trazabilidades;
use app\models\VistaDoctoresDisponibles;
use app\models\Calificaciones;
use app\models\Dispositivos;
use app\models\Ciudades;
use app\models\Traccar;
use app\models\Visitas;
use app\models\ListadosEnfermedades;
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
            'login'=>['get'],
            'register'=>['post'],
            'getalliances'=>['get'],
            'requestattention'=>['get'],
            'checkattention'=>['get'],
            'assigndoctor'=>['post'],
            'scoreattention'=>['post'],
            'familylist'=>['get'],
            'assignfamilycode'=>['post'],
            'userinformation'=>['get'],
            'savepatientinformation'=>['post'],
            'getcities'=>['get'],
            'updatetokenpush'=>['post'],
            'assignposition'=>['get'],
            'doctorsavailable'=>['get'],
            'getdevicesaround'=>['get'],
            'finishattention'=>['post'],
            'attentionlist'=>['get'],
            'userposition'=>['get'],
            'getcie10'=>['get'],
            'updateuserimage'=>['post'],
            'getpendingattention'=>['get'],
            'setattentionstatus'=>['post'],
            'attentiondescription'=>['get'],
            'setvisit'=>['post'],
            'generateattention'=>['post'],
            'validatephonenumber'=>['get'],
            'cancelattention'=>['post'],
            'chargeattention'=>['get'],
            'placetopayresponse'=>['post'],
            'efectivoresponse'=>['post'],
            'selectpaymentmethod'=>['get'],
            'checkpayment'=>['get'],
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

    public function actionLogin( $numero_celular = null ){
      if( is_null( $numero_celular ) ){
        $this->setHeader(200);
        return array('status'=>0, 'message'=>'El parámetro numero_celular es requerido');
      }else{
        $usuario = Usuarios::find()->andWhere( ['numero_celular'=>$numero_celular, 'estado_id'=>1] )->one();
        if( is_object( $usuario ) ){
          $token = Util::getGenerarPermalink( Yii::$app->getSecurity()->generatePasswordHash('UTIMAPPAbitmedia'.date('Y-m-d H:i:s') ) );
          $usuario->token = $token;
          
          if( $usuario->save() ){
            $utim_atencion_id = 0;
            $utim_atencion_estado = 0; 
            $utim_atencion_precio_atencion = 0; 
            $utim_atencion_metodo_pago = 0;

            $atencion = Atenciones::find()->andWhere( [ 'paciente_id' => $usuario->id ] )->andWhere(['in', 'estado', [0,1,2,6,8] ])->one();
            if( is_object( $atencion ) ){
              $utim_atencion_id = $atencion->id;
              $utim_atencion_estado = $atencion->estado;
              $utim_atencion_precio_atencion = $atencion->precio_atencion;
              $utim_atencion_metodo_pago = $atencion->metodo_pago;
            }

            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Usuario aceptado',
                      'data'=>[
                        'usuario'=>[
                          'tipo'=>$usuario->tipo,
                          'display_name'=>$usuario->nombres.' '.$usuario->apellidos,
                          'nombres'=>$usuario->nombres,
                          'apellidos'=>$usuario->apellidos,
                          'numero_celular'=>$numero_celular,
                          'imagen'=>$usuario->imagen,
                          'token'=>$token,
                          'traccar_id'=>( isset( $usuario->dispositivo ) ) ? $usuario->dispositivo->traccar_id : null,
                          'traccar_imei'=>( isset( $usuario->dispositivo ) ) ? $usuario->dispositivo->imei : null,
                          'codigo_familiar'=>$usuario->codigo_familiar,
                          'alianza_imagen'=>( isset( $usuario->alianza ) ) ? $usuario->alianza->imagen : null,
                          'traccar_user'=>Yii::$app->params['traccar']['usuario'],
                          'traccar_pass'=>Yii::$app->params['traccar']['clave'],
                          'traccar_server'=>Yii::$app->params['traccar']['transmision_url'],
                          'traccar_server_rest'=>Yii::$app->params['traccar']['rest_url'],
                          'utim_atencion_id'=>$utim_atencion_id,
                          'utim_atencion_estado'=>$utim_atencion_estado,
                          'utim_atencion_precio_atencion'=>$utim_atencion_precio_atencion,
                        ]
                      ]
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al ingresar',
                      'data'=>[ 'errores'=>$usuario->getErrors() ],
                  ];
          }

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Usuario no encontrado o desactivado'
                ];
        }
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

    public function actionGetalliances( $id = null ){
      if( is_null( $id ) ){
        $array = [];
        $alianzas = Alianzas::find()->all();
        foreach ($alianzas as $alianza) {
          $array[] = ['id'=>$alianza->id, 'nombre'=>$alianza->nombre];
        }
        $this->setHeader(200);
        return [  'status'=>1, 
                  'message'=>'Listado de todas las alianzas disponibles',
                  'data'=>[
                    'alianzas'=>$array,
                    'condiciones'=>Yii::$app->params['terminos_condiciones'],
                  ]
              ];
      }else{
        $alianza = Alianzas::findOne( $id );
        if( is_object( $alianza ) ){
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Información para la alianza',
                    'data'=>[
                      'alianzas'=>$alianza->attributes
                    ]
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontró una alianza con al parámetro id especificado',
                ];
        }
      }
    }

    public function actionRequestattention( $latitude = null, $longitude = null, $token = null ){
      if( is_null( $latitude ) || is_null( $longitude ) || is_null( $token ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros latitude, longitude y token son requeridos',
              ];
      }else{
        $usuario = Usuarios::find()->andWhere( ['token'=>$token] )->one();
        if( is_object( $usuario ) ){
          $atencion = new Atenciones();
          $atencion->paciente_id = $usuario->id;
          $atencion->latitude = $latitude;
          $atencion->longitude = $longitude;
          $atencion->fecha_creacion = date('Y-m-d H:i:s');
          if( $atencion->save() ){
            $trazabilidad = new Trazabilidades();
            $trazabilidad->atencion_id = $atencion->id;
            $trazabilidad->save();
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Atención generada exitosamente',
                      'utim_atencion_id'=>$atencion->id,
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se pudo solicitar la atención, vuelva a intentarlo',
                      'data'=>[ 'errores'=>$atencion->getErrors() ],
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontró el paciente con el parámetro token especificado',
                ];
        }
      }
    }

    public function actionCheckattention( $utim_atencion_id = null, $token = null ){
      if( is_null( $utim_atencion_id ) ){
        if( is_null( $token ) ){
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'El parámetro token es requerido',
                ];
        }else{
          $usuario = Usuarios::find()->andWhere( ['token'=>$token] )->one();
          if( is_object( $usuario ) ){
            $atencion = Atenciones::find()->andWhere(['doctor_id'=>$usuario->id])->andWhere(['in', 'estado', [1,2,8] ])->one();
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'El parámetro token es incorrecto',
                  ];
          }
        }
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
      }

      if( is_object( $atencion ) ){
        $data = [];
        $info_doctor = [];
        if( !is_null( $atencion->doctor_id ) ){
          $doctor = Usuarios::findOne( $atencion->doctor_id );
          $info_doctor ['nombres'] = $doctor->nombres;
          $info_doctor ['apellidos'] = $doctor->apellidos;
          $info_doctor ['numero_celular'] = $doctor->numero_celular;
          $info_doctor ['registro_medico'] = $doctor->registro_medico;
          $info_doctor ['email'] = $doctor->email;
          $info_doctor ['identificacion'] = $doctor->identificacion;
          $info_doctor ['imagen'] = $doctor->imagen;
          $info_doctor ['traccar_id'] = ( isset( $doctor->dispositivo ) ) ? $doctor->dispositivo->traccar_id : null;
          $data['doctor'] = $info_doctor;
        }

        $data['paciente']['nombres'] = $atencion->paciente->nombres;
        $data['paciente']['apellidos'] = $atencion->paciente->apellidos;
        $data['paciente']['numero_celular'] = $atencion->paciente->numero_celular;
        $data['paciente']['email'] = $atencion->paciente->email;
        $data['paciente']['identificacion'] = $atencion->paciente->identificacion;
        $data['paciente']['imagen'] = $atencion->paciente->imagen;
        $data['paciente']['traccar_id'] = ( isset( $atencion->paciente->dispositivo ) ) ? $atencion->paciente->dispositivo->traccar_id : null;
        $data['paciente']['sintomas'] = $atencion->sintomas;
        $data['paciente']['clave'] = $atencion->clave;
        $data['paciente']['precio_atencion'] = $atencion->precio_atencion;
        $data['paciente']['metodo_pago'] = $atencion->metodo_pago;

        $this->setHeader(200);
        return [  'status'=>1, 
                  'utim_atencion_id'=>$atencion->id,
                  'message'=>'Información para la atención',
                  'status_attention'=>$atencion->estado,
                  'trace_information'=>$atencion->trazabilidades,
                  'atencion_id' => null,
                  'turno_id' => null,
                  'latitude_paciente' => $atencion->latitude,
                  'longitude_paciente' => $atencion->longitude,
                  'latitude_inicial_doctor' => $atencion->latitude_inicial_doctor,
                  'longitude_inicial_doctor' => $atencion->longitude_inicial_doctor,
                  // 'latitude_inicial_doctor' => -0.20374783252960926,
                  // 'longitude_inicial_doctor' => -78.49097655561604,
                  'last_latitude_doctor' => $atencion->last_latitude_doctor,
                  'last_longitude_doctor' => $atencion->last_longitude_doctor,
                  'metros_redonda_visita' => Yii::$app->params['metros_redonda_visita'],
                  'tiempo_atencion' => $atencion->tiempo_atencion,
                  'tipo_atencion' => $atencion->tipo_atencion,
                  'data'=>$data,
              ];
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'No se encontró una atención con al parámetro utim_atencion_id, token especificado',
              ];
      }

    }

    public function actionAssigndoctor(){
      if( !isset( $_POST['utim_atencion_id'] ) || !isset( $_POST['doctor_id'] ) || !isset( $_POST['latitude_inicial_doctor'] ) || !isset( $_POST['longitude_inicial_doctor'] ) || !isset( $_POST['tiempo_atencion'] ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros utim_atencion_id, doctor_id, latitude_inicial_doctor, longitude_inicial_doctor y tiempo_atencion son requeridos',
              ];
      }else{
        if( is_null( $_POST['utim_atencion_id'] ) || is_null( $_POST['doctor_id'] ) || is_null( $_POST['latitude_inicial_doctor'] ) || is_null( $_POST['longitude_inicial_doctor'] ) || is_null( $_POST['tiempo_atencion'] ) ){
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Los parámetros utim_atencion_id, doctor_id, latitude_inicial_doctor, longitude_inicial_doctor y tiempo_atencion son requeridos',
                ];
        }else{
          $atencion = Atenciones::findOne( $_POST['utim_atencion_id'] );
          if( is_object( $atencion ) ){
            $validar = Atenciones::find()->andWhere(['doctor_id'=>$_POST['doctor_id']])->andWhere(['in', 'estado', [1,2] ])->one();
            if( is_object( $validar ) ){
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'Doctor fue asignado a otra atención',
                    ];
            }else{
              $atencion->doctor_id = $_POST['doctor_id'];
              $atencion->estado = 1;
              $atencion->tiempo_atencion = $_POST['tiempo_atencion'];
              $atencion->latitude_inicial_doctor = $_POST['latitude_inicial_doctor'];
              $atencion->longitude_inicial_doctor = $_POST['longitude_inicial_doctor'];
              if( $atencion->save() ){
                $atencion->refresh();

                $push_paciente = Util::Sendpush( $atencion->paciente->token_push, Yii::$app->params['mensajes_push']['atencion_doctor_asignado'] );
                $push_doctor = Util::Sendpush( $atencion->doctor->token_push, Yii::$app->params['mensajes_push']['doctor_atencion_asignada'] );

                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Doctor asignado exitosamente',
                          'utim_atencion_id'=>$atencion->id,
                      ];
              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'No se pudo solicitar la atención, vuelva a intentarlo',
                          'data'=>[ 'errores'=>$atencion->getErrors() ],
                      ];
              }
            }
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se encontró una atención con al parámetro utim_atencion_id especificado',
                  ];
          }
        }
      }
    }

    public function actionScoreattention(){
      if( !isset( $_POST['utim_atencion_id'] ) || !isset( $_POST['calificacion'] ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros utim_atencion_id, y calificacion son requeridos',
              ];
      }else{
        if( is_null( $_POST['utim_atencion_id'] ) || is_null( $_POST['calificacion'] ) ){
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Los parámetros utim_atencion_id, y calificacion son requeridos',
                ];
        }else{
          $calificacion = new Calificaciones;
          $calificacion->calificacion = $_POST['calificacion'];
          $calificacion->atencion_id = $_POST['utim_atencion_id'];
          $calificacion->observacion = ( isset( $_POST['observacion'] ) ) ? $_POST['observacion'] : null;
          $calificacion->fecha_calificacion = date('Y-m-d H:i:s');
          if( $calificacion->save() ){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Gracias, calificación registrada exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se pudo registrar su calificación, vuelva a intentarlo',
                      'data'=>[ 'errores'=>$calificacion->getErrors() ],
                  ];
          }
        }
      }
    }

    public function actionFamilylist( $token = null ){
      if( is_null( $token ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro token es requerido',
              ];
      }else{
        $usuario = Usuarios::find()->andWhere( ['token'=>$token] )->one();
        if( is_object( $usuario ) ){
          $familiares = [];
          $usuarios = Usuarios::find()->andWhere( ['usuario_id'=>$usuario->id] )->all();
          foreach ($usuarios as $familiar) {
            $familiares [] = [  'imagen'=>$familiar->imagen, 
                                'nombres'=>$familiar->nombres, 
                                'apellidos'=>$familiar->apellidos, 
                                'traccar_id'=>( isset( $familiar->dispositivo ) ) ? $familiar->dispositivo->traccar_id : null,
                                'numero_celular'=>$familiar->numero_celular,
                              ];
          }
          
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Listado de familiares',
                    'data'=>[
                      'familiares'=>$familiares,
                    ]
                ];

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontro ningún usuario registrado con el token proporcionado',
                ];
        }
      }
    }

    public function actionAssignfamilycode(){
      if( !isset( $_POST['codigo_familiar'] ) || !isset( $_POST['token'] ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro codigo_familiar y token es requerido',
              ];
      }else{
        if( is_null( $_POST['codigo_familiar'] ) || is_null( $_POST['token'] ) ){
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'El parámetro codigo_familiar y token es requerido',
                ];
        }else{
          $usuario_refiere = Usuarios::find()->andWhere( ['token'=>$_POST['token']] )->one();
          $usuario_familiar = Usuarios::find()->andWhere( ['codigo_familiar'=>$_POST['codigo_familiar']] )->one();
          if( is_object( $usuario_refiere ) && is_object( $usuario_familiar ) ){
            
            if( $usuario_familiar->codigo_familiar == $usuario_refiere->codigo_familiar ){
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'No puede agregarse a si mismo',
                    ];
            }else{
              $usuario_familiar->usuario_id = $usuario_refiere->id;
              if( $usuario_familiar->save() ){
                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Asignación exitosa',
                      ];
              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'No se pudo realizar la asignación',
                          'data'=>[ 'errores'=>$usuario_familiar->getErrors() ],
                      ];
              }
            }

          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Código familiar no válido',
                  ];
          }
        }
      }
    }

    public function actionUserinformation( $token = null ){
      if( is_null( $token ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro token es requerido',
              ];
      }else{
        $usuario = Usuarios::find()->andWhere( ['token'=>$token] )->one();
        if( is_object( $usuario ) ){
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Información de usuario',
                    'data'=>[
                      'usuario'=>[
                        'tipo' => $usuario->tipo,
                        'alianza_id' => $usuario->alianza_id,
                        'alianza_nombre' => ( isset( $usuario->alianza->nombre ) ) ? $usuario->alianza->nombre : null,
                        'ciudad_id' => $usuario->ciudad_id,
                        'ciudad_nombre' => ( isset( $usuario->ciudad->nombre ) ) ? $usuario->ciudad->nombre : null,
                        'registro_medico' => $usuario->registro_medico,
                        'identificacion' => $usuario->identificacion,
                        'nombres' => $usuario->nombres,
                        'apellidos' => $usuario->apellidos,
                        'numero_celular' => $usuario->numero_celular,
                        'fecha_nacimiento' => $usuario->fecha_nacimiento,
                        'email' => $usuario->email,
                        'habilitar_rastreo' => $usuario->habilitar_rastreo,
                      ],
                    ]
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Usuario no encontrado',
                ];
        }
      }
    }

    public function actionSavepatientinformation(){

      if( isset( $_POST['token'] ) ){
        $model = Usuarios::find()->andWhere( [ 'token'=>$_POST['token'] ] )->one();
        if( is_object( $model ) ){
          $request = Yii::$app->request;
          if( $model->tipo == 'Doctor' ){ //Doctor
            $model->scenario = 'doctor';
          }elseif( $model->tipo == 'Paciente' ){
            $model->scenario = 'paciente';
          }

          if($model->load($request->post(), '') && $model->save()){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Actualización exitosa',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al actualizar usuario',
                      'data'=>[ 'errores'=>$model->getErrors() ],
                  ];
          }

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontró un usuario con el token especificado',              
                  ];
        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Parámetro token requerido',              
                ];
      }

    }

    public function actionGetcities(){
      $array = [];
      $ciudades = Ciudades::find()->all();
      foreach ($ciudades as $ciudad) {
        $array[] = [ 'id'=>$ciudad->id, 'nombre'=>$ciudad->nombre ];
      }
      $this->setHeader(200);
      return [  'status'=>1, 
                'message'=>'Listado de ciudades',
                'data'=>[
                  'ciudades'=>$array
                ]
            ];
    }

    public function actionUpdatetokenpush(){
      if( isset( $_POST['token'] ) && isset( $_POST['token_push'] ) ){
        if( !is_null( $_POST['token'] ) && !is_null( $_POST['token_push'] ) ){
          $usuario = Usuarios::find()->andWhere( ['token'=>$_POST['token']] )->one();
          if( is_object( $usuario ) ){
            $usuario->token_push = $_POST['token_push'];
            if( $usuario->save() ){
              $this->setHeader(200);
              return [  'status'=>1, 
                        'message'=>'Token push asignado exitosamente',
                    ];
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'No se pudo asignar token push',
                        'data'=>[ 'errores'=>$usuario->getErrors() ],
                    ];
            }
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se encontró un usuario con el token especificado',
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Los parámetros token y token_push son requeridos',
                ];
        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros token y token_push son requeridos',
              ];
      }
    }

    public function actionAssignposition( $utim_atencion_id = null, $lat = null, $lon = null ){
      if( !is_null( $utim_atencion_id ) && !is_null( $lat ) && !is_null( $lon ) ){
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){
          $atencion->last_latitude_doctor = $lat;
          $atencion->last_longitude_doctor = $lon;

          if( $atencion->estado != 2 ){
            if( Geo::puntoEnCirculo($lat, $lon, $atencion->latitude, $atencion->longitude, Yii::$app->params['metros_redonda_visita']) == 1 ){
              $atencion->estado = 2;
              $trazabilidad = Trazabilidades::find()->andWhere( [ 'atencion_id'=>$utim_atencion_id ] )->one();
              if( is_object( $trazabilidad ) ){
                if( is_null( $trazabilidad->fecha_llegada_paciente ) ){
                  $push_paciente = Util::Sendpush( $atencion->paciente->token_push, Yii::$app->params['mensajes_push']['atencion_doctor_llega'] );
                  $trazabilidad->fecha_llegada_paciente = date('Y-m-d H:i:s');
                  $trazabilidad->save();
                }
              }
            }
          }

          if( $atencion->save() ){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Ubicación asignada exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se pudo actualizar la última ubicación del doctor',
                      'data'=>[ 'errores'=>$atencion->getErrors() ],
                  ];
          }
        }else{

        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros utim_atencion_id, lat y lon son requeridos',
              ];
      }
    }

    public function actionDoctorsavailable( $lat = null, $lon = null, $meters = null ){
      if( is_null( $lat ) && is_null( $lon ) && is_null( $meters ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros lat, lon y meters son requeridos',
              ];
      }else{
        $doctores = VistaDoctoresDisponibles::find()->all();
        $doctores_disponibles = [];
        foreach ($doctores as $doctor) {

          if( !is_null( $doctor->traccar_id ) ){
            $dispositivo = Traccar::getDevice( $doctor->traccar_id );
            if( isset( $dispositivo[0] ) ){
              $posicion_id = $dispositivo[0]['positionId'];
              $posicion = Traccar::getPosition( $posicion_id );
              if( isset( $posicion[0] ) ){
                $lat_doctor = $posicion[0]['latitude'];
                $lon_doctor = $posicion[0]['longitude'];

                // $lat_doctor = -0.20374783252960926;
                // $lon_doctor = -78.49097655561604;

                if( Geo::puntoEnCirculo($lat, $lon, $lat_doctor, $lon_doctor, $meters) == 1 ){
                    $doctores_disponibles [] = [  'id'=>$doctor->id, 
                                                  'nombres'=>$doctor->nombres, 
                                                  'apellidos'=>$doctor->apellidos, 
                                                  'registro_medico'=>$doctor->registro_medico, 
                                                  'numero_celular'=>$doctor->numero_celular, 
                                                  'lat'=>$lat_doctor,
                                                  'lon'=>$lon_doctor,
                                                ];
                }

              }
            }
          }
        }
        $this->setHeader(200);
        return [  'status'=>1, 
                  'message'=>'Listado de doctores disponibles',
                  'data'=>[
                    'doctores'=>$doctores_disponibles,
                  ]
              ];
      }
    }

    public function actionFinishattention(){

      if( !isset( $_POST['utim_atencion_id'] ) || is_null( $_POST['utim_atencion_id'] ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $request = Yii::$app->request;
        $model = Atenciones::findOne( $_POST['utim_atencion_id'] );
        $model->scenario = 'registro_formulario';
        
        if( is_object( $model ) ){
          if( $model->load($request->post(), '') ){

            if( $model->validate() ){
              if( $model->precio_atencion > 0 ){
                $model->estado = 8; //Atención esperando pago
              }else{
                $model->estado = 3; //Atención terminada
              }

              if( $model->tipo_atencion == 'Teleoperadora' ){
                $model->estado = 3; 
              }

              $model->fecha_llenado_formulario = date('Y-m-d H:i:s');

              $trazabilidad = Trazabilidades::find()->andWhere( [ 'atencion_id'=>$_POST['utim_atencion_id'] ] )->one();
              if( is_object( $trazabilidad ) ){
                if( is_null( $trazabilidad->fecha_salida_paciente ) ){
                  $trazabilidad->fecha_salida_paciente = date('Y-m-d H:i:s');
                  $trazabilidad->save();
                }
              }

              if( $model->save() ){

                $push_paciente = Util::Sendpush( $model->paciente->token_push, Yii::$app->params['mensajes_push']['atencion_realizar_pago'] );

                // $post_data['turno_id'] = $model->turno_id;
                // $post_data['atencion_id'] = $model->atencion_id;
                // $post_data['sintomas'] = $model->sintomas;
                // $post_data['diagnostico'] = $model->diagnostico;
                // $post_data['cie10'] = $model->cie10;
                // $post_data['descripcion_cie10'] = $model->descripcion_cie10;
                // $post_data['medicamentos'] = $model->medicamentos;
                // $post_data['observaciones'] = $model->observaciones;
                // $post_data['imagen'] = $model->imagen;
                // $post_data['doctor_identificacion'] = $model->doctor->identificacion;
                // $post_data['doctor_registro_medico'] = $model->doctor->registro_medico;
                // $post_data['doctor_nombres'] = $model->doctor->nombres;
                // $post_data['doctor_apellidos'] = $model->doctor->apellidos;
                // $post_data['doctor_numero_celular'] = $model->doctor->numero_celular;
                // $post_data['doctor_fecha_nacimiento'] = $model->doctor->fecha_nacimiento;
                // $post_data['doctor_email'] = $model->doctor->email;
                // $post_data['doctor_ciudad'] = ( !is_null( $model->doctor->ciudad_id ) ) ? $model->doctor->ciudad->nombre : null;


                // $url = Yii::$app->params['url_api_evolution'].'saveformattention';
                // $header = array( 'Content-Type: application/json' );
                // $curl = curl_init();
                // curl_setopt($curl, CURLOPT_URL, $url);
                // curl_setopt($curl, CURLOPT_POST, 1);
                // curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
                // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                // $response = curl_exec($curl);
                // curl_close($curl);
                // $response = json_decode( $response );

                // if( $response->status == 1 ){
                //   $model->sincronizacion_evolution = 1;
                // }else{
                //   $model->sincronizacion_evolution = 0;
                // }

                // $model->save();

                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Registro exitoso',
                      ];
              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Ocurrio un error al registrar el formulario',
                          'data'=>[ 'errores'=>$model->getErrors() ],
                      ];
              }
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'Ocurrio un error en validación del formulario',
                        'data'=>[ 'errores'=>$model->getErrors() ],
                    ];


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
                    'message'=>'No se encontró atención con el parámetro utim_atencion_id especificado',
                ];
        }

      }
    
    }

    public function actionAttentionlist( $token = null, $limit = null, $offset = null ){

      if( !is_null( $token ) ){
        $usuario = Usuarios::find()->andWhere( ['token'=>$token] )->one();
        if( is_object( $usuario ) ){

          $atenciones = Atenciones::find();
          $atenciones->andWhere( [ 'doctor_id' => $usuario->id, 'estado'=>3 ] );
          $atenciones->limit($limit);
          $atenciones->offset($offset);
          $atenciones->orderBy(['fecha_creacion' => SORT_DESC]);
          $atenciones = $atenciones->all();
                                      
          $array_atenciones = [];
          foreach ($atenciones as $atencion) {
            $array_atenciones[] = [  'utim_atencion_id'=>$atencion->id, 
                                      'fecha'=>$atencion->fecha_llenado_formulario, 
                                      'paciente_nombres'=>$atencion->paciente->nombres.' '.$atencion->paciente->apellidos, 
                                      'identificacion'=>$atencion->paciente->identificacion
                                    ];
          } 

          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Listado de atenciones',
                    'data'=>[
                      'atenciones'=>$array_atenciones,
                    ]
                ];

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Doctor no encontrado con token especificado',
                ];
        }

      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro token es requerido',
              ];
      }      
    }

    public function actionUserposition( $traccar_id = null, $desde = null, $hasta = null ){

      if( !is_null( $traccar_id ) ){
        $array_ruta = [];
        $ubicacion_encontrada = 0;
        $dispositivo = Traccar::getDevice( $traccar_id );
        if( isset( $dispositivo[0] ) ){
          $posicion_id = $dispositivo[0]['positionId'];
          $posicion = Traccar::getPosition( $posicion_id );
          if( isset( $posicion[0] ) ){
            $ubicacion_encontrada = 1;
            $latitude = $posicion[0]['latitude'];
            $longitude = $posicion[0]['longitude'];
            $bateria = $posicion[0]['attributes']['batteryLevel'];
            $ultima_actualizacion = date( 'Y-m-d H:i:s', strtotime( $dispositivo[0]['lastUpdate'] ) );

            if( !is_null( $desde ) && !is_null( $hasta ) ){
              $polis = Traccar::getRoute( $traccar_id, $desde, $hasta );

              foreach ($polis as $poli) {
                $array_ruta [] = array( $poli['latitude'], $poli['longitude'] );
              }

              // $array_ruta [] = [-12.044012922866312, -77.02470665341184];
              // $array_ruta [] = [-12.05449279282314, -77.03024273281858];
              // $array_ruta [] = [-12.055122327623378, -77.03039293652341]; 
              // $array_ruta [] = [-12.075917129727586, -77.02764635449216]; 
              // $array_ruta [] = [-12.07635776902266, -77.02792530422971];
              // $array_ruta [] = [-12.076819390363665, -77.02893381481931]; 
              // $array_ruta [] = [-12.088527520066453, -77.0241058385925];
              // $array_ruta [] = [-12.090814532191756, -77.02271108990476];

            }

          }

        }

        if( $ubicacion_encontrada == 1 ){
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Posición del dispositivo',
                    'data'=>[
                      'posicion'=>[
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'bateria' => $bateria,
                        'ultima_actualizacion' => $ultima_actualizacion, 
                        'ruta'=>$array_ruta,
                      ],
                    ]
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se pudo encontrar la ubicación del dispositivo',
                ];
        }
        
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro traccar_id es requerido',
              ];
      }

    }

    public function actionGetcie10( $text = null ){
      if( !is_null( $text ) ){

        $array_response = [];
        $enfermedades = ListadosEnfermedades::find();
        $enfermedades->andFilterWhere(['like', 'id', $text]);
        $enfermedades->orFilterWhere(['like', 'descripcion', $text]);
        $enfermedades->limit(10);
        $enfermedades = $enfermedades->all();

        foreach ($enfermedades as $enfermedad) {
          $array_response [] = [ 'codigo'=>$enfermedad->id, 'descripcion'=>$enfermedad->descripcion ];
        }

        $this->setHeader(200);
        return [  'status'=>1, 
                  'message'=>'Listado de enfermedades',
                  'data'=>[
                    'enfermedades'=>$array_response,
                  ]
              ];

      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Ingrese una enfermedad o código CIE10',
              ];
      }
    }

    public function actionUpdateuserimage(){
      if( !is_null( $_POST['token'] ) && !is_null( $_POST['imagen'] ) ){
        $usuario = Usuarios::find()->andWhere( [ 'token'=>$_POST['token'] ] )->one();
        if( is_object( $usuario ) ){
          $usuario->imagen = $_POST['imagen'];
          if( $usuario->save() ){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Imagen de perfil actualizada exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al guardar imagen',
                      'data'=>[ 'errores'=>$usuario->getErrors() ],
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontró usuario con el token especificado',
                ];
        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros token e imagen son requeridos',
              ];
      }
    }

    public function actionGetpendingattention(){
      $array_atenciones = [];
      $atenciones = Atenciones::find()->andWhere( ['estado'=>0] )->all(); //Atenciones nuevas
      foreach ($atenciones as $atencion) {
        $array_atenciones [] = [  'utim_atencion_id'=>$atencion->id, 
                                  'alianza'=>( is_object( $atencion->paciente->alianza ) ) ? $atencion->paciente->alianza->nombre : null,
                                  'identificacion'=>$atencion->paciente->identificacion, 
                                  'nombres'=>$atencion->paciente->nombres, 
                                  'apellidos'=>$atencion->paciente->apellidos,
                                  'numero_celular'=>$atencion->paciente->numero_celular,
                                  'fecha_nacimiento'=>$atencion->paciente->fecha_nacimiento, 
                                  'email'=>$atencion->paciente->email,
                                  'ciudad'=>( is_object( $atencion->paciente->ciudad ) ) ? $atencion->paciente->ciudad->nombre : null,
                                  'latitude'=>$atencion->latitude,
                                  'longitude'=>$atencion->longitude
                                ];
      }
      return $array_atenciones;
    }

    public function actionSetattentionstatus(){
      if( isset( $_POST['utim_atencion_id'] ) && isset( $_POST['turno_id'] ) && isset( $_POST['atencion_id'] ) && isset( $_POST['sintomas'] ) && isset( $_POST['clave'] ) && isset( $_POST['estado'] ) ){
        if( is_null( $_POST['utim_atencion_id'] ) && is_null( $_POST['turno_id'] ) && is_null( $_POST['atencion_id'] ) && is_null( $_POST['sintomas'] ) && is_null( $_POST['clave'] ) && is_null( $_POST['estado'] ) ){
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Los parámetros utim_atencion_id, turno_id, atencion_id, sintomas, clave y estado son requeridos',
                ];
        }else{
          $atencion = Atenciones::findOne( $_POST['utim_atencion_id'] );
          if( is_object( $atencion ) ){

            if( $_POST['estado'] == 4 || $_POST['estado'] == 5 || $_POST['estado'] == 6 ){
              $atencion->turno_id = $_POST['turno_id'];
              $atencion->atencion_id = $_POST['atencion_id'];
              $atencion->sintomas = $_POST['sintomas'];
              $atencion->clave = $_POST['clave'];
              $atencion->estado = $_POST['estado'];
              $atencion->precio_atencion = ( isset( $_POST['precio_atencion'] ) ) ? $_POST['precio_atencion'] : 0;
              
              if( $atencion->save() ){
                $this->setHeader(200);
                return [  'status'=>1, 
                          'message'=>'Atención actualizada exitosamente',
                          'data'=>( $atencion->estado == 6 ) ? [ 'url_atencion'=> Url::to(['integracion-evolution/t?token='.time().'&utim_atencion_id='.$_POST['utim_atencion_id']], true) ] : null,
                      ];
              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Ocurrio un error al actualizar atención',
                          'data'=>[ 'errores'=>$atencion->getErrors() ],
                      ];
              }
            }else{
              $this->setHeader(200);
              return [  'status'=>0, 
                        'message'=>'El parámetro estado acepta los valores enteros: 4, 5 y 6'
                    ];
            }

          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'No se encontró una atención con el parámetro utim_atencion_id especificado',
                  ];
          }
        }
      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros utim_atencion_id, turno_id, atencion_id, sintomas, clave y estado son requeridos',
              ];
      }
    }

    public function actionAttentiondescription( $utim_atencion_id = null ){
      if( is_null( $utim_atencion_id ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){

          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Información de la atención',
                    'data'=>[
                      'atencion'=> [
                                    'imagen'=>$atencion->imagen,
                                    'sintomas'=>$atencion->sintomas,
                                    'diagnostico'=>$atencion->diagnostico,
                                    'cie10'=>$atencion->cie10,
                                    'descripcion_cie10'=>$atencion->descripcion_cie10,
                                    'medicamentos'=>$atencion->medicamentos,
                                    'observaciones'=>$atencion->observaciones
                                  ]

                    ]
                ];
          

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se encontró una atención con parámetro utim_atencion_id especificado',
                ];
        }
      }
    }
 
    public function actionGetdevicesaround( $latitude=null, $longitude=null, $type=null )
    {
      // Type = Tipos: Ambulancias ->Roja / Naranja, Autos, doctores y motos verdes. (Estandar)
      $arrayOrden = array();
      if( !is_null( $latitude ) && !is_null( $longitude ) && !is_null( $type )  ){

        $url = Yii::$app->params['traccar']['rest_url'].'positions/';
        $header = array( 'Content-Type: application/json' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        $dispositivos_id = array();
        $positions = array();
        foreach ($array as $pos) {
            if( Geo::puntoEnCirculo($latitude, $longitude, $pos['latitude'], $pos['longitude'], Yii::$app->params['metros_redonda']) == 1 ){
                $dispositivos_id [] = $pos['deviceId'];
                $positions[$pos['deviceId']] = array( 'lat'=>$pos['latitude'], 'lon'=>$pos['longitude'], 'address'=>$pos['address'], 'speed'=>$pos['speed'], 'date'=>$pos['fixTime'] );
            }
            
        }
        if( count( $dispositivos_id ) > 0 ){
          $tipo = null;
          if( $type == 'R' ){
            $tipo = 'Roja';
            $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id, 'tipo' => $tipo ] )->all();
          }elseif ( $type == 'N' ) {
            $tipo = 'Naranja'; //Se envian Naranjas y rojas
            $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id ] )->andWhere(['in', 'tipo', ['Roja','Naranja'] ])->all();
          }elseif ( $type == 'V' ) {
            // $tipo = 'Verde';
            $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id ] )->all();
          }else{
            $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id ] )->all();
          }
          
          // ENUM('Roja', 'Naranja', 'Verde')
          $array_dispositivos_json = array();
          // if( is_null( $tipo ) ){
          //   $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id ] )->all();  
          // }else{
          //   $dispositivos = Dispositivos::find()->where( ['traccar_id' => $dispositivos_id, 'tipo' => $tipo ] )->all();
          // }
          
          foreach ( $dispositivos as $dispositivo ) { 
            $array_dispositivos_json [] = array(  'id'=>$dispositivo->id, 
                                                  'name'=>$dispositivo->nombre, 
                                                  'alias'=>$dispositivo->nombre,
                                                  'license_plate'=>$dispositivo->placa,
                                                  'imei'=>$dispositivo->imei,
                                                  'latitude'=>$positions[$dispositivo->traccar_id]['lat'],
                                                  'longitude'=>$positions[$dispositivo->traccar_id]['lon'],
                                                  'address'=>$positions[$dispositivo->traccar_id]['address'],
                                                  'speed'=>$positions[$dispositivo->traccar_id]['speed'],
                                                  'type'=>$dispositivo->tipo,
                                                  'datetime'=>date('Y-m-d H:i', strtotime($positions[$dispositivo->traccar_id]['date'])),
                                                );
          }

          $this->setHeader(200);
          return array('status'=>1, 'radius'=>Yii::$app->params['metros_redonda'], 'data'=>$array_dispositivos_json);
        }else{
          $this->setHeader(200);
            return array('status'=>1,'message'=>'No se encontraron dispositivos cerca');
        }
      }else{
        $this->setHeader(400);
        return array('status'=>0,'error_code'=>400,'message'=>'Los parametros latitude, longitude y type son requeridos');
      }
    }



    public function actionSetvisit()
    {
      if( !is_null( $_POST['latitude'] ) && !is_null( $_POST['longitude'] ) && !is_null( $_POST['id'] )  ){
        $model = new Visitas();
        $model->dispositivo_id = $_POST['id'];
        $model->lat = $_POST['latitude'];
        $model->lng = $_POST['longitude'];
        $model->fecha_creacion = date('Y-m-d H:i:s');
        $model->fecha_inicio = date('Y-m-d H:i:s');
        if( $model->save() ){
          $this->setHeader(200);
          return array('status'=>1,'message'=>'Visita generada exitosamente');
        }else{
          $this->setHeader(400);
          return array('status'=>0,'error_code'=>400,'data'=>$model->getErrors());
        }
      }else{
        $this->setHeader(400);
        return array('status'=>0,'error_code'=>400,'message'=>'Los parametros latitude, longitude y id son requeridos');
      }
    }

    public function actionGenerateattention(){
      if( isset( $_POST['identificacion'] ) && isset( $_POST['turno_id'] ) && isset( $_POST['atencion_id'] ) && isset( $_POST['sintomas'] ) && isset( $_POST['clave'] ) && isset( $_POST['alianza'] ) && isset( $_POST['identificacion'] ) && isset( $_POST['nombres'] ) && isset( $_POST['apellidos'] ) && isset( $_POST['numero_celular'] ) && isset( $_POST['email'] ) && isset( $_POST['latitude'] ) && isset( $_POST['longitude'] ) ){
        $request = Yii::$app->request;
        $model = Usuarios::find()->andWhere( [ 'identificacion'=>$_POST['identificacion'] ] )->one();
        if( !is_object( $model ) ){
          $model = new Usuarios();
          $model->fecha_creacion = date('Y-m-d H:i:s');
          $model->tipo_usuario = 1;
          if( isset( $_POST['nombres'] ) && isset( $_POST['apellidos'] ) ){
            $model->codigo_familiar = strtoupper( substr($_POST['nombres'], 0, 3).substr($_POST['apellidos'], 0, 3) ).substr(time(), -4, 4);
          }
          
          $model->estado_id = 1;
          $model->scenario = 'paciente';
          $token = Util::getGenerarPermalink( Yii::$app->getSecurity()->generatePasswordHash('UTIMAPPAbitmedia'.date('Y-m-d H:i:s') ) );
          $model->token = $token;


          if( $model->load($request->post(), '') ){

              $alianza = Alianzas::find()->where( ['nombre' => $_POST['alianza'] ] )->one();

              if( isset( $_POST['ciudad'] ) ){
                $ciudad = Ciudades::find()->where( ['nombre' => $_POST['ciudad'] ] )->one();
                if( is_object( $ciudad ) ){
                  $model->ciudad_id = $ciudad->id;
                }else{
                  $ciudad = new Ciudades;
                  $ciudad->nombre = $_POST['ciudad'];
                  $ciudad->save();
                  $model->ciudad_id = $ciudad->id;
                }
              }

              if( !is_object( $alianza ) ){
                $alianza = new Alianzas;
                $alianza->nombre = $_POST['alianza'];
                $alianza->imagen = "-";
                $alianza->save();
              }
          
              $model->alianza_id = $alianza->id;
              $model->clave = '$2y$13$yI1Tn7Z0tCCNkDX69zhB9O.Fgn43LZsjIu.axJ8/jaZF6FgeNfDxO';
              $model->tipo = 'Paciente';


              if( $model->save() ){
                
                $dispositivo = new Dispositivos;
                $dispositivo->nombre = $model->identificacion;
                $dispositivo->placa = $model->codigo_familiar;
                $dispositivo->alias = $model->codigo_familiar;
                $dispositivo->imei = strtotime( date('Y-m-d H:i:s') );
                $dispositivo->imei = rand(pow(10, 4-1), pow(10, 4)-1).time();
                $dispositivo->tipo = 'Verde';
                $dispositivo->utim_app_tipo = 'Paciente';
                $dispositivo->tipo_dispositivo = 1;
                $dispositivo->save();
                $response = Traccar::setDevice( $dispositivo, 'POST' );
                $dispositivo->traccar_id = $response['id'];
                $dispositivo->save();

                $model->dispositivo_id = $dispositivo->id;
                $model->save();

              }else{
                $this->setHeader(200);
                return [  'status'=>0, 
                          'message'=>'Ocurrio un error al registrar paciente',
                          'data'=>[ 'errores'=>$model->getErrors() ],
                      ];
              }
            
            

          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Atributos POST incorrectos',
                      'data'=>[ 'errores'=>$model->getErrors() ],
                  ];
          }

          
        }

        if( is_null( $model->token ) ){
          $token = Util::getGenerarPermalink( Yii::$app->getSecurity()->generatePasswordHash('UTIMAPPAbitmedia'.date('Y-m-d H:i:s') ) );
          $model->token = $token;
          $model->save();
        }

        $atencion = new Atenciones();
        $atencion->paciente_id = $model->id;
        $atencion->latitude = $_POST['latitude'];
        $atencion->longitude = $_POST['longitude'];
        $atencion->fecha_creacion = date('Y-m-d H:i:s');
        $atencion->atencion_id = $_POST['atencion_id'];
        $atencion->turno_id = $_POST['turno_id'];
        $atencion->sintomas = $_POST['sintomas'];
        $atencion->clave = $_POST['clave'];
        $atencion->precio_atencion = ( isset( $_POST['precio_atencion'] ) ) ? $_POST['precio_atencion'] : 0;
        $atencion->tipo_atencion = 'Teleoperadora';

        if( $atencion->save() ){
          $trazabilidad = new Trazabilidades();
          $trazabilidad->atencion_id = $atencion->id;
          $trazabilidad->save();
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Atención generada exitosamente',
                    'utim_atencion_id'=>$atencion->id,
                    'data'=>[ 'url_atencion'=> Url::to(['integracion-evolution/t?token='.time().'&utim_atencion_id='.$atencion->id], true) ]
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'No se pudo solicitar la atención, vuelva a intentarlo',
                    'data'=>[ 'errores'=>$atencion->getErrors() ],
                ];
        }

      }else{
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'Los parámetros turno_id, atencion_id, sintomas, clave, alianza, identificacion, nombres, apellidos, numero_celular, email, latitude, longitude son requeridos',
              ];
      }
    }

    public function actionValidatephonenumber( $numero_celular = null ){
      if( is_null( $numero_celular ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro numero_celular es requerido',
              ];
      }else{
        $usuario = Usuarios::find()->andWhere( [ 'numero_celular'=>$numero_celular, 'estado_id'=>1 ] )->one();
        if( is_object( $usuario ) ){
          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Usuario existente',
                ];
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Usuario no encontrado o desactivado',
                ];
        }
      }
    }

    public function actionCancelattention( $utim_atencion_id = null ){
      if( is_null( $utim_atencion_id ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){
          $atencion->estado = 4;
          if( $atencion->save() ){
            $push_doctor = Util::Sendpush( $atencion->doctor->token_push, Yii::$app->params['mensajes_push']['paciente_cancela_atencion'] );
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Se canceló la atención exito',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al actualizar estado de atención',
                      'data'=>[ 'errores'=>$atencion->getErrors() ],
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Atención no encontrada',
                ];
        }
      }
    }

    public function actionChargeattention( $utim_atencion_id = null ){
      if( is_null( $utim_atencion_id ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){

          if( $atencion->estado == 3 ){
            
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'La atención ya fue pagada',
                  ];
          
          }else{

            $atencion->metodo_pago = 'Tarjeta';
            $atencion->save();

            $seed = date('c');
            if (function_exists('random_bytes')) {
                $nonce = bin2hex(random_bytes(16));
            } elseif (function_exists('openssl_random_pseudo_bytes')) {
                $nonce = bin2hex(openssl_random_pseudo_bytes(16));
            } else {
                $nonce = mt_rand();
            }

            $nonceBase64 = base64_encode($nonce);

            $tranKey = base64_encode(sha1($nonce . $seed . Yii::$app->params['placetopay']['secretKey'], true));

            $nonceBase64 = base64_encode($nonce);

            $reference = $atencion->id.'_'.time();

            $atencion->referencia_placetopay = $reference;

            $atencion->save();            

            $request = [
                          "auth" => [
                              "login" => Yii::$app->params['placetopay']['login'],
                              "seed" => $seed,
                              "nonce" => $nonceBase64,
                              "tranKey" => $tranKey
                          ],
                          "locale" => 'es_EC',
                          "payer"=>[
                            "document" => $atencion->paciente->identificacion, 
                            "documentType" => "CI", //CI cedula, RUC, PPN -> Pasaporte
                            "name" =>  $atencion->paciente->nombres,
                            "surname" => $atencion->paciente->apellidos,
                            "email" => ( !is_null( $atencion->paciente->email ) ) ? $atencion->paciente->email : time().'@utim.com.ec',
                            "mobile" => $atencion->paciente->numero_celular,
                            "address" =>  [
                              "street" => 'Ubicación: '.$atencion->latitude.' - '.$atencion->longitude, 
                              "city" =>  ( is_object($atencion->paciente->ciudad) ) ? $atencion->paciente->ciudad->nombre : 'Quito',
                              "country" => "EC"
                            ]
                          ],
                          "payment" => [
                              "reference" => $reference, //ID generado por el comercio
                              "description" => "Cobro desde UTIM APP",
                              "amount" => [
                                  "currency" => "USD",
                                  "total" => (float)$atencion->precio_atencion,
                                  "taxes" => [
                                          "kind"=> "iva",
                                          "amount"=> (float)$atencion->precio_atencion - ( (float)$atencion->precio_atencion / Yii::$app->params['placetopay']['iva'] ) ,
                                          "base"=> (float)$atencion->precio_atencion / Yii::$app->params['placetopay']['iva'],
                                  ],
                                  // "details" => [
                                  //     [
                                  //         "kind" => "subtotal",
                                  //         "amount" => 22.72

                                  //     ]
                                  // ]
                              ],
                              "allowPartial" => false,
                          ],
                          "expiration" => date('c', strtotime('+30 minutes')), // tiempo para pago antes de caducar sesión
                          "returnUrl" => Url::to([ 'api/placetopayresponse' ], true),
                          "ipAddress" => "173.230.130.8",
                          "userAgent" => 'IONIC',
                      ];
            

                  //SOLICITAMOS LA CREACION DE SESSION PARA EL PAGO PLACETOPAY
                  $curl = curl_init();

                  curl_setopt_array($curl, array(
                      CURLOPT_URL => Yii::$app->params['placetopay']['placetopay_url']."api/session/",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_HTTPHEADER => array(
                          "Cache-Control: no-cache",
                          "Content-Type: application/json",
                          "Postman-Token: 96983e26-ba1b-4dfa-bbe9-54f877428d08"
                      ),
                  ));

                  $data = json_encode($request);
                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  $response = curl_exec($curl);
                  $err = curl_error($curl);
                  curl_close($curl);
                  
                  $resArray = json_decode($response,true);
                  if($resArray['status']['status'] == 'OK'){
                      $this->setHeader(200);
                      return [  'status'=>1, 
                                'message'=>'Solicitud de pago exitosa',
                                'payment_url' => $resArray['processUrl'],
                            ];
                  }else{
                    $this->setHeader(200);
                    return [  'status'=>0, 
                              'message'=>'No se pudo generar solicitud de pago',
                              'data'=>[ 'errores'=>$resArray ],
                          ];
                  }
                  return $resArray;

          }

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Atención no encontrada',
                ];
        }
      }
    }

    public function actionPlacetopayresponse(){
      return $_POST;
      // $this->setHeader(200);
      // return [  'status'=>0, 
      //           'message'=>'Info desde Place to pay',
      //           'data'=>$_POST,
      //       ];
    }

    public function actionEfectivoresponse( $utim_atencion_id = null ){
      if( is_null( $utim_atencion_id ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){
          $atencion->metodo_pago = 'Efectivo';
          $atencion->estado = 3;
          $atencion->fecha_pago = date('Y-m-d H:i:s');
          if( $atencion->save() ){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Pago en efectivo registrado exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al asignar pago en efectivo',
                      'data'=>[ 'errores'=>$atencion->getErrors() ],
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Atención no encontrada',
                ];
        }
      }
    }

    public function actionSelectpaymentmethod( $utim_atencion_id = null, $metodo_pago = null ){ //1 efectivo, 2 tarjeta
      if( is_null( $utim_atencion_id ) && is_null( $metodo_pago ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id y metodo_pago es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){
          $atencion->metodo_pago = 'Efectivo';
          if( $atencion->save() ){
            $this->setHeader(200);
            return [  'status'=>1, 
                      'message'=>'Método de pago asignado exitosamente',
                  ];
          }else{
            $this->setHeader(200);
            return [  'status'=>0, 
                      'message'=>'Ocurrio un error al asignar método de pago',
                      'data'=>[ 'errores'=>$atencion->getErrors() ],
                  ];
          }
        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Atención no encontrada',
                ];
        }
      }
    }

    public function actionCheckpayment( $utim_atencion_id = null ){
      if( is_null( $utim_atencion_id ) ){
        $this->setHeader(200);
        return [  'status'=>0, 
                  'message'=>'El parámetro utim_atencion_id es requerido',
              ];
      }else{
        $atencion = Atenciones::findOne( $utim_atencion_id );
        if( is_object( $atencion ) ){

          $this->setHeader(200);
          return [  'status'=>1, 
                    'message'=>'Estado de pago',
                    'estado'=>$atencion->estado,
                ];

        }else{
          $this->setHeader(200);
          return [  'status'=>0, 
                    'message'=>'Atención no encontrada',
                ];
        }
      }
    }

    private function setHeader($status)
      {
 
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type="application/json; charset=utf-8";
 
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "Nintriva <nintriva.com>");
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