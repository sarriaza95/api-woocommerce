<!-- creando funcion para el ejecutar el inicio de pago -->

function iniciar_pago_zonapagos() {
    if (isset($_POST['iniciar_pago'])) {
        // Obtener los datos del carrito y del cliente
        $order_id = WC()->session->get('order_awaiting_payment'); // Obtener el ID del pedido
        $order = wc_get_order($order_id);
        $total = $order->get_total();
        $email = $order->get_billing_email();
        $nombre = $order->get_billing_first_name();
        $apellido = $order->get_billing_last_name();
        $telefono = $order->get_billing_phone();
        $cliente_id = $order->get_customer_id();
        $descripcion_pago = 'Compra en mi tienda'; // Puedes personalizar esto
        $id_pago = $order->get_order_number(); // Puedes usar el número de pedido
        $iva = $total * 0.19; // Ejemplo: 19% de IVA, ajusta según tus necesidades

        $url = 'https://www.zonapagos.com/Apis_CicloPago/api/InicioPago';

        $data = array(
            "InformacionPago" => array(
                "flt_total_con_iva" => $total,
                "flt_valor_iva" => $iva,
                "str_id_pago" => $id_pago,
                "str_descripcion_pago" => $descripcion_pago,
                "str_email" => $email,
                "str_id_cliente" => $cliente_id,
                "str_tipo_id" => "1", // Tipo de identificación, ajustar según el caso
                "str_nombre_cliente" => $nombre,
                "str_apellido_cliente" => $apellido,
                "str_telefono_cliente" => $telefono,
                "str_opcional1" => "opcion 11",
                "str_opcional2" => "opcion 12",
                "str_opcional3" => "opcion 13",
                "str_opcional4" => "opcion 14",
                "str_opcional5" => "opcion 15"
            ),
            "InformacionSeguridad" => array(
                "int_id_comercio" => 678, // Coloca el ID de tu comercio
                "str_usuario" => "Usuario", // Usuario de Zonapagos
                "str_clave" => "Agosto17", // Clave de Zonapagos
                "int_modalidad" => 1
            ),
            "AdicionalesPago" => array(
                array(
                    "int_codigo" => 111,
                    "str_valor" => "0"
                ),
                array(
                    "int_codigo" => 112,
                    "str_valor" => "0"
                )
            ),
            "AdicionalesConfiguracion" => array(
                array(
                    "int_codigo" => 50,
                    "str_valor" => "2701"
                ),
                // Agrega más configuraciones según sea necesario
            )
        );

        $response = wp_remote_post($url, array(
            'method'    => 'POST',
            'body'      => json_encode($data),
            'headers'   => array('Content-Type' => 'application/json'),
        ));

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Algo salió mal: $error_message";
        } else {
            $response_body = wp_remote_retrieve_body($response);
            // Aquí manejas la respuesta recibida
            // Por ejemplo, redireccionar al usuario a la página de confirmación
            // echo $response_body;
        }
    }
}
add_action('woocommerce_after_checkout_form', 'iniciar_pago_zonapagos');


<!-- Ejemplo de Respuesta
Ejemplo Respuesta consumo CicloPagoInicioPago
{
 "int_codigo": 1,
 "str_cod_error": "",
 "str_descripcion_error": "",
 "str_url": "7804C9E8E4736207EC383B39DD758A1EA94CA677F077799F2B95CC3759D02807"
} -->
