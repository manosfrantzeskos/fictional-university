<?php
  if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('')));
    exit;
  }
  get_header();
  setPageBanner( array(
    'subtitle' => 'Learn how the school of your dreams got started.'
  )); ?>

<main>
<?php
  while (have_posts()) {
    the_post();
    $user_notes = new WP_Query(array(
      'post_type' => 'note',
      'post_per_page' => -1,
      'author' => get_current_user_id()
    )); ?>
    <div class="container container--narrow page-section">

      <div class="create-note">
        <h2 class="headline headline--medium">Create New Note</h2>
        <input class="new-note-title" placeholder="Title">
        <textarea class="new-note-body" placeholder="Your note here..."></textarea>
        <button class="submit-note">Create Note</button>
        <span class="note-limit-message">Note limit reached: delete an existing note to make room for a new one.</span>
      </div>

      <ul class="min-list link-list" id="myNotes">
        <?php
          while ($user_notes->have_posts()) {
            $user_notes->the_post(); ?>
            <li data-id="<?php the_ID(); ?>">
              <input class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>" readonly>
              <span class="edit-note">
                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
              </span>
              <span class="delete-note">
                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
              </span>
              <textarea class="note-body-field" readonly><?php echo esc_textarea(get_the_content()); ?></textarea>
              <span class="update-note btn btn--blue btn--small">
                <i class="fa fa-arrow-right" aria-hidden="true"></i> Save
              </span>
            </li>
          <?php } ?>
      </ul>
    </div>
  <?php } ?>
</main>

<?php get_footer(); ?>
