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
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("event"); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Events
          </a> <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
      <div class="generic-content">
        <?php
          the_content();

          if ( get_field("related_programs") ) {
            $related_programs = get_field("related_programs");
            echo '
            <hr class="section-break" />
            <h5 class="headline headline--medium">Related Program(s)</h5>
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
