<?php
function wp_apis_price_meta_box_handler($post){

      $post_price = get_post_meta($post->ID, 'wp_apis_price', true);

      ?>
         <input type="text" name="wp_apis_post_price" value="<?php echo $post_price; ?>">
      <?php
};

function wp_apis_add_price_meta_box($post_type, $post){

   // this function can register a metabox for us
   add_meta_box(
      'wp-apis-price-meta-box',
      'price content:)',
      'wp_apis_price_meta_box_handler',
      'post',
      'normal',
      'default'
   );   
};

function wp_apis_save_price_meta_box($post_id){
      // here we can receive data come from form 
      if(isset($_POST['wp_apis_post_price']))
      {
          update_post_meta($post_id, 'wp_apis_price', $_POST['wp_apis_post_price']);
          // add_post_meta
          // delete_post_meta
      }
};

add_action('add_meta_boxes', 'wp_apis_add_price_meta_box',10 , 2);

add_action('save_post', 'wp_apis_save_price_meta_box');
?>

<!--
 we can show this wp_apis_price  at the end of the post in theme ( content-single.php )
but i can not find it in my theme file   
-->