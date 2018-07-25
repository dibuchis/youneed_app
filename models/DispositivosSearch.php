<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dispositivos;

/**
 * DispositivosSearch represents the model behind the search form about `app\models\Dispositivos`.
 */
class DispositivosSearch extends Dispositivos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cuenta_id', 'grupo_id', 'categoria_id', 'traccar_id'], 'integer'],
            [['nombre', 'alias', 'placa', 'imei', 'tipo'], 'safe'],
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
        $query = Dispositivos::find();
        // $query->rightJoin('usuarios', 'dispositivos.id = usuarios.dispositivo_id');
        $query->andWhere(['utim_app_tipo' => null]);
        $query->orWhere(['<>','utim_app_tipo', 'Paciente']);

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
            'grupo_id' => $this->grupo_id,
            'categoria_id' => $this->categoria_id,
            'traccar_id' => $this->traccar_id,
            // 'tipo_dispositivo' => 0,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'imei', $this->imei])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }

    public function dispositivosgps($params)
    {
        $query = Dispositivos::find();
        // $query->rightJoin('usuarios', 'dispositivos.id = usuarios.dispositivo_id');
        $query->andWhere(['utim_app_tipo' => null]);

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
            'grupo_id' => $this->grupo_id,
            'categoria_id' => $this->categoria_id,
            'traccar_id' => $this->traccar_id,
            // 'tipo_dispositivo' => 0,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'placa', $this->placa])
            ->andFilterWhere(['like', 'imei', $this->imei])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }
}
