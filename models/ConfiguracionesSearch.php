<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Configuraciones;

/**
 * ConfiguracionesSearch represents the model behind the search form about `app\models\Configuraciones`.
 */
class ConfiguracionesSearch extends Configuraciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['politicas_condiciones', 'beneficios_ser_asociado', 'promociones_asociados', 'ayuda'], 'safe'],
            [['porcentaje_cancelacion_cliente'], 'number'],
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
        $query = Configuraciones::find();

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
            'porcentaje_cancelacion_cliente' => $this->porcentaje_cancelacion_cliente,
        ]);

        $query->andFilterWhere(['like', 'politicas_condiciones', $this->politicas_condiciones])
            ->andFilterWhere(['like', 'beneficios_ser_asociado', $this->beneficios_ser_asociado])
            ->andFilterWhere(['like', 'promociones_asociados', $this->promociones_asociados])
            ->andFilterWhere(['like', 'ayuda', $this->ayuda]);

        return $dataProvider;
    }
}
