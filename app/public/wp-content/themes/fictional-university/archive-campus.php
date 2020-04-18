<?php
  get_header();
  setPageBanner( array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
  )); ?>

<div class="container container--narrow page-section">
  <div class="acf-map">
  <?php
    while ( have_posts() ) {
      the_post();
      $campus_location = get_field('map_location');

      if ( !empty( $campus_location ) ) { ?>
      <div class="marker"
           data-lat="<?php echo esc_attr( $campus_location['lat'] ); ?>"
           data-lng="<?php echo esc_attr( $campus_location['lng'] ); ?>">
           <h3 style="margin: 0 0 5px;">
             <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
           </h3>
           <p><?php echo esc_attr( $campus_location['address'] ); ?></p>
      </div>
  <?php } } ?>
  </div>
</div>

<?php get_footer(); ?>
