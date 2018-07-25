<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form about `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cuenta_id', 'estado_id'], 'integer'],
            [['nombres', 'apellidos', 'email', 'clave', 'tipo', 'fecha_creacion', 'identificacion', 'numero_celular'], 'safe'],
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
        $query = Usuarios::find();

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
            'fecha_creacion' => $this->fecha_creacion,
            'estado_id' => $this->estado_id,
            'tipo_usuario' => 0,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }

    public function pacientes($params)
    {
        $query = Usuarios::find();

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
            'fecha_creacion' => $this->fecha_creacion,
            'estado_id' => $this->estado_id,
            'tipo_usuario' => 1,
            'tipo' => 'Paciente',
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }

    public function doctores($params)
    {
        $query = Usuarios::find();

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
            'fecha_creacion' => $this->fecha_creacion,
            'estado_id' => $this->estado_id,
            'tipo_usuario' => 1,
            'tipo' => 'Doctor',
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }

}
