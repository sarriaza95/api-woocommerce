function verificar_pago_zonapagos($order_id) {
    // Obtener los datos del pedido
    $order = wc_get_order($order_id);
    $id_pago = $order->get_order_number(); // Puedes usar el número de pedido

    $url = 'https://www.zonapagos.com/Apis_CicloPago/api/VerificaciónPago';

    $data = array(
        "int_id_comercio" => 678, // ID de comercio, ajustar según sea necesario
        "str_usr_comercio" => "Usuario", // Usuario de Zonapagos
        "str_pwd_Comercio" => "Agosto17", // Contraseña de Zonapagos
        "str_id_pago" => $id_pago,
        "int_no_pago" => -1 // Ajusta este valor según tus necesidades
    );

    $response = wp_remote_post($url, array(
        'method'    => 'POST',
        'body'      => json_encode($data),
        'headers'   => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        return "Algo salió mal: $error_message";
    } else {
        $response_body = wp_remote_retrieve_body($response);
        return json_decode($response_body, true);
    }
}

<!-- Ejemplo Respuesta consumo CicloPago VerificacionPago
{
 "int_estado": 1,
 "int_error": 0,
 "str_detalle": null,
 "int_cantidad_pagos": 2,
 "str_res_pago": " |
3772 | | 200 | 1002 | | 12500 | | | 123456789 | Cristina | Vargas | 319632555648 | soporte9@zonavirtual.com | opcion 11
| opcion 12 | opcion 13 | | | | | ;
31 | 3773 | 1 | 1 | 1 | 12500 | 12500 | 13 | camisa | 123456789 | Cristina | Vargas | 319632555648 |
soporte9@zonavirtual.com | opcion 11 | opcion 12 | opcion 13 | | | 9/11/2018 12:58:41 PM | 29 | 18092100031 | 2701 |
1022 | BANCO UNION COLOMBIANO | 1468228 | 3 | ; "
} -->