<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
?>
<div class="usuarios-update">

	<?php 
	if( $model->tipo == 'Doctor' || $model->tipo == 'Paciente' ){
		echo $this->render('_form_doctor', [
	        'model' => $model,
	    ]);
	}else{
		echo $this->render('_form', [
	        'model' => $model,
	    ]);
	} 
	?>



</div>
