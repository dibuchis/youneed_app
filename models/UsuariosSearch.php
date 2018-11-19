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
            [['id', 'tipo_identificacion', 'estado', 'habilitar_rastreo', 'plan_id', 'banco_id', 'preferencias_deposito', 'dias_trabajo', 'horarios_trabajo', 'estado_validacion_documentos', 'traccar_id'], 'integer'],
            [['identificacion', 'imagen', 'nombres', 'apellidos', 'email', 'numero_celular', 'telefono_domicilio', 'clave', 'token_push', 'token', 'fecha_creacion', 'fecha_activacion', 'fecha_desactivacion', 'causas_desactivacion', 'fecha_cambio_plan', 'tipo_cuenta', 'numero_cuenta', 'observaciones', 'imei'], 'safe'],
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
            'tipo_identificacion' => $this->tipo_identificacion,
            'estado' => $this->estado,
            'habilitar_rastreo' => $this->habilitar_rastreo,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_activacion' => $this->fecha_activacion,
            'fecha_desactivacion' => $this->fecha_desactivacion,
            'plan_id' => $this->plan_id,
            'fecha_cambio_plan' => $this->fecha_cambio_plan,
            'banco_id' => $this->banco_id,
            'preferencias_deposito' => $this->preferencias_deposito,
            'dias_trabajo' => $this->dias_trabajo,
            'horarios_trabajo' => $this->horarios_trabajo,
            'estado_validacion_documentos' => $this->estado_validacion_documentos,
            'traccar_id' => $this->traccar_id,
        ]);

        $query->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'telefono_domicilio', $this->telefono_domicilio])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'token_push', $this->token_push])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'causas_desactivacion', $this->causas_desactivacion])
            ->andFilterWhere(['like', 'tipo_cuenta', $this->tipo_cuenta])
            ->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imei', $this->imei]);

        return $dataProvider;
    }

    public function searchSuperadmin($params)
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
            'tipo_identificacion' => $this->tipo_identificacion,
            'estado' => $this->estado,
            'habilitar_rastreo' => $this->habilitar_rastreo,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_activacion' => $this->fecha_activacion,
            'fecha_desactivacion' => $this->fecha_desactivacion,
            'plan_id' => $this->plan_id,
            'fecha_cambio_plan' => $this->fecha_cambio_plan,
            'banco_id' => $this->banco_id,
            'preferencias_deposito' => $this->preferencias_deposito,
            'dias_trabajo' => $this->dias_trabajo,
            'horarios_trabajo' => $this->horarios_trabajo,
            'estado_validacion_documentos' => $this->estado_validacion_documentos,
            'traccar_id' => $this->traccar_id,
            'es_super' => 1,
        ]);

        $query->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'telefono_domicilio', $this->telefono_domicilio])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'token_push', $this->token_push])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'causas_desactivacion', $this->causas_desactivacion])
            ->andFilterWhere(['like', 'tipo_cuenta', $this->tipo_cuenta])
            ->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imei', $this->imei]);

        return $dataProvider;
    }

    public function searchClientes($params)
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
            'tipo_identificacion' => $this->tipo_identificacion,
            'estado' => $this->estado,
            'habilitar_rastreo' => $this->habilitar_rastreo,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_activacion' => $this->fecha_activacion,
            'fecha_desactivacion' => $this->fecha_desactivacion,
            'plan_id' => $this->plan_id,
            'fecha_cambio_plan' => $this->fecha_cambio_plan,
            'banco_id' => $this->banco_id,
            'preferencias_deposito' => $this->preferencias_deposito,
            'dias_trabajo' => $this->dias_trabajo,
            'horarios_trabajo' => $this->horarios_trabajo,
            'estado_validacion_documentos' => $this->estado_validacion_documentos,
            'traccar_id' => $this->traccar_id,
            'es_cliente' => 1,
        ]);

        $query->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'telefono_domicilio', $this->telefono_domicilio])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'token_push', $this->token_push])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'causas_desactivacion', $this->causas_desactivacion])
            ->andFilterWhere(['like', 'tipo_cuenta', $this->tipo_cuenta])
            ->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imei', $this->imei]);

        return $dataProvider;
    }

    public function searchAsociados($params)
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
            'tipo_identificacion' => $this->tipo_identificacion,
            'estado' => $this->estado,
            'habilitar_rastreo' => $this->habilitar_rastreo,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_activacion' => $this->fecha_activacion,
            'fecha_desactivacion' => $this->fecha_desactivacion,
            'plan_id' => $this->plan_id,
            'fecha_cambio_plan' => $this->fecha_cambio_plan,
            'banco_id' => $this->banco_id,
            'preferencias_deposito' => $this->preferencias_deposito,
            'dias_trabajo' => $this->dias_trabajo,
            'horarios_trabajo' => $this->horarios_trabajo,
            'estado_validacion_documentos' => $this->estado_validacion_documentos,
            'traccar_id' => $this->traccar_id,
            'es_asociado' => 1,
        ]);

        $query->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'numero_celular', $this->numero_celular])
            ->andFilterWhere(['like', 'telefono_domicilio', $this->telefono_domicilio])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'token_push', $this->token_push])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'causas_desactivacion', $this->causas_desactivacion])
            ->andFilterWhere(['like', 'tipo_cuenta', $this->tipo_cuenta])
            ->andFilterWhere(['like', 'numero_cuenta', $this->numero_cuenta])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imei', $this->imei]);

        return $dataProvider;
    }
}
