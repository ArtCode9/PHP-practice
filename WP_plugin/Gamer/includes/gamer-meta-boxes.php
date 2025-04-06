<?php
// Add meta boxes for gamer information
function add_gamer_meta_boxes() {
    add_meta_box(
        'gamer_id_meta_box',
        'Gamer ID',
        'render_gamer_id_meta_box',
        'gamer',
        'normal',
        'high'
    );

    add_meta_box(
        'games_meta_box',
        'Games',
        'render_games_meta_box',
        'gamer',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_gamer_meta_boxes');

// Render Gamer ID meta box
function render_gamer_id_meta_box($post) {
    wp_nonce_field('save_gamer_id', 'gamer_id_nonce');
    $gamer_id = get_post_meta($post->ID, '_gamer_id', true);
    ?>
    <p>
        <label for="gamer_id">Gamer ID:</label>
        <input type="text" id="gamer_id" name="gamer_id" value="<?php echo esc_attr($gamer_id); ?>" class="widefat">
    </p>
    <?php
}

// Render Games meta box
function render_games_meta_box($post) {
    wp_nonce_field('save_games', 'games_nonce');
    
    $selected_games = get_post_meta($post->ID, '_selected_games', true);
    if (!is_array($selected_games)) {
        $selected_games = array();
    }
    
    $other_game = get_post_meta($post->ID, '_other_game', true);
    
    $games = array('counter' => 'Counter-Strike', 'dota2' => 'Dota 2', 'fifa' => 'FIFA');
    ?>
    <div class="game-selection">
        <?php foreach ($games as $key => $game): ?>
            <p>
                <label>
                    <input type="checkbox" name="games[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $selected_games)); ?>>
                    <?php echo esc_html($game); ?>
                </label>
            </p>
        <?php endforeach; ?>
        
        <p>
            <label>
                <input type="checkbox" id="other_game_checkbox" name="other_game_checkbox" <?php checked(!empty($other_game)); ?>>
                Other Game
            </label>
            <input type="text" id="other_game" name="other_game" value="<?php echo esc_attr($other_game); ?>" class="widefat" <?php if (empty($other_game)) echo 'style="display:none;"'; ?>>
        </p>
    </div>
    <?php
}

// Save meta box data
function save_gamer_meta_data($post_id) {
    // Check nonce for gamer ID
    if (!isset($_POST['gamer_id_nonce']) || !wp_verify_nonce($_POST['gamer_id_nonce'], 'save_gamer_id')) {
        return;
    }
    
    // Check nonce for games
    if (!isset($_POST['games_nonce']) || !wp_verify_nonce($_POST['games_nonce'], 'save_games')) {
        return;
    }
    
    // Save gamer ID
    if (isset($_POST['gamer_id'])) {
        update_post_meta($post_id, '_gamer_id', sanitize_text_field($_POST['gamer_id']));
    }
    
    // Save selected games
    $selected_games = isset($_POST['games']) ? array_map('sanitize_text_field', $_POST['games']) : array();
    update_post_meta($post_id, '_selected_games', $selected_games);
    
    // Save other game
    $other_game = isset($_POST['other_game']) ? sanitize_text_field($_POST['other_game']) : '';
    update_post_meta($post_id, '_other_game', $other_game);
}
add_action('save_post_gamer', 'save_gamer_meta_data');