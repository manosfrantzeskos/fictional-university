<?php
  add_action('rest_api_init', 'createSearchRoute');


  function createSearchRoute() {
    register_rest_field('post', 'author_name', array(
      'get_callback' => function() {
        return get_the_author();
      }
    ));

    register_rest_field('note', 'note_count', array(
      'get_callback' => function() {
        return count_user_posts(get_current_user_id(), 'note');
      }
    ));

    register_rest_route('university/v1', 'search', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'getSearchResults',
    ));
  }


  function getSearchResults( $metadata ) {
    $search_query = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
      's' => sanitize_text_field($metadata['term'])
    ));

    $search_results = array(
      'general' => array(),
      'professors' => array(),
      'programs' => array(),
      'campuses' => array(),
      'events' => array()
    );

    while ($search_query->have_posts()) {
      $search_query->the_post();
      $post_type = get_post_type();

      if ($post_type === 'post' || $post_type === 'page') {
        array_push($search_results['general'], array(
          'post_type' => $post_type,
          'title' => get_the_title(),
          'url' => get_the_permalink(),
          'author_name' => get_the_author()
        ));
      }
      elseif ($post_type === 'professor') {
        array_push($search_results['professors'], array(
          'title' => get_the_title(),
          'url' => get_the_permalink(),
          'thumbnail' => get_the_post_thumbnail_url(null, 'professor-landscape'),
          'thumbnail_caption' => get_the_post_thumbnail_caption()
        ));
      }
      elseif ($post_type === 'program') {
        array_push($search_results['programs'], array(
          'id' => get_the_ID(),
          'title' => get_the_title(),
          'url' => get_the_permalink()
        ));

        $related_campuses = get_field('related_campuses');

        foreach ($related_campuses as $campus) {
          array_push($search_results['campuses'], array(
            'title' => get_the_title($campus),
            'url' => get_the_permalink($campus)
          ));
        }
      }
      elseif ($post_type === 'campus') {
        array_push($search_results['campuses'], array(
          'title' => get_the_title(),
          'url' => get_the_permalink()
        ));
      }
      elseif ($post_type === 'event') {
        $event_date = DateTime::createFromFormat('d/m/Y', get_field('event_date'));

        array_push($search_results['events'], array(
          'title' => get_the_title(),
          'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_excerpt(), 15 ),
          'url' => get_the_permalink(),
          'month' => $event_date->format('M'),
          'day' => $event_date->format('d')
        ));
      }
    }
    // ----------
    if ( $search_results['programs'] ) {
      $other_program_related_posts_meta = array('relation' => 'OR');

      foreach ($search_results['programs'] as $program) {
        array_push($other_program_related_posts_meta, array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . $program['id'] . '"'
        ));
      }

      $other_program_related_posts = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => array('professor', 'event'),
        'meta_query' => $other_program_related_posts_meta
      ));


      while ($other_program_related_posts->have_posts()) {
        $other_program_related_posts->the_post();
        $post_type = get_post_type();

        if ($post_type === 'professor') {
          array_push($search_results['professors'], array(
            'title' => get_the_title(),
            'url' => get_the_permalink(),
            'thumbnail' => get_the_post_thumbnail_url(null, 'professor-landscape'),
            'thumbnail_caption' => get_the_post_thumbnail_caption(),
          ));
        }
        elseif ($post_type === 'event') {
          $event_date = DateTime::createFromFormat('d/m/Y', get_field('event_date'));
          array_push($search_results['events'], array(
            'title' => get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_excerpt(), 15 ),
            'url' => get_the_permalink(),
            'month' => $event_date->format('M'),
            'day' => $event_date->format('d')
          ));
        }
      }

      $search_results['professors'] = array_values(array_unique($search_results['professors'], SORT_REGULAR));
      $search_results['events'] = array_values(array_unique($search_results['events'], SORT_REGULAR));
    }
    // ----------
    return $search_results;
  }
?>
