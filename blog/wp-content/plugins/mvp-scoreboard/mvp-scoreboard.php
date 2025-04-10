<?php
/**
 * Plugin Name: MVP Themes Scoreboard
 * Plugin URI: http://themeforest.net/user/mvpthemes
 * Description: Creates a custom scoreboard for use with MVP Themes themes
 * Version: 1.0
 * Author: MVP Themes
 * Author URI: http://premium.wpmudev.org
 * License: GNU General Public License v3 or later
 */

add_action( 'wp_enqueue_scripts', 'mvp_scoreboard_script' );
function mvp_scoreboard_script() {
 	wp_enqueue_style( 'mvp-score-style', plugin_dir_url( __FILE__ ) . 'css/score-style.css' );
	wp_enqueue_script( 'mvp-score-script', plugin_dir_url( __FILE__ ) . 'js/score-script.js', array( 'jquery' ), '', true );
}


add_action( 'init', 'create_scores' );
function create_scores() {
	register_post_type( 'scoreboard',
		array(
			'labels' => array(
				'name' => __( 'Scores', 'mvp-text' ),
				'singular_name' => __( 'Score', 'mvp-text' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}

add_action( 'init', 'scores_init' );
function scores_init() {
	// create a new taxonomy
	register_taxonomy(
		'scores_cat',
		'scoreboard',
		array(
			'label' => __( 'Score Categories', 'mvp-text' ),
			'rewrite' => array( 'slug' => 'scores' ),
			'hierarchical' => true,
			'query_var' => true
		)
	);
}


$prefix = 'mvp_';

$meta_box = array(
    'id' => 'scores-box',
    'title' => 'Scores Info',
    'page' => 'scoreboard',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
		array(
            'name' => 'Score Status',
            'desc' => 'Enter score status (eg. "Fri 8:00pm" or "Final")',
            'id' => $prefix . 'status',
            'type' => 'text',
        ),
        array(
            'name' => 'Away Team Abbreviation',
            'desc' => 'Enter away team abbreviation (eg. "PHI")',
            'id' => $prefix . 'away_team',
            'type' => 'text',
        ),
        array(
            'name' => 'Home Team Abbreviation',
            'desc' => 'Enter home team abbreviation (eg. "PHI")',
            'id' => $prefix . 'home_team',
            'type' => 'text',
        ),
        array(
            'name' => 'Away Team Score',
            'desc' => 'Enter away team score (eg. "10")',
            'id' => $prefix . 'away_team_score',
            'type' => 'text',
	    'std' => ' 0'
        ),
	array(
            'name' => 'Home Team Score',
            'desc' => 'Enter home team score (eg. "10")',
            'id' => $prefix . 'home_team_score',
            'type' => 'text',
	    'std' => ' 0'
        ),
	array(
            'name' => 'Display Numerical Score?',
            'desc' => 'Check this box if you want to display the score',
            'id' => $prefix . 'show_score',
            'type' => 'checkbox'
        ),
	array(
            'name' => 'Link to post?',
            'desc' => 'Check this box if you want to the scoreboard item to link to the post',
            'id' => $prefix . 'link_post',
            'type' => 'checkbox'
        )
    )
);

add_action('admin_menu', 'scores_add_box');

// Add meta box
function scores_add_box() {
	global $meta_box;

	add_meta_box($meta_box['id'], $meta_box['title'], 'scores_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function scores_show_box() {
	global $meta_box, $post;

	// Use nonce for verification
	echo '<input type="hidden" name="scores_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<table class="form-table">';

	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);

		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '"><strong>', $field['name'], ':</strong></label></th>',
				'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
					'<br /><small>', $field['desc'],'</small>';
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
					'<br />', $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}
		echo 	'<td>',
			'</tr>';
	}

	echo '</table>';
}

add_action('save_post', 'scores_save_data');

// Save data from meta box
function scores_save_data($post_id) {
	global $meta_box;

	// verify nonce
	if ( !isset( $_POST['scores_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['scores_meta_box_nonce'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	foreach ($meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = isset( $_POST[$field['id']] ) ? $_POST[$field['id']] : '';

		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}