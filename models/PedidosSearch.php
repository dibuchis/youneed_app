<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedidos;

/**
 * PedidosSearch represents the model behind the search form about `app\models\Pedidos`.
 */
class PedidosSearch extends Pedidos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cliente_id', 'asociado_id', 'forma_pago', 'tarjeta_id', 'tipo_atencion', 'tiempo_llegada', 'estado', 'tiempo_aproximado_llegada'], 'integer'],
            [['latitud', 'longitud', 'subtotal', 'iva', 'iva_0', 'total', 'valores_transferir_asociado', 'valores_cancelacion_servicio_cliente'], 'number'],
            [['identificacion', 'razon_social', 'nombres', 'apellidos', 'email', 'telefono', 'fecha_para_servicio', 'direccion_completa', 'observaciones_adicionales', 'codigo_postal', 'fecha_creacion', 'fecha_llegada_atencion', 'fecha_finalizacion_atencion'], 'safe'],
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
        $query = Pedidos::find();

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
            'cliente_id' => $this->cliente_id,
            'asociado_id' => $this->asociado_id,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'fecha_para_servicio' => $this->fecha_para_servicio,
            'forma_pago' => $this->forma_pago,
            'tarjeta_id' => $this->tarjeta_id,
            'tipo_atencion' => $this->tipo_atencion,
            'tiempo_llegada' => $this->tiempo_llegada,
            'fecha_creacion' => $this->fecha_creacion,
            'estado' => $this->estado,
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'iva_0' => $this->iva_0,
            'total' => $this->total,
            'fecha_llegada_atencion' => $this->fecha_llegada_atencion,
            'fecha_finalizacion_atencion' => $this->fecha_finalizacion_atencion,
            'valores_transferir_asociado' => $this->valores_transferir_asociado,
            'valores_cancelacion_servicio_cliente' => $this->valores_cancelacion_servicio_cliente,
            'tiempo_aproximado_llegada' => $this->tiempo_aproximado_llegada,
        ]);

        $query->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'razon_social', $this->razon_social])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'direccion_completa', $this->direccion_completa])
            ->andFilterWhere(['like', 'observaciones_adicionales', $this->observaciones_adicionales])
            ->andFilterWhere(['like', 'codigo_postal', $this->codigo_postal]);

        return $dataProvider;
    }
}
