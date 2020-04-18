<?php
  function addCustomPostTypes() {
    register_post_type( "event", [
      "capability_type" => "event",
      "map_meta_cap" => true,
      "has_archive" => true,
      "rewrite" => [ "slug" => "events" ],
      "public" => true,
      "labels" => [
        "name" => "Events",
        "add_new_item" => "Add New Event",
        "edit_item" => "Edit Event",
        "all_items" => "All Events",
        "singular_name" => "Event"
      ],
      "menu_icon" => "dashicons-calendar-alt",
      "supports" => [ "title", "editor", "excerpt" ]
    ]);

    register_post_type( "program", [
  	  "has_archive" => true,
      "rewrite" => [ "slug" => "programs" ],
      "public" => true,
      "labels" => [
        "name" => "Programs",
        "add_new_item" => "Add New Program",
        "edit_item" => "Edit Program",
        "all_items" => "All Programs",
        "singular_name" => "Program"
      ],
      "menu_icon" => "dashicons-awards",
      "supports" => [ "title" ]
    ]);

    register_post_type( "professor", [
      "public" => true,
      "labels" => [
        "name" => "Professors",
        "add_new_item" => "Add New Professor",
        "edit_item" => "Edit Professor",
        "all_items" => "All Professors",
        "singular_name" => "Professor"
      ],
      "menu_icon" => "dashicons-welcome-learn-more",
      "supports" => [ "title", "editor", "thumbnail" ],
    ]);

    register_post_type( "campus", [
      "capability_type" => "campus",
      "map_meta_cap" => true,
  	  "has_archive" => true,
      "rewrite" => [ "slug" => "campuses" ],
      "public" => true,
      "labels" => [
        "name" => "Campuses",
        "add_new_item" => "Add New Campus",
        "edit_item" => "Edit Campus",
        "all_items" => "All Campuses",
        "singular_name" => "Campus"
      ],
      "menu_icon" => "dashicons-location-alt",
      "supports" => [ "title", "editor", "excerpt" ]
    ]);

    register_post_type( "note", [
      "public" => false, // we want our notes to be private and specific to each user account
      "show_ui" => true, // make post type visible in the admin (we need it because we set "public" => false)
      "show_in_rest" => true,
      "capability_type" => "note",
      "map_meta_cap" => true,
      "labels" => [
        "name" => "Notes",
        "add_new_item" => "Add New Note",
        "edit_item" => "Edit Note",
        "all_items" => "All Notes",
        "singular_name" => "Note"
      ],
      "menu_icon" => "dashicons-welcome-write-blog",
      "supports" => [ "title", "editor" ],
    ]);

    register_post_type( "like", [
      "public" => false, // we want our likes to be private and specific to each user account
      "show_ui" => true, // make post type visible in the admin (we need it because we set "public" => false)
      "labels" => [
        "name" => "Likes",
        "add_new_item" => "Add New Like",
        "edit_item" => "Edit Like",
        "all_items" => "All Likes",
        "singular_name" => "Like"
      ],
      "menu_icon" => "dashicons-heart",
      "supports" => [ "title" ],
    ]);

  }

  add_action( "init", "addCustomPostTypes" );
?>
