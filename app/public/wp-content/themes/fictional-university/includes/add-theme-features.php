<?php
  function addThemeFeatures() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('page-banner', 1500, 350, true);
    add_image_size('professor-landscape', 400, 280, true);
    add_image_size('professor-portrait', 350, 450, true);
  }

  add_action('after_setup_theme', 'addThemeFeatures');
?>
