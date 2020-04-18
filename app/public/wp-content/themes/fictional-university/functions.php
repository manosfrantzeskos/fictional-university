<?php
  require get_theme_file_path('includes/add-theme-asset-files.php');
  require get_theme_file_path('includes/add-theme-features.php');
  require get_theme_file_path('includes/search-route.php');
  require get_theme_file_path('includes/like-route.php');
  require get_theme_file_path('includes/archive-title.php');
  require get_theme_file_path('includes/google-maps.php');
  require get_theme_file_path('includes/adjust-default-queries.php');
  require get_theme_file_path('includes/page-banner.php');

  // Redirect subscriver accounts out of admin and onto homepage
  function redirectSubsToHomepage() {
    if (is_user_logged_in()) {
      $currentUser = wp_get_current_user();

      if (count($currentUser->roles) === 1 && $currentUser->roles[0] === 'subscriber') {
        wp_redirect(site_url());
        exit;
      }
    }
  }

  add_action('admin_init', 'redirectSubsToHomepage');


  function hideAdminBarForSubs() {
    if (is_user_logged_in()) {
      $currentUser = wp_get_current_user();

      if (count($currentUser->roles) === 1 && $currentUser->roles[0] === 'subscriber') {
        show_admin_bar(false);
      }
    }
  }

  add_action('wp_loaded', 'hideAdminBarForSubs');

  //Customize Login Screen
  function changeLoginTitleUrl() {
    return esc_url(site_url());
  }

  add_filter('login_headerurl', 'changeLoginTitleUrl');


  function addLoginAssetFiles() {
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('main-stylesheet', get_stylesheet_uri());
  }

  add_action('login_enqueue_scripts', 'addLoginAssetFiles');


  function changeLoginTitle() {
    return get_bloginfo('name');
  }

  add_filter('login_headertitle', 'changeLoginTitle');


  function makeNotePrivate($data, $postarr) {
    if ($data['post_type'] === 'note') {
      if (count_user_posts(get_current_user_id(), 'note') > 4 && !$postarr['ID']) {
        die('Note limit reached');
      }

      $data['post_title'] = sanitize_text_field($data['post_title']);
      $data['post_content'] = sanitize_textarea_field($data['post_content']);
    }

    if ($data['post_type'] === 'note' && $data['post_status'] !== 'trash') {
      $data['post_status'] = 'private';
    }
    return $data;
  }

  add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

?>
