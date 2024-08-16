function verificar_pago_woocommerce($order_id) {
    $resultado_verificacion = verificar_pago_zonapagos($order_id);

    // Aquí puedes manejar la respuesta de verificación
    if ($resultado_verificacion['codigo_respuesta'] == '00') {
        // El pago ha sido verificado con éxito
        // Puedes actualizar el estado del pedido o hacer otras acciones
    } else {
        // El pago no fue exitoso, maneja el error aquí
    }
}
add_action('woocommerce_thankyou', 'verificar_pago_woocommerce', 10, 1);