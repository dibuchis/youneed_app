<?php

return [
    'adminEmail' => 'admin@example.com',
    'uploadImages' => '/img_temporales/',
    'google_key' => 'AIzaSyCWmnu8hgRqQzEIU3Sp35ygYoyq_WOIC6Q',
    'metros_redonda' => 6000, //6km
    'metros_redonda_movil' => 12500, //6km
    'metros_redonda_visita' => 100,
    'estados_genericos' =>  [
                                1 => 'Activo',
                                0 => 'Inactivo',
                            ],
    'api_utim' => 'http://utimedical.geomonitoreo.com/api/',
    'traccar' => array(	'socket_url' => 'ws://23.239.19.165:8082/api/socket',
    					'rest_url' => 'http://23.239.19.165:8082/api/',
    					'transmision_url' => 'http://23.239.19.165:5055/api',
    					'usuario' => 'youneed',
    					'clave' => '@AbitYouNeedServer2019',
    ),
    'token_firebase' => 'AIzaSyDkLPjdNxx6V09ZUJr8yBSO-EqykywlFHw',
    'mensajes_push'=> [ 
                        'atencion_doctor_asignado' => 'Su atención fue aprobada, se le asignó un médico',
                        'atencion_doctor_llega' => 'El doctor ha llegado, salga a recibirlo',
                        'atencion_calificacion' => 'Califique la atención que recibio',
                        'atencion_realizar_pago' => 'Por favor realice el pago de la atención recibida',
                        'doctor_cuenta_activada' => 'Estimado Dr(a). su cuenta a sido activada, ya puede ingresar en UTIM APP',
                        'doctor_atencion_asignada' => 'Estimado Dr(a). se le asignó una atención, revisar UTIM APP',
                        'paciente_cancela_atencion' => 'Estimado Dr(a). La atención fue cancelada',
                    ],
    'placetopay' => [
                        'login' => '',
                        'secretKey' => 'Kcp8dH6G34w1bHq9',
                        'placetopay_url' => 'https://test.placetopay.ec/redirection/',
                        'iva' => 1.12,
                    ],
];
