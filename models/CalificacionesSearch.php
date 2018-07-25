<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calificaciones;

/**
 * CalificacionesSearch represents the model behind the search form about `app\models\Calificaciones`.
 */
class CalificacionesSearch extends Calificaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calificacion', 'atencion_id'], 'integer'],
            [['fecha_calificacion'], 'safe'],
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
        $query = Calificaciones::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'calificacion' => $this->calificacion,
            'atencion_id' => $this->atencion_id,
            'fecha_calificacion' => $this->fecha_calificacion,
        ]);

        return $dataProvider;
    }
}
