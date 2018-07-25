<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visitas;

/**
 * VisitasSearch represents the model behind the search form about `app\models\Visitas`.
 */
class VisitasSearch extends Visitas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dispositivo_id', 'cumplimiento'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['fecha_creacion', 'fecha_inicio', 'fecha_final'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Visitas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if( Yii::$app->user->identity->tipo == 'Personal' ){
            $query->andFilterWhere([
                'id' => $this->id,
                'dispositivo_id' => Yii::$app->user->identity->dispositivo_id,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'fecha_creacion' => $this->fecha_creacion,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_final' => $this->fecha_final,
                'cumplimiento' => $this->cumplimiento,
            ]);
        }else{
            $query->andFilterWhere([
                'id' => $this->id,
                'dispositivo_id' => $this->dispositivo_id,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'fecha_creacion' => $this->fecha_creacion,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_final' => $this->fecha_final,
                'cumplimiento' => $this->cumplimiento,
            ]);
        }

        return $dataProvider;
    }
}
