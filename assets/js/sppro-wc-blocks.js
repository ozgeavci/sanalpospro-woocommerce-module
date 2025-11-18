( function( wp, wc ) {
    const blocksRegistry = wc.wcBlocksRegistry || wc.blocksCheckout;
    if ( ! blocksRegistry || ! blocksRegistry.registerPaymentMethod ) {
        return;
    }

    const { registerPaymentMethod } = blocksRegistry;
    const { getSetting } = wc.wcSettings || {};
    const settings = getSetting ? getSetting( 'sanalpospro_data', {} ) : {};
    const label = settings.title || 'Pay via Card (SanalPosPRO)';

    const el = wp.element && wp.element.createElement ? wp.element.createElement : function() {};

    // React ELEMENT oluşturuyoruz (fonksiyon değil)
    const contentElement = el(
        'div',
        null,
        settings.description || 'Pay securely with SanalPosPRO.'
    );

    registerPaymentMethod( {
        name: 'sanalpospro',
        label: label,
        ariaLabel: label,
        canMakePayment: () => true,
        // Artık direkt React element veriyoruz
        content: contentElement,
        edit: contentElement,
        supports: {
            features: [ 'products' ],
        },
    } );
} )( window.wp || {}, window.wc || {} );
