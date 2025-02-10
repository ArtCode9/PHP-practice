<?php
/* 
Plugin Name: filter-words
Plugin URI:  https://example.com
Description: a simple plugin for filter words in WP content.
Author: art code
Author URI: https://example.com
Text Domain: wordsFilter
Domain Path: /languages/
Version: 2.0.0
*/

define('WF_DIR', plugin_dir_path(__FILE__));
define('WF_URL', plugin_dir_url(__FILE__));
define('WF_INC', WF_DIR.'/inc/');


function wf_filter_words($content){

   $word = 'post';

   $replace = 'POoooST wp';

   $content =  preg_replace("/{$word}/", $replace, $content); 

   return $content;
};

function wf_filter_pars($x_x){
   $parse = 'really';
   $replace = 'In Fact';

   $x_x = preg_replace("/{$parse}/", $replace, $x_x);

   return $x_x;
};

function wf_filter_words2($Z_Z){
   $word = 'WP';
   $replace = '<a href="#">Links Google</a>'; 
   
   $Z_Z =  preg_replace("/{$word}/", $replace, $Z_Z); 

   return $Z_Z;
};

function wf_filter_words3($Z_Z){
   $word = 'first';
   $replace = 'wp'; 

   $wordLength = mb_strlen($word); // give us the length of the word

   $Z_Z =  preg_replace("/{$word}/", str_repeat('$', $wordLength), $Z_Z); 

   return $Z_Z;
};


add_filter('the_content', 'wf_filter_words');
add_filter('the_content', 'wf_filter_words2');
add_filter('the_content', 'wf_filter_words3');
add_filter('the_content', 'wf_filter_pars');
