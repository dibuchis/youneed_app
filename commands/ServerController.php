<?php
namespace app\commands;

use app\daemons\TraccarServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = null)
    {
        $server = new TraccarServer();
        if ($port) {
            $server->port = $port;
        }
        $server->start();
    }
}