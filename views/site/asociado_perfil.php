<script>
    document.getElementById("asoc-dash").classList.remove("active");
    document.getElementById("asoc-prof").classList.add("active");
</script>
<h4>Perfil</h4>
<div class="row">
    <div class="col-md-2">
        <img class="img-profile" src="<?= Yii::$app->user->identity->imagen ?>">
    </div>
    <div class="col-md-10">
        <h5><b>Estado</b></h5>
        <p><img class="asoc-estado" src="/images/<?php echo (Yii::$app->user->identity->estado == 1 ? "on": "off"); ?>.png"> <?=  Yii::$app->params['parametros_globales']['estados'][Yii::$app->user->identity->estado] ?></p>
        <hr>
        <h5><b>Nombre</b></h5>
        <p><?= Yii::$app->user->identity->nombres ?> <?= Yii::$app->user->identity->apellidos ?> </p>
        <h5><b>Email</b></h5>
        <p><?= Yii::$app->user->identity->email ?></p>
        <h5><b>Identificacion</b></h5>
        <p><?= Yii::$app->user->identity->identificacion ?> </p>
        <h5><b>Número celular</b></h5>
        <p><?= Yii::$app->user->identity->numero_celular ?></p>
    </div>
</div>