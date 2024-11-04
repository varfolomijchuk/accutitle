<?php

use DiviChild\classes\RegisterPostTypes;

add_action('init', function () {
    RegisterPostTypes::registerPostType(
        'partners',
        'Partner',
        'Partners',
        ['supports' => ['title', 'thumbnail', 'revisions', 'editor', 'excerpt'],'public' => true, 'publicly_queryable'  => true, 'has_archive' => false, 'rewrite' => true, 'hierarchical' => true, 'menu_icon' => 'dashicons-universal-access', 'labels' => ['add_new' => _x('Add Item', 'backend: post type label', 'accutitle')]]
    );

    RegisterPostTypes::registerTaxonomy('payment-type', 'partners', 'Website Category', 'Website Categories');
    RegisterPostTypes::registerTaxonomy('partner-type', 'partners', 'Partner Type', 'Partner Types');
});
