<?php 
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Geo extends Model {

	public static function puntoEnPoligono($poligono_wkt, $punto){
		$query = 'select ST_Contains(ST_GEOMFROMTEXT("'.$poligono_wkt.'"), ST_GEOMFROMTEXT("'.$punto.'")) as consulta';
	    $punto = Yii::app()->db->createCommand($query)->queryRow();
	    return $punto;
	}

	public static function puntoEnCirculo( $lat1, $lng1, $lat2, $lng2, $radio ){
		$result = \Yii::$app->db->createCommand("CALL punto_circulo(:lat1, :lng1, :lat2, :lng2, :radio)") 
                      ->bindValue(':lat1' , $lat1 )
                      ->bindValue(':lng1', $lng1)
                      ->bindValue(':lat2', $lat2)
                      ->bindValue(':lng2', $lng2)
                      ->bindValue(':radio', $radio)
                      ->queryOne();
	    return (int)$result['consulta'];
	}

}
?>