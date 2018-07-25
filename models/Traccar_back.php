<?php 
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Traccar extends Model {

    public static $host='http://localhost:8082';

    private static $adminEmail='admin';
    
    private static $adminPassword='admin';

    public static $cookie;

    public static function loginAdmin() {

        return self::login(self::$adminEmail,self::$adminPassword);
    }
    
    public static function register($name,$email,$password,$cookie) {

        $data='{"name":"'.$name.'","email":"'.$email.'","password":"'.$password.'"}';

        return self::curl('/api/users', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function login($email,$password) {

        $data='email='.$email.'&password='.$password;
        
        return self::curl('/api/session', 'POST','' ,$data,array('Content-Type: application/x-www-form-urlencoded'));
    }

    public static function updateUser($id,$name,$email,$password,$cookie) {

        $data='{"id":'.$id.',"name":"'.$name.'","email":"'.$email.'","readonly":false,"admin":false,"map":"","distanceUnit":"","speedUnit":"","latitude":0,"longitude":0,"zoom":0,"twelveHourFormat":false,"password":"'.$password.'"}';

        return self::curl('/api/users/'.$id, 'PUT',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function deleteUser($id,$name,$email,$cookie) {

        $data='{"id":'.$id.',"name":"'.$name.'","email":"'.$email.'","readonly":false,"admin":false,"map":"","distanceUnit":"","speedUnit":"","latitude":0,"longitude":0,"zoom":0,"twelveHourFormat":false,"password":""}';

        return self::curl('/api/users/'.$id, 'DELETE',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function addDevice($name,$uniqueId,$cookie) {

        $data='{"id":-1,"name":"'.$name.'","uniqueId":"'.$uniqueId.'","status":"","lastUpdate":null,"groupId":0}';

        return self::curl('/api/devices', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function editDevice($id,$name,$uniqueId,$cookie) {

        $data='{"id":'.$id.',"name":"'.$name.'","uniqueId":"'.$uniqueId.'","status":"","lastUpdate":null,"groupId":0}';

        return self::curl('/api/devices/'.$id, 'PUT',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function deleteDevice($id,$name,$uniqueId,$cookie) {

        $data='{"id": '.$id.', "name": "'.$name.'", "uniqueId": "'.$uniqueId.'", "status": "", "lastUpdate": null, "groupId": 0, "positionId": 0}';

        return self::curl('/api/devices/'.$id, 'DELETE',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function addDevicePermissions($userId,$deviceId,$cookie) {

        $data='{"userId": '.$userId.', "deviceId": '.$deviceId.'}';

        return self::curl('/api/permissions/devices', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function deleteDevicePermissions($userId,$deviceId,$cookie) {

        $data='{"userId": '.$userId.', "deviceId": '.$deviceId.'}';

        return self::curl('/api/permissions/devices', 'DELETE',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function logout($cookie) {
        
        return self::curl('/api/session', 'DELETE',$cookie ,'',array('Content-Type: application/x-www-form-urlencoded'));
    }

    public static function periodicReporting($deviceId,$frequency,$unit,$cookie) {

        $data='{"deviceId": '.$deviceId.', "type": "positionPeriodic", "id": -1, "attributes": {"frequency": '.$frequency*$unit.'}}';

        return self::curl('/api/commands', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function stopReporting($deviceId,$cookie) {

        $data='{"deviceId":'.$deviceId.',"type":"positionStop","id":-1}';

        return self::curl('/api/commands', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function engineStop($deviceId,$cookie) {

        $data='{"deviceId":'.$deviceId.',"type":"engineStop","id":-1}';

        return self::curl('/api/commands', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function engineResume($deviceId,$cookie) {

        $data='{"deviceId":'.$deviceId.',"type":"engineResume","id":-1}';

        return self::curl('/api/commands', 'POST',$cookie ,$data,array('Content-Type: application/json'));
    }

    public static function curl($task,$method,$cookie,$data,$header) {

        $res=new stdClass();

        $res->responseCode='';

        $res->error='';

        $header[]="Cookie: ".$cookie;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$host.$task);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        curl_setopt($ch, CURLOPT_HEADER, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if($method=='POST' || $method=='PUT' || $method=='DELETE') {

            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);

        $data=curl_exec($ch);

        $size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', substr($data, 0, $size), $c) == 1) self::$cookie = $c[1];

        $res->response = substr($data, $size);

        if(!curl_errno($ch)) {

            $res->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        else {

            $res->responseCode=400;

            $res->error= curl_error($ch);
        }

        curl_close($ch);

        return $res;
    }
}

?> 
