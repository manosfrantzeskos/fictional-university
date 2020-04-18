<?php
  get_header();
  setPageBanner( array(
    'subtitle' => 'Learn how the school of your dreams got started.'
  )); ?>

<main>
<?php
  while ( have_posts() ) {
    the_post(); ?>

    <div class="container container--narrow page-section">
      <?php
        $parent_page_ID    = wp_get_post_parent_id( get_the_ID() );
        $parent_page_title = get_the_title( $parent_page_ID );
        $parent_page_url   = get_permalink( $parent_page_ID );

        if ( $parent_page_ID ) { ?>
          <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
              <a class="metabox__blog-home-link" href="<?php echo $parent_page_url; ?>">
                <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo $parent_page_title; ?>
              </a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
          </div>
      <?php } ?>

      <?php
        $page_has_children = get_pages([
          "child_of" => get_the_ID()
        ]);

        if ( $parent_page_ID || $page_has_children ) { ?>
          <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo $parent_page_url; ?>"><?php echo $parent_page_title; ?></a></h2>
            <ul class="min-list">
              <?php
                $findChildrenOf = ( $parent_page_ID ) ? $parent_page_ID : get_the_ID();

                wp_list_pages([
                  "title_li" => NULL,
                  "child_of" => $findChildrenOf
                ]);
               ?>
            </ul>
          </div>
      <?php } ?>

      <div class="generic-content">
        <?php get_search_form(); ?>
      </div>

    </div>
  <?php } ?>
</main>

<?php get_footer(); ?>
