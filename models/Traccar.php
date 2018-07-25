<?php 
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Traccar extends Model {

    public static function setDevice($device, $method, $device_id=null){
        if( $method == 'POST' ){
            $data='{"id":-1,"name":"'.$device->nombre.'","uniqueId":"'.$device->imei.'","status":"","lastUpdate":null,"groupId":0}';
        }else{
            $data='{"id":'.$device->traccar_id.',"name":"'.$device->nombre.'","uniqueId":"'.$device->imei.'","status":"","lastUpdate":null,"groupId":0}';
        }
        return self::curl($data, $method, $device_id);
    }

    public static function deleteDevice($device_id){
        $data='{"id":'.$device_id.'}';
        return self::curl($data, 'DELETE', $device_id);
    }

    public static function curl($data, $method, $device_id=null){
        if( $method == 'POST' ){
            $url = Yii::$app->params['traccar']['rest_url'].'devices/';
        }else{
            $url = Yii::$app->params['traccar']['rest_url'].'devices/'.$device_id;
        }
        $header = array( 'Content-Type: application/json' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
        $response = curl_exec($curl);
        curl_close($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        return $array;
    }

    public static function getDevice($device_id){
        $url = Yii::$app->params['traccar']['rest_url'].'devices?id='.$device_id;
        
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-length: 0'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }

    public static function getDevices(){
        $url = Yii::$app->params['traccar']['rest_url'].'devices';
        $header = array( 'Content-Type: application/json' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);   
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }

    public static function getPositions(){
        $url = Yii::$app->params['traccar']['rest_url'].'positions';
        $header = array( 'Content-Type: application/json' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);   
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }

    public static function getPositionsDevicesAvailable( $url ){

        $from = '';
        $to = '';
        
        $url = Yii::$app->params['traccar']['rest_url'].'positions/?'.$url;
        $header = array( 'Content-Type: application/json' );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);   
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }

    public static function getPosition($position_id){
        $url = Yii::$app->params['traccar']['rest_url'].'positions/?id='.$position_id;
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-length: 0'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }

    public static function getRoute($device_id, $from, $to){
        // $from = strtotime('+5 hours', strtotime( $from ));
        // $from = date('Y-m-d H:i:s', $from);
        
        // $to = strtotime('+5 hours', strtotime( $to ));
        // $to = date('Y-m-d H:i:s', $to);

        $url = Yii::$app->params['traccar']['rest_url'].'reports/route/?deviceId='.$device_id.'&from='.urlencode( date('Y-m-d\TH:i\Z', strtotime( $from )) ).'&to='.urlencode( date('Y-m-d\TH:i\Z', strtotime( $to )) );

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-length: 0'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
        $response = curl_exec($curl);
        $array = json_decode( $response, JSON_FORCE_OBJECT );
        curl_close($curl);
        return $array;
    }
}