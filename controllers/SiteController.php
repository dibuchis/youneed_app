<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\Dispositivos;
use app\models\DispositivosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Atenciones;
use app\models\Usuarios;
use app\models\UsuariosSearch;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $dataProviderDispositivos = '';
    public $searchModelDispositivos = '';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'getdatamarker', 'geodireccion', 'getdispositivosusuario', 'soporteatencion', 'asociadoperfil', 'asociadodashboard', 'asociadonotificaciones', 'weblogin'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'weblogin' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {            
        if ($action->id == 'geodireccion') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionGetdispositivosusuario(){
        $arrayDispositivos = array();
        // if( Yii::app()->user->getState('rol_id')==1 ){ //Super admin ve todos las flotas
        //  $flotas = null;
        // }elseif( Yii::app()->user->getState('rol_estaciones') == 1 ){ //Flotas dependen de estaciones
        //  $flotas = Util::getflotasOperador(Yii::app()->user->getState('usuario_id'));
         
        // }else{ //Flotas dependen de usuarios_flotas
        //  $flotas = Util::getflotasDespachador(Yii::app()->user->getState('usuario_id'));
        // }

        // if( Yii::app()->user->getState('rol_id')==9 ){ // Rol adminsitrador de granja
        //   $flotas = Util::getflotasAdminGranjas(Yii::app()->user->getState('usuario_id'));
        // }
        // $criteria = new CDbCriteria;
        // if( !is_null( $flotas ) ){
        //     $criteria->addInCondition('flota_id', $flotas);
        //     $dispositivos = Dispositivos::model()->findAll($criteria);
        // }else{
            $dispositivos = Usuarios::find()->andWhere(['es_asociado'=>1])->all();
        // }
        foreach ($dispositivos as $dispositivo) {
            $arrayDispositivos [] = array( 'id'=> $dispositivo->traccar_id, 'tipo'=>'' );
        }
        return json_encode($arrayDispositivos);
        
    }

    public function actionSoporteatencion( $id ){
        $request = Yii::$app->request;
        $atencion = Atenciones::findOne($id);
        $model = Usuarios::findOne( $atencion->paciente_id );
        $model->scenario = 'asignacion_doctor';
        if ( $model->load($request->post()) ) {

            $url = Yii::$app->params['api_utim'].'assigndoctor';
            // $url = 'http://localhost/geomonitoreo/web/api/pruebapost';

            $post_data['utim_atencion_id'] = $atencion->id;
            $post_data['doctor_id'] = $model->doctor_id;
            $post_data['latitude_inicial_doctor'] = $model->latitude_inicial_doctor;
            $post_data['longitude_inicial_doctor'] = $model->longitude_inicial_doctor;
            $post_data['tiempo_atencion'] = $model->tiempo_atencion;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            $response = curl_exec($ch);
            $response = json_decode( $response );

            if( $response->status == 1 ){
                return $this->redirect(['index']);
            }else{
                $doctor = Usuarios::findOne( $model->doctor_id );
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 15000,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => 'Se ha asignado al Dr(a). '.$doctor->nombres.' '.$model->apellidos.' a otra atención, por favor asigne otro doctor',
                    'title' => 'Geomonitoreo',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
            } 
        }

        return $this->render( 'soporte_atencion', [ 'model'=>$model, 'atencion'=>$atencion ] );
    }

    public function actionGetdatamarker($traccar_id){
        $html = '';

        
            $usuario = Usuarios::find()->andWhere([ 'traccar_id'=>$traccar_id ])->one();
            if( is_object( $usuario ) ){
                        $html.= '<h2>Información del Asociado</h2>';
                        $html.= '<table id="" class="detail-view table table-striped table-condensed">
                                <tbody>
                                    <tr>
                                        <th>Identificación</th>
                                        <td>'.$usuario->identificacion.'</td>
                                    </tr>
                                    <tr>
                                        <th>Nombres</th>
                                        <td>'.$usuario->nombres.'</td>
                                    </tr>
                                    <tr>
                                        <th>Apellidos</th>
                                        <td>'.$usuario->apellidos.'</td>
                                    </tr>
                                    <tr>
                                        <th>Número de celular</th>
                                        <td>'.$usuario->numero_celular.'</td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td>'.$usuario->email.'</td>
                                    </tr>
                                </tbody>
                            </table>';
            }else{
                $html.= 'Información no disponible';
            }
        
        return $html;
    }

    public function actionGeodireccion(){
        $lat = trim($_POST['lat']);
        $lng = trim($_POST['lng']);
        $gmaps = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key='.Yii::$app->params['google_key'];
        // $gmapsArray = file_get_contents($gmaps);

        $arrContextOptions=array(
        "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $gmapsJson = file_get_contents($gmaps, false, stream_context_create($arrContextOptions));

        $gmapsArray = json_decode($gmapsJson);
        if( isset( $gmapsArray->results[0]->formatted_address ) ){
            return $gmapsArray->results[0]->formatted_address;
        }else{
            return 'No disponible';
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if( Yii::$app->user->identity->es_asociado == 1 ){
            $this->layout = 'dashboard_asociado';
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => 'Por ahora no tiene notificaciones',
                'title' => 'Notificaciones',
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
            return $this->render('asociado_dashboard',[

            ]);
        }
        if( Yii::$app->user->identity->es_super == 1 ){
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => 'Espere unos segundos mientras se cargan los dispositivos ...',
                'title' => 'Geomonitoreo',
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
            $this->searchModelDispositivos = new UsuariosSearch();
            $this->dataProviderDispositivos = $this->searchModelDispositivos->searchAsociados(Yii::$app->request->queryParams);

            return $this->render('index', [
                
            ]);
        }

    }

        /**
     * Displays perfil Asociado.
     *
     * @return string
     */
    public function actionAsociadoperfil()
    {
        if( Yii::$app->user->identity->es_asociado == 1 ){
            $this->layout = 'dashboard_asociado';
            return $this->render('asociado_perfil',[

            ]);
        }
    }

    /**
     * Displays perfil Asociado.
     *
     * @return string
     */
    public function actionAsociadonotificaciones()
    {
        if( Yii::$app->user->identity->es_asociado == 1 ){
            $this->layout = 'dashboard_asociado';
            return $this->render('asociado_notificaciones',[

            ]);
        }
    }

            /**
     * Displays dashboard Asociado.
     *
     * @return string
     */
    public function actionAsociadodashboard()
    {
        if( Yii::$app->user->identity->es_asociado == 1 ){
            $this->layout = 'dashboard_asociado';
            return $this->render('asociado_dashboard',[

            ]);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

        /**
     * Login action.
     *
     * @return string
     */
    public function actionWeblogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['login'=>true];
            exit();
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['login'=>false];
            exit();
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Atenciones model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = Atenciones::findOne($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Atenciones #".$id,
                    'content'=>$this->renderAjax('../atenciones/update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Atenciones #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['../atenciones/update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Atenciones #".$id,
                    'content'=>$this->renderAjax('../atenciones/update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('../atenciones/update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
