<?php
  get_header();

  if ( is_category() ) {
    $page_banner_title = single_cat_title( '', false );
  }
  else if ( is_author() ) {
    $page_banner_title = "Posts by " . get_the_author_meta( "display_name" );
  }

  setPageBanner( array(
    'title' => $page_banner_title,
    'subtitle' => get_the_archive_description()
  )); ?>

<div class="container container--narrow page-section">
  <?php
    while ( have_posts() ) {
      the_post(); ?>
      <div class="post-item">
        <h2 class="headline headline--medium headline--post-title">
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h2>

        <div class="metabox">
          <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time( "n.j.y" ); ?> in <?php echo get_the_category_list( ", " ); ?></p>
        </div>

        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a href="<?php the_permalink(); ?>" class="btn btn--blue">Continue reading &raquo;</a></p>
        </div>
      </div>
  <?php } echo paginate_links(); ?>
</div>

<?php get_footer(); ?>
