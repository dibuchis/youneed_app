<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
  // echo Yii::$app->getSecurity()->generatePasswordHash('admin');

  $numero = '0984640145';
  echo substr( $numero , 1);
?>
    <div class="row-fluid">
      <div class="col-md-4 col-md-offset-4">
          <div class="login-panel panel panel-default">
              <div class="panel-heading">
                  <div class="col-sm-offset-0">
                    <?= Html::img( Url::to('@web/images/logo-login.png'), ['class'=> 'login-logo center-block']);?>
                  </div>
                 <!--  <div class="col-md-offset-0"><h3><i>Iniciar Sesión<i></h3></div> -->
              </div>
              <div class="panel-body">
                  <?php $form = ActiveForm::begin([
                      'id' => 'login-form',
                      // 'layout' => 'horizontal',
                      'fieldConfig' => [
                          'template' => "{label}\n{input}\n{error}",
                          // 'labelOptions' => ['class' => 'col-lg-1 control-label'],
                      ],
                  ]); ?>
                          <?= $form->field($model, 'username', ['template' => '
                                 <div class="input-group col-sm-12 ">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    {input}
                                 </div>
                                 {error}{hint}
                             ']
                             )->textInput(['autofocus' => true, 'class'=>'form-control', 'placeholder'=>'Ingrese su e-mail']) ?>

                          <?= $form->field($model, 'password', ['template' => '
                                 <div class="input-group col-sm-12 ">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                                    {input}
                                 </div>
                                 {error}{hint}
                             ']
                             )->passwordInput(['placeholder'=>'Ingrese su contraseña']) ?>
                          <!-- <a href="#" class="pull-right label-forgot">Olvido su contraseña?</a>                     -->
                          <?= $form->field($model, 'rememberMe')->checkbox([
                              // 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                          ]) ?>
                      
                      <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
                  <?php ActiveForm::end(); ?>
                  <!-- <div class="registrarse">
                      <div class="col-sm-offset-0"><p>¿No tienes una cuenta?</p></div>
                      <div class="col-md-4 col-md-offset-4"><p class="register"><a href="#">Registrarse</a></p></div>
                  </div> -->
              </div>
          </div>
          <div class="footer">
              <div class="col-sm-offset-0">
                <center>
                  Desarrollado por:
                <a style="color: #FFF;" target="_blank" href="http://www.abitmedia.com">
                  <?= Html::img( Url::to('@web/images/logo_abitmedia.png'), ['class'=> 'center-block']);?>
                </a>
                </center>
              </div>
          </div>
      </div><!-- /.col-->
  </div><!-- /.row -->
