<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Conceptos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use \yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ReporteHistorico;
use app\models\Traccar;


/**
 * ConceptosController implements the CRUD actions for Conceptos model.
 */
class ReportesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['historico', 'generarpolilineas'],
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
                ],
            ],
        ];
    }

    /**
     * Lists all Conceptos models.
     * @return mixed
     */
    public function actionHistorico()
    {
        $arraypoli = array();
        if( isset( $_GET['ReporteHistorico'] ) ){
            $rango = explode(' - ', $_GET['ReporteHistorico']['rango_fechas']);

            $deviceid = $_GET['ReporteHistorico']['deviceid'];
            $fecha_desde = $rango[0];
            $fecha_hasta = $rango[1];

            $polis = Traccar::getRoute( $deviceid, $fecha_desde, $fecha_hasta );

            foreach ($polis as $poli) {
                $temp = 0;
                if( isset( $poli['attributes']['temp1'] ) ){
                    $temp = $poli['attributes']['temp1'];
                }
                $arraypoli[] = [ $poli['latitude'], $poli['longitude'], date('Y-m-d H:i:s', strtotime( $poli['fixTime'] )), $temp ];
            }
        }
        
        $this->layout = 'main_historico';
        return $this->render('historico', [
            'polilineas' => $arraypoli,
        ]);

    }

    public function actionGenerarpolilineas(){
        
        $arraypoli = array();

        
        echo \yii\helpers\Json::encode( $arraypoli );
        // return \yii\helpers\Json::encode($arraypoli);

    }
}