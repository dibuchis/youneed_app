<?php
namespace app\daemons;
use Yii;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;

class TraccarServer extends WebSocketServer
{

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_CLIENT_CONNECTED, function(WSClientEvent $e) {
            $url = Yii::$app->params['traccar']['rest_url'].'positions/'; //URL del servicio web REST
		    $header = array( 'Content-Type: application/json' );
		    // $data='{"id":13,"name":"mimi 2 edit","uniqueId":"1234","status":"","lastUpdate":null,"groupId":0}';
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_POST, 1);
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		    // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($curl, CURLOPT_USERPWD, Yii::$app->params['traccar']['usuario'] . ":" . Yii::$app->params['traccar']['clave']);  
		    $response = curl_exec($curl);
		    // $array = json_decode( $response, JSON_FORCE_OBJECT );
		    curl_close($curl);

            $e->client->send( $response );
        });
    }

}