<?php
  get_header();
  setPageBanner( array(
    'title' => 'Events',
    'subtitle' => 'See what is going on in our world.'
  ));
?>

<div class="container container--narrow page-section">
  <?php
  while ( have_posts() ) {
    the_post();
    get_template_part( 'template-parts/content-event' );
  } echo paginate_links(); wp_reset_postdata(); ?>
  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="<?php echo site_url( get_post(63)->post_name ); ?>">Check out our archive</a>.</p>
</div>

<?php get_footer(); ?>
