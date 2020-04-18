<?php
  get_header();
  setPageBanner(); ?>

<main>
<?php
  while ( have_posts() ) {
    the_post(); ?>
    <div class="container container--narrow page-section">
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Campuses
          </a> <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <div class="generic-content">
      <?php
        the_content();
        $related_programs = new WP_Query([
          'posts_per_page' => -1,
          'post_type' => 'program',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => [
            [
              'key' => 'related_campuses',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"'
            ]
          ]
        ]);

        if ( $related_programs->have_posts() ) {
          echo '<hr class="section-break" />';
          echo '<h5 class="headline headline--medium">Programs Available</h5><br />';
          echo '<ul class="min-list link-list">';
          while ( $related_programs->have_posts() ) {
            $related_programs->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </li>
          <?php } wp_reset_postdata();
          echo '</ul>';
        } ?>
      </div>
      <hr class="section-break">
      <div class="acf-map">
      <?php
          $campus_location = get_field('map_location');

          if ( !empty( $campus_location ) ) { ?>
          <div class="marker"
               data-lat="<?php echo esc_attr( $campus_location['lat'] ); ?>"
               data-lng="<?php echo esc_attr( $campus_location['lng'] ); ?>">
               <h3 style="margin: 0 0 5px;">
                 <?php the_title(); ?>
               </h3>
               <p><?php echo esc_attr( $campus_location['address'] ); ?></p>
          </div>
      <?php } wp_reset_postdata(); ?>
      </div>
    </div>
  <?php } ?>
</main>

<?php get_footer(); ?>
