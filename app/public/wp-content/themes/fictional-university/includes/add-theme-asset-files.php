<?php
  function addThemeAssetFiles() {
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('main-stylesheet', get_stylesheet_uri());
    wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), array(), microtime(), true);
    wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?key=AIzaSyBrcqM_dJ9-1IIC7WIKbrhbqCklu2a-H5c', array(), '1.0', true);
    if (!is_admin() && get_post_type() === "campus") {
      wp_deregister_script('jquery');
      wp_enqueue_script('jquery-for-campus-map', '//code.jquery.com/jquery-3.4.1.min.js', array(), false, true);
      wp_enqueue_script('campus-map', get_theme_file_uri('/js/modules/CampusMap.js'), array('jquery-for-campus-map'), '1.0', true);
    }
    wp_localize_script('main-js', 'universityData', array(
      'siteUrl' => get_site_url(),
      'nonce' => wp_create_nonce('wp_rest')
    ));
  }

  add_action('wp_enqueue_scripts', 'addThemeAssetFiles');
?>
