/**
 * Register all the block variations.
 */
wp.domReady(() => {

    /**
     * Punch Line Header.
     */
    wp.blocks.registerBlockVariation(
        'core/heading',
        {
            name: 'wrc/heading',
            category: 'wordcamp',
            title: 'Punch Line Header',
            isDefault: true,
            attributes: {
                style: {
                    typography: {
                        lineHeight: "0"
                    }
                },
                backgroundColor: 'foreground',
                textColor: 'background',
                fontSize: 'medium',
                fontFamily: 'punch-label'
            },
            isActive: ['fontSize', 'fontFamily']
        }
    );

});

/**
 * Move the core block paragraph to the `wordpress` category.
 *
 * @param settings
 * @param name
 * @returns {*}
 */
function wrcFilterSpacerCategory(settings, name) {
    if (name === "core/paragraph" || name === "core/file" || name === "core/heading") {
        return lodash.assign({}, settings, {
            category: "wordcamp",
        });
    }
    return settings;
}

wp.hooks.addFilter(
    "blocks.registerBlockType",
    "wrc/filter-spacer-category",
    wrcFilterSpacerCategory
);
