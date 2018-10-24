<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container">
	<p>&nbsp;</p>
	<div class="alert alert-success">
	  <strong>Registro exitoso!</strong> Gracias por su información, nos pondremos en contacto con usted en los próximos días.
	</div>
	<center>
		<?php echo Html::img( Url::to('@web/images/registro.jpg'), ['class'=>'img-responsive'] ); ?>
	</center>
</div>