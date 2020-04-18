<?php
  get_header();
  setPageBanner(); ?>

<main>
<?php
  while ( have_posts() ) {
    the_post(); ?>
    <div class="container container--narrow page-section">
      <div class="generic-content">
        <div class="row group">
          <div class="one-third">
            <?php the_post_thumbnail( 'professor-portrait' ); ?>
          </div>
          <div class="two-thirds">
            <?php
              $liked_by_the_user = 'no';

              $professor_likes_count = new WP_Query(array(
                'post_type' => 'like',
                'meta_query' => array(
                  array(
                    'key' => 'liked_professor_id',
                    'value' => get_the_ID(),
                    'compare' => '='
                  )
                )
              ));

              if (is_user_logged_in()) {
                $user_likes_professor = new WP_Query(array(
                  'author' => get_current_user_id(),
                  'post_type' => 'like',
                  'meta_query' => array(
                    array(
                      'key' => 'liked_professor_id',
                      'value' => get_the_ID(),
                      'compare' => '='
                    )
                  )
                ));
                $liked_by_the_user = $user_likes_professor->found_posts ? 'yes' : 'no';
              }
            ?>
            <span class="like-box"
                  data-id="<?php the_ID(); ?>"
                  data-title="<?php the_title(); ?>"
                  data-like="<?php echo $user_likes_professor->posts[0]->ID; ?>"
                  data-exists="<?php echo $liked_by_the_user; ?>">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
              <i class="fa fa-heart" aria-hidden="true"></i>
              <span class="like-count"><?php echo $professor_likes_count->found_posts; ?></span>
            </span>
            <?php the_content(); ?>
          </div>
        </div>
        <?php
          if (get_field("related_programs") ) {
            $related_programs = get_field("related_programs");
            echo '
            <hr class="section-break" />
            <h5 class="headline headline--medium">Subject(s) Taught</h5>
            <ul class="link-list min-list">';
            foreach ( $related_programs as $program ) { ?>
              <li>
                <a href="<?php echo get_the_permalink( $program ); ?>">
                  <?php echo get_the_title( $program ); ?>
                </a>
              </li>
            <?php }
            echo '</ul>';
          } ?>
      </div>
    </div>
  <?php } ?>
</main>

<?php get_footer(); ?>
