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

    public static function calcularPedido( $pedido_id ){
      
      $pedido = Pedidos::findOne( $pedido_id );

      $base_imponible = 0;
      $total_iva = 0;
      $total_iva_cero = 0;
      $impuesto_iva = 0;

      foreach ($pedido->items as $item) {

        $item->costo_total = (float)$item->costo_unitario * (int)$item->cantidad;
        $base_imponible = $base_imponible + (float)$item->costo_total;
        if( $item->servicio->aplica_iva == 1 ){
          $total_iva = $total_iva + (float)$item->costo_total;
        }else{
          $total_iva_cero = $total_iva_cero + (float)$item->costo_total;
        }
        $item->save();

      }

      $impuesto_iva = (float)$total_iva * (float)Yii::$app->params['parametros_globales']['iva_valor'];
      $impuesto_iva = (float)$impuesto_iva - (float)$total_iva;

      $pedido->subtotal = (float)$base_imponible;
      $pedido->iva = (float)$total_iva;
      $pedido->iva_0 = (float)$total_iva_cero;
      $pedido->iva_impuesto = $impuesto_iva;
      $pedido->total = ( (float)$total_iva * (float)Yii::$app->params['parametros_globales']['iva_valor'] ) + (float)$total_iva_cero;
      $pedido->save();
      return $pedido;
    }

}