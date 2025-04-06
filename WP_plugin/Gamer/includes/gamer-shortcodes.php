<?php
// Shortcode to display gamers
function gamer_list_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => -1
    ), $atts);
    
    $args = array(
        'post_type' => 'gamer',
        'posts_per_page' => $atts['count'],
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    $gamers = new WP_Query($args);
    
    if (!$gamers->have_posts()) {
        return '<p>No gamers found.</p>';
    }
    
    $output = '<div class="gamers-list">';
    
    while ($gamers->have_posts()) {
        $gamers->the_post();
        $gamer_id = get_post_meta(get_the_ID(), '_gamer_id', true);
        $selected_games = get_post_meta(get_the_ID(), '_selected_games', true);
        $other_game = get_post_meta(get_the_ID(), '_other_game', true);
        
        $games = array(
            'counter' => 'Counter-Strike',
            'dota2' => 'Dota 2',
            'fifa' => 'FIFA'
        );
        
        $game_list = array();
        if (is_array($selected_games)) {
            foreach ($selected_games as $game) {
                if (isset($games[$game])) {
                    $game_list[] = $games[$game];
                }
            }
        }
        
        if (!empty($other_game)) {
            $game_list[] = $other_game;
        }
        
        $output .= '<div class="gamer-item">';
        $output .= '<h3>' . get_the_title() . '</h3>';
        $output .= '<p><strong>Gamer ID:</strong> ' . esc_html($gamer_id) . '</p>';
        $output .= '<p><strong>Games:</strong> ' . implode(', ', $game_list) . '</p>';
        $output .= '</div>';
    }
    
    wp_reset_postdata();
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('gamers_list', 'gamer_list_shortcode');