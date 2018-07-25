<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Atenciones;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * CodigosPromocionesController implements the CRUD actions for CodigosPromociones model.
 */
class IntegracionEvolutionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['t'],
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all CodigosPromociones models.
     * @return mixed
     */
    public function actionT( $token = null, $utim_atencion_id = null ){
        
        if( is_null( $token ) || is_null( $utim_atencion_id ) ){
            return 'Los parámetros token y utim_atencion_id son requeridos';
        }else{
            $atencion = Atenciones::findOne( $utim_atencion_id );
            if( is_object( $atencion ) ){
                $this->layout = 'main_iframe';
                
                $request = Yii::$app->request;
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
                        $mensaje = 'Asignación exitosa, puede cerrar la ventana';
                        return $this->render( 'asignacion', [ 'mensaje'=>$mensaje ] );
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

                return $this->render( 'index', [ 'model'=>$model, 'atencion'=>$atencion ] );

            }else{
                return 'No se encontró una atención con el parámetro utim_atencion_id especificado';
            }
        }

    }

}