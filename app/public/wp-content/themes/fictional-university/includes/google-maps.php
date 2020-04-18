<?php
  function setGoogleMapsApiKey($api) {
    $api['key'] = 'AIzaSyBrcqM_dJ9-1IIC7WIKbrhbqCklu2a-H5c';
    return $api;
  }

  add_filter('acf/fields/google_map/api', 'setGoogleMapsApiKey');
?>
