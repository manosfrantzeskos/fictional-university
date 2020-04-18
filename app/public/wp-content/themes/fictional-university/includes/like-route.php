<?php
  add_action('rest_api_init', 'createLikeRoute');

  function createLikeRoute() {
    register_rest_route('university/v1', 'like', array(
      'methods' => WP_REST_Server::EDITABLE,
      'callback' => 'createLike',
    ));

    register_rest_route('university/v1', 'like', array(
      'methods' => WP_REST_Server::DELETABLE,
      'callback' => 'deleteLike',
    ));
  }

  function createLike($data) {
    if (is_user_logged_in()) {
      $professorID = sanitize_text_field($data['professorID']);
      $professorTitle = sanitize_text_field($data['professorTitle']);

      $professor_liked_by_the_user = new WP_Query(array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_professor_id',
            'value' => $professorID,
            'compare' => '='
          )
        )
      ));

      if (!$professor_liked_by_the_user->found_posts && get_post_type($professorID) == 'professor') {
        return wp_insert_post(array(
          'post_type' => 'like',
          'post_title' => $professorTitle,
          'post_status' => 'publish',
          'meta_input' => array(
            'liked_professor_id' => $professorID
          )
        ));
      }
      else {
        die('Invalid professor ID');
      }
    }
    else {
      die('Only logged in users can like a professor.');
    }
  }

  function deleteLike($data) {
    $likeID = sanitize_text_field($data['likeID']);

    if (get_current_user_id() == get_post_field('post_author', $likeID) && get_post_type($likeID) == 'like') {
      wp_delete_post($likeID, true);
      return 'Like deleted successfully';
    }
    else {
      die('You do not have permission to delete that.');
    }
  }

?>
