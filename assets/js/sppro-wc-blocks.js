/**
 * SanalPosPRO – WooCommerce Blocks payment method
 *
 * Registers the "sanalpospro" payment method in WooCommerce Blocks checkout.
 */

( function( wp, wc ) {

    const blocksRegistry = wc.wcBlocksRegistry || wc.blocksCheckout;

    // If Blocks API is not available, do nothing
    if ( ! blocksRegistry || ! blocksRegistry.registerPaymentMethod ) {
        return;
    }

    const { registerPaymentMethod } = blocksRegistry;

    // Read gateway settings provided from PHP (sanalpospro_data)
    const { getSetting } = wc.wcSettings || {};
    const settings = getSetting ? getSetting( 'sanalpospro_data', {} ) : {};

    // Label shown for the payment method
    const label = settings.title || 'Pay via Card (SanalPosPRO)';

    // React.createElement helper (fallback to no-op if not available)
    const el = wp.element && wp.element.createElement ? wp.element.createElement : function() {};

    // React element rendered in the Blocks checkout UI
    const contentElement = el(
        'div',
        null,
        settings.description || 'Pay securely with SanalPosPRO.'
    );

    // Register payment method with WooCommerce Blocks
    registerPaymentMethod( {
        name: 'sanalpospro',
        label: label,
        ariaLabel: label,

        // Always allow this method to be used (can be extended later)
        canMakePayment: () => true,

        // Content shown for this method in checkout / editor
        content: contentElement,
        edit: contentElement,

        supports: {
            features: [ 'products' ],
        },
    } );

} )( window.wp || {}, window.wc || {} );
