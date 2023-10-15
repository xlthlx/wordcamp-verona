/**
 * Register all the block variations.
 */
wp.domReady(() => {

    /**
     * SWF Player.
     */
    wp.blocks.registerBlockVariation(
        'core/file',
        {
            name: 'wrc/swf-player',
            title: 'SWF Player',
            description: 'Player for ShockWave Flash animations',
            category: 'wordcamp',
            icon: 'controls-play',
            isDefault: true,
            example: '',
            namespace: 'wrc/swf-player',
            isActive: ['displayPreview', 'showDownloadButton'],
            attributes: {
                displayPreview: false,
                showDownloadButton: false,
            },
        },
    );

});
