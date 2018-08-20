<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Servicios;

/**
 * ServiciosSearch represents the model behind the search form about `app\models\Servicios`.
 */
class ServiciosSearch extends Servicios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'obligatorio_certificado'], 'integer'],
            [['nombre', 'slug', 'incluye', 'no_incluye', 'imagen'], 'safe'],
            [['tarifa_proveedor', 'subtotal', 'iva', 'total'], 'number'],
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
        $query = Servicios::find();

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
            // 'tarifa_base' => $this->tarifa_base,
            // 'tarifa_dinamica' => $this->tarifa_dinamica,
            // 'aplica_iva' => $this->aplica_iva,
            // 'obligatorio_certificado' => $this->obligatorio_certificado,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'incluye', $this->incluye])
            ->andFilterWhere(['like', 'no_incluye', $this->no_incluye])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        return $dataProvider;
    }
}
