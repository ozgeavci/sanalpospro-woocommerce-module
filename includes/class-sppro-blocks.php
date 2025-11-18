<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

class SPPRO_WC_Blocks_Payment_Method extends AbstractPaymentMethodType {

    // WooCommerce gateway ID'inle aynı
    protected $name = 'sanalpospro';

    protected $settings = array();

    /**
     * Zorunlu method: Blocks entegrasyonu başlatılırken çağrılır
     */
    public function initialize() {
        // Şimdilik ayar okumayı minimum tuttuk
        $this->settings = array(
            'title'       => 'Pay via Card (SanalPosPRO)',
            'description' => 'Test SanalPosPro blocks integration.',
        );
    }

    /**
     * Ödeme yöntemi aktif mi?
     * Debug için şimdilik her zaman true.
     */
    public function is_active() {
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
            '1.0.0',
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
