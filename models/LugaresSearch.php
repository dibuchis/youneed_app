<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lugares;

/**
 * LugaresSearch represents the model behind the search form about `app\models\Lugares`.
 */
class LugaresSearch extends Lugares
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cuenta_id', 'estado_id'], 'integer'],
            [['nombre', 'tipo', 'poligono', 'wkt'], 'safe'],
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
        $query = Lugares::find();

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
            'cuenta_id' => $this->cuenta_id,
            'estado_id' => $this->estado_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'poligono', $this->poligono])
            ->andFilterWhere(['like', 'wkt', $this->wkt]);

        return $dataProvider;
    }
}
