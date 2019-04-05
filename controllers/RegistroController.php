<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use app\models\UsuariosServicios;
use app\models\UsuariosCategorias;
use app\models\Configuraciones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class RegistroController extends Controller
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => ['index', 'view', 'create', 'update', 'delete', 'bulkdelete', 'clientes'],
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['post'],
    //                 'bulk-delete' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    public function actionConfirmemail(){
        if(isset($_GET)){
            $email = $_GET['email'];
            $token = $_GET['token'];

            // Code to confirm

        }
    }

    public function actionTestemail(){
        if(isset($_GET['admintest'])){
            try{
                $send = Yii::$app->mailer->compose()
                ->setFrom('notificaciones@youneed.com.ec')
                // ->setTo("zare2303@hotmail.com")
                ->setTo("dibuchis@gmail.com")
                // ->setCc("majo.bastidas@gmail.com")
                ->setSubject("YouNeed - Registro exitoso")
                ->setHtmlBody('<div style="background:#178b89; width:100%; height:80px; padding:8px;color:white;"><img src="https://app.youneed.com.ec/images/logo-admin.png" style="width:120px; height:auto;margin:12px 25px 12px 12px"></div><div style="padding:25px;"><h2>Nombre Usuario,</h2><h3 style="color:#178b89;">¡Bienvenido a YouNeed!</h3><p>Estimado Asociado, </p><br/><p>Gracias por unirte a la mayor red de profesionales y clientes que están usando YouNeed para ofrecer sus servicios, nuestro compromiso es brindarte las mejores herramientas para que canalices tu talento hacia la comunidad y obtengas los beneficios que siempre quisiste.</p><p>Por favor, para confirmar tu correo electrónico y poder mantenernos comunicados haz click en el siguiente link: </p><p></p><hr></div><div style="height:40px; margin-top:25px; background:#efefef; text-align:center; padding:7px; padding-top:15px;">YouNeed® Todos los derechos reservados.</div>', 'text/html')
                ->send();
                var_dump($send);
                // echo "<pre>";
                // print_r(get_class_methods($send));
                // echo "</pre>";
            }catch(Exception $e){
                var_dump($e);
            }
        }
    }


    public function actionAsociado()
    {

        // try{
        //     $send = Yii::$app->mailer->compose()
        //     ->setFrom('notificaciones@youneed.com.ec')
        //     ->setTo("zare2303@hotmail.com")
        //     ->setCc("majo.bastidas@gmail.com")
        //     ->setCc("dibuchis@gmail.com")
        //     ->setSubject("YouNeed - Registro exitoso")
        //     ->setHtmlBody('<div style="background:#178b89; width:100%; height:80px; padding:8px;color:white;"><img src="https://app.youneed.com.ec/images/logo-admin.png" style="width:120px; height:auto;margin:12px 25px 12px 12px"></div><div style="padding:25px;"><h2>Nombre Usuario,</h2><h3 style="color:#178b89;">¡Bienvenido a YouNeed!</h3><p>Estimado Asociado, </p><br/><p>Gracias por unirte a la mayor red de profesionales y clientes que están usando YouNeed para ofrecer sus servicios, nuestro compromiso es brindarte las mejores herramientas para que canalices tu talento hacia la comunidad y obtengas los beneficios que siempre quisiste.</p><p>Por favor, para confirmar tu correo electrónico y poder mantenernos comunicados haz click en el siguiente link: </p><p></p><hr></div><div style="height:40px; margin-top:25px; background:#efefef; text-align:center; padding:7px; padding-top:15px;">YouNeed® Todos los derechos reservados.</div>', 'text/html')
        //     ->send();
        //     var_dump($send);
        //     // echo "<pre>";
        //     // print_r(get_class_methods($send));
        //     // echo "</pre>";
        // }catch(Exception $e){
        // }


        $this->layout = 'main_registro';
        $request = Yii::$app->request;
        $model = new Usuarios();  
        $model->scenario = 'Asociado';
        $model->es_asociado = 1;
        $model->clave = "";
        //$model->clave = '$2y$13$uBUddTim0vpjWki.zHwcIeYEVEqE1Y6g1hwNueooLMlVqYAnnoy4W';

        $terminos = Configuraciones::findOne(1);

        if ($model->load(Yii::$app->request->post())) {
            
            $model->numero_celular = preg_replace('/\s+/', '', $model->numero_celular);
            $model->numero_celular = str_replace(' ', '', $model->numero_celular);

            // $model->validatePassword($model->clave);

            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }else{
                if( $model->save() ){

                    $listado_cateorias = explode(",", Yii::$app->request->post()['Usuarios']['categorias']);

                    if( is_array( $listado_cateorias ) ){
                        UsuariosCategorias::deleteAll('usuario_id = '.$model->id);
                        foreach ( $listado_cateorias as $pc ) {
                            $p = new UsuariosCategorias();
                            $p->categoria_id = $pc;
                            $p->usuario_id = $model->id;
                            $p->save();
                        }
                    }

                    $listado_servicios = explode(",", Yii::$app->request->post()['Usuarios']['servicios']);

                    if( is_array( $listado_servicios ) ){
                        UsuariosServicios::deleteAll('usuario_id = '.$model->id);
                        foreach ( $listado_servicios as $pc ) {
                            $p = new UsuariosServicios();
                            $p->servicio_id = $pc;
                            $p->usuario_id = $model->id;
                            $p->save();
                        }
                    }

                    
                    try{
                        $send = Yii::$app->mailer->compose()
                        ->setFrom('noreply@youneed.com.ec')
                        ->setTo($model->email)
                        ->setSubject("YouNeed - Registro exitoso")
                        ->setHtmlBody('<div style="background:#178b89; width:100%; height:80px; padding:8px;color:white;"><img src="https://app.youneed.com.ec/images/logo-admin.png" style="width:120px; height:auto;margin:12px 25px 12px 12px"></div><div style="padding:25px;"><h2>' . $model->nombres . ',</h2><h3  style="color:#178b89;">¡Bienvenido a YouNeed!</h3><br/><p>Estimado Asociado, </p><p>Gracias por unirte a la mayor red de profesionales y clientes que están usando YouNeed para ofrecer sus servicios, nuestro compromiso es brindarte las mejores herramientas para que canalices tu talento hacia la comunidad y obtengas los beneficios que siempre quisiste.</p><p>Por favor, para confirmar tu correo electrónico y poder mantenernos comunicados haz click en el siguiente link: </p><p></p><hr></div><div style="height:40px; margin-top:25px;background:#efefef; text-align:center; padding:7px; padding-top:15px;">YouNeed® Todos los derechos reservados.</div>', 'text/html')
                        ->send();
                        //echo "<script>console.log('" . $send . "');</script>";
                    }catch(Exception $e){
                        //echo "<script>console.log('Error de envío de Email');</script>";
                    }

                    return $this->render('registro_correcto', [
                        'model' => $model,
                    ]);
                }else{
                    return $this->render('registro_incorrecto', [
                        'model' => $model,
                    ]);
                }
                return $this->redirect(['index']);
            }
        }else{
            return $this->render('asociado', [
                'model' => $model,
                'terminos' => $terminos->politicas_condiciones,
            ]);
        }
       
    }

    /**
     * Updates an existing Usuarios model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->scenario = 'Webapp';
        $model->tipo = 'Superadmin';
        $modelOld = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Usuarios #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                if( $modelOld->clave != $model->clave ){
                    $model->clave = Yii::$app->getSecurity()->generatePasswordHash( $model->clave );
                    $model->save();
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Usuarios #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Usuarios #".$id,
                    'content'=>$this->renderAjax('update', [
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
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Usuarios model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Usuarios model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
