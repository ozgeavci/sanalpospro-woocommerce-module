<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

class SPPRO_WC_Blocks_Payment_Method extends AbstractPaymentMethodType {

    
    protected $name = 'sanalpospro';

    protected $settings = array();

    /**
     * Blocks entegrasyonu başlatılırken çağrılır
     */
    public function initialize() {
        // WooCommerce gateway ayarlarını çek
        $gateway_settings = get_option( 'woocommerce_' . $this->name . '_settings', array() );

        $this->settings = array(
            'enabled'     => isset( $gateway_settings['enabled'] ) ? $gateway_settings['enabled'] : 'no',
            'title'       => isset( $gateway_settings['title'] ) ? $gateway_settings['title'] : __( 'Pay via Card (SanalPosPRO)', 'sanalpospro-payment-module' ),
            'description' => isset( $gateway_settings['description'] ) ? $gateway_settings['description'] : __( 'Secure payment with SanalPosPRO.', 'sanalpospro-payment-module' ),
        );
    }

   /**
 * Ödeme yöntemi aktif mi?
 */
public function is_active() {

    // WooCommerce ödeme ayarlarını oku
    $gateway_settings = get_option( 'woocommerce_' . $this->name . '_settings', array() );


    if ( empty( $gateway_settings ) ) {
        return true;
    }

    // Ayarlarda "enabled" => "yes" değilse gösterme
    if ( 'yes' !== ( $gateway_settings['enabled'] ?? 'no' ) ) {
        return false;
    }

    return true;
}


    /**
     * Block Checkout için JS dosyası
     */
    public function get_payment_method_script_handles() {

        wp_register_script(
            'sppro-wc-blocks',
            SPPRO_PLUGIN_URL . 'assets/js/sppro-wc-blocks.js',
            array( 'wc-blocks-registry', 'wc-settings', 'wp-element' ),
            defined( 'SPPRO_PLUGIN_VERSION' ) ? SPPRO_PLUGIN_VERSION : '1.0.0',
            true
        );

        return array( 'sppro-wc-blocks' );
    }
/**
 * JS tarafına gidecek veriler
 */
public function get_payment_method_data() {
    return array(
        'title'       => $this->settings['title'],
        'description' => $this->settings['description'],
    );
}

}
