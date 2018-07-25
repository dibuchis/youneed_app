<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Atenciones;

/**
 * AtencionesSearch represents the model behind the search form about `app\models\Atenciones`.
 */
class AtencionesSearch extends Atenciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'paciente_id', 'doctor_id', 'atencion_id', 'turno_id', 'estado'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['fecha_creacion', 'sintomas', 'diagnostico', 'cie10', 'descripcion_cie10', 'medicamentos', 'observaciones', 'imagen', 'fecha_llenado_formulario', 'tiempo_atencion', 'precio_atencion', 'metodo_pago', 'referencia_placetopay', 'codigo_autorizacion', 'fecha_pago'], 'safe'],
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
        $query = Atenciones::find();

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
            'paciente_id' => $this->paciente_id,
            'doctor_id' => $this->doctor_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'atencion_id' => $this->atencion_id,
            'turno_id' => $this->turno_id,
            'fecha_creacion' => $this->fecha_creacion,
            'estado' => $this->estado,
            'fecha_llenado_formulario' => $this->fecha_llenado_formulario,
        ]);

        $query->andFilterWhere(['like', 'sintomas', $this->sintomas])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'cie10', $this->cie10])
            ->andFilterWhere(['like', 'descripcion_cie10', $this->descripcion_cie10])
            ->andFilterWhere(['like', 'medicamentos', $this->medicamentos])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'tiempo_atencion', $this->tiempo_atencion])
            ->andFilterWhere(['like', 'precio_atencion', $this->precio_atencion])
            ->andFilterWhere(['like', 'metodo_pago', $this->metodo_pago])
            ->andFilterWhere(['like', 'referencia_placetopay', $this->referencia_placetopay])
            ->andFilterWhere(['like', 'codigo_autorizacion', $this->codigo_autorizacion])
            ->andFilterWhere(['like', 'fecha_pago', $this->fecha_pago])
            ->andFilterWhere(['like', 'tiempo_atencion', $this->tiempo_atencion]);

        return $dataProvider;
    }

    public function monitoreo($params)
    {
        $query = Atenciones::find();

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
            'paciente_id' => $this->paciente_id,
            'doctor_id' => $this->doctor_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'atencion_id' => $this->atencion_id,
            'turno_id' => $this->turno_id,
            'fecha_creacion' => $this->fecha_creacion,
            'estado' => $this->estado,
            'fecha_llenado_formulario' => $this->fecha_llenado_formulario,
        ]);

        $query->andFilterWhere(['like', 'sintomas', $this->sintomas])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'cie10', $this->cie10])
            ->andFilterWhere(['like', 'descripcion_cie10', $this->descripcion_cie10])
            ->andFilterWhere(['like', 'medicamentos', $this->medicamentos])
            ->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['in', 'estado', [0,1,2]])
            ->andFilterWhere(['like', 'tiempo_atencion', $this->tiempo_atencion]);

        return $dataProvider;
    }
}
