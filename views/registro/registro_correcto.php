<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
body {
    background-color: #fff !important;
}
</style>
<div class="container" style="max-width:960px;">
	
<div style="background:#2e8a96; width:100%; height:80px; padding:8px;color:white;"> 
	<h3 style="font-family:Arial, Helvetica, sans-serif; color:#fff;">¡Bienvenido a YouNeed!</h3>	
<div style="padding:25px;"> 
	
	<center >
		<?php echo Html::img( Url::to('@web/images/registro_ok.jpg'), ['class'=>'img-responsive', 'style' => 'max-width:250px; margin:15px auto;'] ); ?>
	</center>
	
	<div style="margin:25px auto; max-width:650px;">
		<p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">Estimado Asociado, </p> <p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">Gracias por unirte a la mayor red de profesionales y clientes que están usando YouNeed para ofrecer sus servicios, nuestro compromiso es brindarte las mejores herramientas para que canalices tu talento hacia la comunidad y obtengas los beneficios que siempre quisiste.</p> 
	
	
		<p style="font-family:Arial, Helvetica, sans-serif; color:#9a999e;">Por favor, ingresa a tu perfil para ver los datos y documentos: </p> <p><a class="btn btn-primary" style="margin: 35px auto 10px; width: 180px; display: block;" href="https://app.youneed.com.ec">Perfil de Asociado</a> </p> </div> 

	</div>
<div style="font-family:Arial, Helvetica, sans-serif; height:40px; margin-top:25px;background:#9a999e; text-align:center; padding:7px; padding-top:15px; color:#fff;">YouNeed® Todos los derechos reservados.</div>

	<!-- <div class="alert alert-success">
	  <strong>Registro exitoso!</strong> Gracias por su información, nos pondremos en contacto con usted en los próximos días.
	</div> -->
</div>