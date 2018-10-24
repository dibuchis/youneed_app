<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container">
	<p>&nbsp;</p>
	<div class="alert alert-danger">
	  <strong>Error!</strong> No se pudo realizar el registro, vuelva a intentarlo.
	</div>
</div>
<center>
	<?php echo Html::img( Url::to('@web/images/error.jpg'), ['class'=>'img-responsive'] ); ?>
</center>
<pre>
	<?php print_r($model->getErrors()); ?>
</pre>