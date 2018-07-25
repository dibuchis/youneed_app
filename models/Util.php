<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use app\models\PedidosOperaciones;
use app\models\Configuraciones;
use app\models\Traccar;
use app\models\Usuarios;
use app\models\Geo;
use app\models\Empresas;
use app\models\NotificacionesPushPedidos;
use app\models\UsuariosReferidos;
use app\models\IntervalosEnvios;
use app\models\Pedidos;
use app\models\TrazabilidadPush;
use app\models\MensajesPush;
use app\models\AlgoritmoProgramado;

class Util extends Model
{
    public static function getGenerarPermalink($string)
    {
       $spacer = '-';
       $string = mb_strtolower($string, "UTF-8");
       //non-alpha changed for space
       $string = preg_replace("/[\W]/u",' ', $string); 
       //trim first and last spaces
       $string = trim($string);
       //replace blank spaces for $spacer
       $string = str_replace(' ', $spacer, $string);
       //Countinuos $spacer deleting
       $string = preg_replace("/[ _]+/",$spacer, $string);
       $wrong = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ç', 'ü'); 
       $right = array('a', 'e' ,'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N', 'c', 'u');
       $string = str_replace($wrong, $right, $string);  
       if( ! strlen($string) > 0 ){
          $string = 'sin-titulo'.'-'.time();
       }
       return $string;
    }

    public static function getEnumToArray($model, $attribute){
      $tableSchema = $model->getTableSchema();
      $column = $tableSchema->columns[$attribute]; // the column that has enum values

      if (is_array($column->enumValues) && count($column->enumValues) > 0) {
          $dropDownOptions = [];
          foreach ($column->enumValues as $enumValue) {
              $dropDownOptions[$enumValue] = \yii\helpers\Inflector::humanize($enumValue);
          }
      }
      return $dropDownOptions;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public static function reemplazarComodines($plantilla, $variables_plantilla)
    {
        //Reemplazar comodines de la plantilla por valores de variables
        $contenidoplantilla = $plantilla;
        foreach($variables_plantilla as $clave => $valor):
            $contenidoplantilla = str_replace($clave, $valor, $contenidoplantilla);
        endforeach;
        return $contenidoplantilla;
    }

    public static function getDistanciaBusquedaMotorizados(){
      $config = Configuraciones::findOne( 1 );
      return $config->metrs_redonda_algoritmo;
    }

    public static function getDistanciaBusquedaCercania(){
      $config = Configuraciones::findOne( 1 );
      return $config->metros_cercania_filtro_busquedas;
    }

    public static function getDistanciaVisitas(){
      $config = Configuraciones::findOne( 1 );
      return $config->metros_redonda_visita;
    }

    public static function getEmailAdmin(){
      $config = Configuraciones::findOne( 1 );
      return $config->correo_administrador;
    }

    public static function calcularAlgoritmoConductores( $empresa_id, $pedido_id ){

      $repartidores = Traccar::getDevices();
      $repartidores_array = [];
      $traccar_ids = [];
      $url_query = '';

      $empresa = Empresas::findOne( $empresa_id );

      foreach ($repartidores as $repartidor) {
          if( $repartidor['status'] == 'online' ){
              
              $dispositivo = Usuarios::find()
                        ->andWhere([ 'traccar_id' => $repartidor['id'] ])
                        ->andWhere([ 'en_ruta' => 0 ])
                        ->andWhere(['estado' => 'Activo' ])
                        ->one();

              if( is_object( $dispositivo ) ){
                  $traccar_ids [ $repartidor['id'] ] = $dispositivo->attributes;
                  if( $repartidor['positionId'] > 0 ){
                      $url_query = $url_query.'id='.$repartidor['positionId'].'&';
                  }
              }
          }
      }

      if( !empty( $url_query ) ){
          $en_linea = Traccar::getPositionsDevicesAvailable( $url_query );
          foreach ($en_linea as $linea) {

              $punto = Geo::puntoEnCirculo( $empresa->latitud, $empresa->longitud, $linea['latitude'], $linea['longitude'], Util::getDistanciaBusquedaMotorizados() );
              if( $punto == 1 ){
                  // $repartidores_array [] = [  'traccar_id'=>$linea['deviceId'], 'lat'=>$linea['latitude'], 'lng'=>$linea['longitude'] ];
                  $repartidores_array[] = $traccar_ids[ $linea['deviceId'] ]['token_push'];
                  $repartidores_array_ids[] = $traccar_ids[ $linea['deviceId'] ]['id'];                
              }
          }
      }

      if( count($repartidores_array) > 0 ){
      
        foreach ( $repartidores_array_ids as $repartidor ) {
          $noti = new NotificacionesPushPedidos();
          $noti->usuario_id = $repartidor;
          $noti->pedido_id = $pedido_id;
          $noti->fecha = date('Y-m-d');
          $noti->save();
        }
        self::enviarNotificacionesPush( $repartidores_array, self::getMensajePush(1) );
      }

      // return $repartidores_array;



    }

    public static function Sendpush( $token_push_usuario = null, $mensaje = null ){
      $server_key = Yii::$app->params['token_firebase'];
      $mensaje = $mensaje;
      $url = 'https://fcm.googleapis.com/fcm/send';
            
      $fields = [];

      $fields['notification'] = [ 'title' => 'UTIM APP',
                    'body' => $mensaje,
                    'sound' => 'default',
                    // 'badge' => 1,
                    'color' => '#275596'
                  ];

      $fields['data'] = [
                    'message' => $mensaje,
                  ];

      $fields['priority'] = 'high';

      $fields['registration_ids'] = [$token_push_usuario];

      $headers = array(
        'Content-Type:application/json',
          'Authorization:key='.$server_key
      );
            
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
      }
      curl_close($ch);
      return $result;
    }

    public static function getProcesarCupones(){
      $config = Configuraciones::findOne( 1 );
      return $config->activar_codigos_referidos;
    }

    public static function getMontoJaimePuntos(){
      $config = Configuraciones::findOne( 1 );
      return $config->monto_jaime_puntos;
    }

    public static function getNumeroContacto(){
      $config = Configuraciones::findOne( 1 );
      return $config->numero_contacto;
    }

    public static function getMontoTotalConsumidoJaimePuntos(){
      return UsuariosReferidos::find()->sum('monto');
    }

    public static function getReporteTotalPersonasReferidas(){
      $total = UsuariosReferidos::find()->andWhere( ['not', ['referido_id' => null]] )->all();
      return count( $total );
    }

    public static function calcularCostoEnvio( $distancia ){
      // La base son 1,75 usd a 2km a la redonda del restaurante.
      // A partir de esa base cada kilometro extra a la redonda del restaurante le suma 0,25 centavos a la tarifa base.

      if( (int)$distancia <= 2000 ){ // menor a 2 Km
        return 1.75;
      }else{
        $adicional = (int)$distancia - 2000;
        if( $adicional <= 1000 ){
          return 2;
        }else{
          $adicional = $adicional / 1000;
          $adicional = ceil( $adicional );
          $adicional = 0.25 * $adicional;
          return 1.75 + $adicional;
        }
      }

    }

    public static function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2){
       $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
       switch($unit) {
               case 'km':
                       $distance = $degrees * 111.13384; 
                       break;
               case 'mi':
                       $distance = $degrees * 69.05482; 
                       break;
               case 'nmi':
                       $distance =  $degrees * 59.97662; 
       }
       return round($distance, $decimals);

    }

    public static function calularTiempoEntrega( $rest_id ){
      $ponderado = Pedidos::find()->andWhere( ['empresa_id' => $rest_id] )
                                    ->andWhere( ['estado_pedido_id' => 6] )
                                    ->average('tiempo_entrega_total');
      $ponderado = (int)$ponderado;
      if( $ponderado == 0 ){
        return '-';
      }else{
        return $ponderado.' min';
      }

    }

    public static function consultarTipoComida( $tiempo ){
      $result = \Yii::$app->db->createCommand('select id from tipos_comidas tp where UNIX_TIMESTAMP("'.$tiempo.'") BETWEEN UNIX_TIMESTAMP(CONCAT(current_date(), " ", tp.hora_inicio)) AND UNIX_TIMESTAMP(CONCAT(current_date(), " ", tp.hora_final))')->queryOne();
      return (int)$result['id'];
    }

    public static function borrarRegistrosRecursivos( $model ){
      $reflector = new \ReflectionClass($model);
      $relations = [];
      foreach ($reflector->getMethods() AS $method) {
          $relations [] = $method->name;
      }

      foreach ($relations as $relation) {
          $clase = explode('get', $relation);
          if( isset( $clase[1] ) ){
              $clase = $clase[1];
              if( file_exists(Yii::getAlias('@app').'/models/'.$clase.'.php') ){
                  // echo 'existe modelo:'.$clase.' <br>';
                  $relacion = lcfirst($clase);
                  $modelHijos = $model->$relacion;
                  if(is_array($modelHijos)){
                      foreach ($modelHijos as $hijo) {
                          self::borrarRegistrosRecursivos( $hijo );
                          $hijo->delete();
                      }
                  }
              }
          }
      }
      $model->delete();
    }

    public static function consultarCronTrazabilidad( $pedido_id, $mensaje_id, $usuario_id ){
      $validacion = TrazabilidadPush::find()->andWhere(['pedido_id'=>$pedido_id, 'mensaje_id'=>$mensaje_id, 'usuario_id'=>$usuario_id])->one();
      if( is_object( $validacion ) ){
        return true;
      }else{
        return false;
      }
    }

    public static function getMensajePush( $mensaje_id ){
      $mensaje = MensajesPush::findOne( $mensaje_id );
      if( is_object( $mensaje ) ){
        return $mensaje->mensaje;
      }else{
        return null;
      }
    }

    public static function setAlgoritmoConductoresProgramado( $empresa_id, $pedido_id, $fecha_pago, $tiempo_preparacion ){
      
      $preparacion = strtotime('+'.$tiempo_preparacion.' minutes', strtotime( $fecha_pago ));
      $fecha_programacion = strtotime('-10 minutes', $preparacion);

      $algoritmo = new AlgoritmoProgramado();
      $algoritmo->empresa_id = $empresa_id;
      $algoritmo->pedido_id = $pedido_id;
      $algoritmo->fecha_programacion = date('Y-m-d H:i:s', $fecha_programacion);
      $algoritmo->save();

    }

}
