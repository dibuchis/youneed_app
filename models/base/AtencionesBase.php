<?php

namespace app\models\base;

use Yii;
use app\models\Usuarios;
use app\models\Calificaciones;
use app\models\Trazabilidades;

/**
 * This is the model class for table "atenciones".
*
    * @property integer $id
    * @property integer $paciente_id
    * @property integer $doctor_id
    * @property double $latitude
    * @property double $longitude
    * @property integer $atencion_id
    * @property integer $turno_id
    * @property string $fecha_creacion
    * @property integer $estado
    * @property string $sintomas
    * @property string $diagnostico
    * @property string $cie10
    * @property string $descripcion_cie10
    * @property string $medicamentos
    * @property string $observaciones
    * @property string $imagen
    * @property string $fecha_llenado_formulario
    * @property string $tiempo_atencion
    * @property double $latitude_inicial_doctor
    * @property double $longitude_inicial_doctor
    * @property integer $usuario_atencion_id
    * @property double $last_latitude_doctor
    * @property double $last_longitude_doctor
    * @property integer $clave
    * @property integer $sincronizacion_evolution
    * @property string $precio_atencion
    * @property string $referencia_placetopay
    * @property string $metodo_pago
    * @property string $codigo_autorizacion
    * @property string $fecha_pago
    * @property string $tipo_atencion
    *
            * @property Usuarios $paciente
            * @property Usuarios $doctor
            * @property Calificaciones[] $calificaciones
            * @property Trazabilidades[] $trazabilidades
    */
class AtencionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'atenciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['paciente_id'], 'required'],
            [['paciente_id', 'doctor_id', 'atencion_id', 'turno_id', 'estado', 'usuario_atencion_id', 'clave', 'sincronizacion_evolution'], 'integer'],
            [['latitude', 'longitude', 'latitude_inicial_doctor', 'longitude_inicial_doctor', 'last_latitude_doctor', 'last_longitude_doctor', 'precio_atencion'], 'number'],
            [['fecha_creacion', 'fecha_llenado_formulario', 'fecha_pago'], 'safe'],
            [['imagen', 'tiempo_atencion', 'metodo_pago', 'tipo_atencion'], 'string'],
            [['sintomas', 'diagnostico', 'descripcion_cie10', 'medicamentos', 'observaciones'], 'string', 'max' => 2000],
            [['cie10'], 'string', 'max' => 1000],
            [['referencia_placetopay'], 'string', 'max' => 60],
            [['codigo_autorizacion'], 'string', 'max' => 50],
            [['paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['paciente_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'paciente_id' => 'Paciente ID',
    'doctor_id' => 'Doctor ID',
    'latitude' => 'Latitude',
    'longitude' => 'Longitude',
    'atencion_id' => 'Atencion ID',
    'turno_id' => 'Turno ID',
    'fecha_creacion' => 'Fecha Creacion',
    'estado' => 'Estado',
    'sintomas' => 'Sintomas',
    'diagnostico' => 'Diagnostico',
    'cie10' => 'Cie10',
    'descripcion_cie10' => 'Descripcion Cie10',
    'medicamentos' => 'Medicamentos',
    'observaciones' => 'Observaciones',
    'imagen' => 'Imagen',
    'fecha_llenado_formulario' => 'Fecha Llenado Formulario',
    'tiempo_atencion' => 'Tiempo Atencion',
    'latitude_inicial_doctor' => 'Latitude Inicial Doctor',
    'longitude_inicial_doctor' => 'Longitude Inicial Doctor',
    'usuario_atencion_id' => 'Usuario Atencion ID',
    'last_latitude_doctor' => 'Last Latitude Doctor',
    'last_longitude_doctor' => 'Last Longitude Doctor',
    'clave' => 'Clave',
    'sincronizacion_evolution' => 'Sincronizacion Evolution',
    'precio_atencion' => 'Precio Atencion',
    'referencia_placetopay' => 'Referencia Placetopay',
    'metodo_pago' => 'Metodo Pago',
    'codigo_autorizacion' => 'Codigo Autorizacion',
    'fecha_pago' => 'Fecha Pago',
    'tipo_atencion' => 'Tipo Atencion',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPaciente()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'paciente_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDoctor()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'doctor_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCalificaciones()
    {
    return $this->hasMany(Calificaciones::className(), ['atencion_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTrazabilidades()
    {
    return $this->hasMany(Trazabilidades::className(), ['atencion_id' => 'id']);
    }
}