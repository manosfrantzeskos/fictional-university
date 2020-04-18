<?php
  get_header();
  setPageBanner( array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  )); ?>

<div class="container container--narrow page-section">
  <?php
    $today = date("Ymd");
    $past_events = new WP_Query([
      "post_type" => "event",
      "meta_key" => "event_date",
      "orderby" => "meta_value_num",
      "order" => "DESC",
      "meta_query" => [
        [
          "key" => "event_date",
          "compare" => "<",
          "value" => $today,
          "type" => "numeric"
        ]
      ],
      "paged" => get_query_var( "paged", 1 )
    ]);

    while ( $past_events->have_posts() ) {
      $past_events->the_post();
      get_template_part( 'template-parts/content-event' );
    }
    echo paginate_links([
      "total" => $past_events->max_num_pages
    ]);
    wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
