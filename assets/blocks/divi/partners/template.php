<?php
/**
 * Template Example Block
 *
 * @global array $args
 */
$payment_type_terms = get_terms([
    'taxonomy' => 'payment-type',
    'hide_empty' => false
]);
$payment_type_terms_slugs = [];
if ( ! empty( $payment_type_terms ) && ! is_wp_error( $payment_type_terms ) ) {
    foreach ( $payment_type_terms as $term ) {
        $payment_type_terms_slugs[] = $term->slug;
    }
}

$partner_type_terms = get_terms([
    'taxonomy' => 'partner-type',
    'hide_empty' => false
]);
$partner_type_terms_slugs = [];
if ( ! empty( $partner_type_terms ) && ! is_wp_error( $partner_type_terms ) ) {
    foreach ( $partner_type_terms as $term ) {
        $partner_type_terms_slugs[] = $term->slug;
    }
}

$query_args = [
    'post_type' => 'partners',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1,
];
$partners = new WP_Query($query_args);
?>

<div id="partners" class="partners">
    <div class="partners__title">
        <h2 class="et_pb_text_2"><?php echo $args['title']; ?></h2>
    </div>
    <div class="partners__filter">
        <div class="checkbox-filter">
            <?php foreach ($partner_type_terms as  $item) : ?>
                <a class="checkbox-item">
                    <div class="checkbox checked" data-value="<?php echo $item->slug; ?>">
                        <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g >
                                <g>
                                    <polyline points="5 8.5 12 15.5 19 8.5" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span><?php echo $item->name; ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="select-block">
            <div class="select-block--head">
                <span class="select-placeholder"><?php _e("Select category", 'accutitle') ?></span>
            <div class="select-block--categories">
                <a class="checkbox-item">
                    <div class="checkbox" data-value="<?php echo _e('all', 'accutitle'); ?>">
                        <svg width="800" height="800" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g >
                                <g>
                                    <polyline points="5 8.5 12 15.5 19 8.5" fill="none" stroke="#2B3E68" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span><?php echo _e('Select all', 'accutitle'); ?></span>
                </a>
                <?php foreach ($payment_type_terms as  $item) : ?>
                    <a class="checkbox-item">
                        <div class="checkbox checked" data-value="<?php echo $item->slug; ?>">
                            <svg width="800" height="800" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g >
                                    <g>
                                        <polyline points="5 8.5 12 15.5 19 8.5" fill="none" stroke="#2B3E68" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span><?php echo $item->name; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
            </div>
        </div>

        <div class="submit-block">
            <input type="text" placeholder="<?php _e('Search for a partner', 'accutitle'); ?>">
            <a class="filter-submit" id="filter-submit" href="#"><?php _e('Submit', 'accutitle'); ?></a>
        </div>
    </div>
    <?php if ($partners->have_posts()) : ?>
        <div class="partners__container">
            <?php while ($partners->have_posts()) : $partners->the_post(); ?>
                <?php  get_template_part('parts/loop', 'partners'); ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
