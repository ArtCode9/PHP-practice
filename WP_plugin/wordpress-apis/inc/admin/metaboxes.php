<?php
function wp_apis_price_meta_box_handler(){

};

function wp_apis_add_price_meta_box($post_type, $post){

   add_meta_box(
      'wp-apis-price-meta-box',
      'price content:)',
      'wp_apis_price_meta_box_handler',
      'post',
      'normal',
      'default'
   );

   
};

add_action('add_meta_boxes', 'wp_apis_add_price_meta_box',10 , 2);



?>