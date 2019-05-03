<?php

namespace app\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Models\TiposNotificaciones;

/**
 * TiposNotificacionesSearch represents the model behind the search form of `app\Models\TiposNotificaciones`.
 */
class TiposNotificacionesSearch extends TiposNotificaciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria'], 'integer'],
            [['descripcion', 'mensaje'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TiposNotificaciones::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'categoria' => $this->categoria,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'mensaje', $this->mensaje]);

        return $dataProvider;
    }
}
