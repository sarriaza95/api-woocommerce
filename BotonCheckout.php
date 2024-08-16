function agregar_boton_pago_zonapagos() {
    ?>
    <form method="POST">
        <input type="hidden" name="iniciar_pago" value="1">
        <button type="submit" class="button alt">Pagar con Zonapagos</button>
    </form>
    <?php
}
add_action('woocommerce_review_order_after_submit', 'agregar_boton_pago_zonapagos');
