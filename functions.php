<?php

require_once(get_stylesheet_directory() . '/includes/divi-support.php');

// Register Classes
spl_autoload_register(function () {
    $classesDir = new DirectoryIterator(__DIR__ . '/classes');
    foreach ($classesDir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            require_once 'classes/' . $fileinfo->getFilename();
        }
    }
});

// Register each file - post type
$postTypesDir = new DirectoryIterator(__DIR__ . '/post-types');
foreach ($postTypesDir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        require_once 'post-types/' . $fileinfo->getFilename();
    }
}
function theme_files() {
    wp_enqueue_script('main-js', get_theme_file_uri('/dist/index.js'), ['jquery'], time(), true);
    wp_enqueue_style('main-css', get_theme_file_uri('dist/style.css'), [], '1.0', 'all');

    wp_localize_script(
        'main-js',
        'ajax_object',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('project_nonce'),
        ]
    );
}
add_action('wp_enqueue_scripts', 'theme_files');

function show_template($file, $args = null, $default_folder = 'parts')
{
    echo return_template($file, $args, $default_folder);
}

function return_template($file, $args = null, $default_folder = 'parts')
{
    $file = $default_folder . '/' . $file . '.php';
    if ($args) {
        extract($args);
    }
    if (locate_template($file)) {
        ob_start();
        include(locate_template($file)); //Theme Check free. Child themes support.
        $template_content = ob_get_clean();

        return $template_content;
    }

    return '';
}

function partners_filter() {
    $response = [
        'html' => '',
    ];

    $partnerName = isset($_POST['partnerName']) ? sanitize_text_field($_POST['partnerName']) : '';
    $partner_type_terms_slugs = isset($_POST['partnerType']) ? json_decode(stripslashes($_POST['partnerType']), true) : [];
    $payment_type_terms_slugs = isset($_POST['paymentType']) ? json_decode(stripslashes($_POST['paymentType']), true) : [];

    if ((!empty($partner_type_terms_slugs) && !empty($payment_type_terms_slugs)) || $partnerName) {
        $query_args = [
            'post_type' => 'partners',
            'orderby' => 'date',
            'posts_per_page' => -1,
            'order' => 'DESC',
        ];
    }

    if (!empty($partner_type_terms_slugs) && !empty($payment_type_terms_slugs)) {
        $query_args['tax_query'] = ['relation' => 'OR'];
    } elseif (!empty($partner_type_terms_slugs) || !empty($payment_type_terms_slugs))  {
        $query_args['tax_query'] = ['relation' => 'AND'];
    }
    if ($partnerName !== '') {
        $query_args['s'] = $partnerName;
    }

    if (!empty($partner_type_terms_slugs)) {
        $query_args['tax_query'][] = [
                'taxonomy' => 'partner-type',
                'field'    => 'slug',
                'terms'    => $partner_type_terms_slugs,
        ];
    }


    if (!empty($payment_type_terms_slugs)) {
        $query_args['tax_query'][] = [
                'taxonomy' => 'payment-type',
                'field'    => 'slug',
                'terms'    => $payment_type_terms_slugs,
        ];
    }

    // Filter the query for post title search only for the 'partners' post type
    add_filter('posts_search', function($search, $wp_query) use ($partnerName) {
        global $wpdb;

        // Check if the query is for the 'partners' post type
        if (!empty($partnerName) && isset($wp_query->query['post_type']) && $wp_query->query['post_type'] === 'partners') {
            $search = $search ? $search . ' AND ' : ' ';
            $search .= "({$wpdb->posts}.post_title LIKE '%" . esc_sql($wpdb->esc_like($partnerName)) . "%')";
        }
        return $search;
    }, 10, 2);

    $partners = new WP_Query($query_args);

    // Remove the filter after the query
    remove_filter('posts_search', 'wp_filter_posts_search');

    if ($partners->have_posts()) :
        while ($partners->have_posts()) :
            $partners->the_post();
            $response['html'] .=  return_template('loop-partners');
        endwhile;
    endif;
    wp_reset_query();

    wp_send_json($response);


}
add_action('wp_ajax_partners_filter', 'partners_filter');
add_action('wp_ajax_nopriv_partners_filter', 'partners_filter');
