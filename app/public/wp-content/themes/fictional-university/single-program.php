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
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Programs
          </a> <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <div class="generic-content">
        <?php the_field('main_body_content');

        $related_campuses = get_field('related_campuses');
        if ( $related_campuses ) {
          echo '<hr class="section-break">';
          echo '<h5>' . get_the_title() . ' is Available At These Campuses</h5>';
          echo '<ul class="min-list link-list">';
          foreach ( $related_campuses as $campus ) { ?>
            <li>
              <a href="<?php echo get_the_permalink( $campus ); ?>">
                <?php echo get_the_title( $campus ); ?>
              </a>
            </li>
          <?php }
          echo '</ul>';
        }

        $related_professors = new WP_Query([
          'posts_per_page' => -1,
          'post_type' => 'professor',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => [
            [
              'key' => 'related_programs',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"'
            ]
          ]
        ]);

        if ( $related_professors->have_posts() ) {
          echo '<hr class="section-break" />';
          echo '<h5 class="headline headline--medium">' . get_the_title() . ' Professor(s)</h5><br />';
          echo '<ul class="professor-cards">';
          while ( $related_professors->have_posts() ) {
            $related_professors->the_post(); ?>
            <li class="professor-card__list-item">
              <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail_url( 'professor-landscape' ); ?>" alt="<?php echo get_the_post_thumbnail_caption(); ?>">
                <span class="professor-card__name"><?php the_title(); ?></span>
              </a>
            </li>
          <?php } wp_reset_postdata();
          echo '</ul>';
        }


        $today = date('Ymd');
        $related_events = new WP_Query([
          'posts_per_page' => -1,
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => [
            [
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            ],
            [
              'key' => 'related_programs',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"'
            ]
          ]
        ]);

        if ( $related_events->have_posts() ) {
          echo '<hr class="section-break" />';
          echo '<h5 class="headline headline--medium">Upcoming ' . get_the_title() . ' Event(s)</h5><br />';

          while ( $related_events->have_posts() ) {
            $related_events->the_post();
            get_template_part( 'template-parts/content-event' );
          } wp_reset_postdata();
        } ?>
      </div>
    </div>
  <?php } ?>
</main>

<?php get_footer(); ?>
