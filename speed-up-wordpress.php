<?php
/*
Plugin Name: Speed Up WordPress
Description: A plugin to disable specific WordPress features through a GUI in the admin panel.
Version: 1.0
Author: Your Name
*/

// Check if a feature is disabled
function is_feature_disabled($feature) {
    return get_option($feature) == 'yes';
}

// Disabling the emojis
function disable_wp_emojis() {
    if (is_feature_disabled('disable_emojis')) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles'); 
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');  
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
}
add_action('init', 'disable_wp_emojis');

// Disabling the embeds
function disable_wp_embeds() {
    if (is_feature_disabled('disable_embeds')) {
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }
}
add_action('init', 'disable_wp_embeds');

// Disabling the XML-RPC
function disable_wp_xmlrpc() {
    if (is_feature_disabled('disable_xmlrpc')) {
        add_filter('xmlrpc_enabled', '__return_false');
    }
}
add_action('init', 'disable_wp_xmlrpc');

// Creating the GUI in the admin panel
function speedup_wordpress_menu() {
    add_menu_page('Speed Up WordPress', 'Speed Up WordPress', 'manage_options', 'speed-up-wordpress', 'speedup_wordpress_options');
}
add_action('admin_menu', 'speedup_wordpress_menu');

function speedup_wordpress_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    if (isset($_POST['disable_emojis'])) {
        update_option('disable_emojis', $_POST['disable_emojis']);
    }
    if (isset($_POST['disable_embeds'])) {
        update_option('disable_embeds', $_POST['disable_embeds']);
    }
    if (isset($_POST['disable_xmlrpc'])) {
        update_option('disable_xmlrpc', $_POST['dgitisable_xmlrpc']);
    }
    echo '<div class="wrap">';
    echo '<form method="post" action="">';
    echo '<h2>Disable Emojis</h2>';
    echo '<p>Emojis are small digital images or icons used to express an idea or emotion. While they can make your content more engaging, they also add extra HTTP requests and slow down your site. If you don\'t use them, it\'s better to disable them. You can read more about WordPress emojis on the <a href="https://codex.wordpress.org/Emoji" target="_blank">official WordPress documentation</a>.</p>';
    echo '<label for="disable_emojis">Disable Emojis</label>';
    echo '<select name="disable_emojis" id="disable_emojis">';
    echo '<option value="no"' . (is_feature_disabled('disable_emojis') ? '' : ' selected') . '>No</option>';
    echo '<option value="yes"' . (is_feature_disabled('disable_emojis') ? ' selected' : '') . '>Yes</option>';
    echo '</select>';
    echo '<h2>Disable Embeds</h2>';
    echo '<p>Embeds allow you to embed videos, images, tweets, audio, and other content from external sources in your WordPress site. This feature adds extra HTTP requests and can slow down your site. If you don\'t use it, it\'s better to disable it. You can read more about WordPress embeds on the <a href="https://codex.wordpress.org/Embeds" target="_blank">official WordPress documentation</a>.</p>';
    echo '<label for="disable_embeds">Disable Embeds</label>';
    echo '<select name="disable_embeds" id="disable_embeds">';
    echo '<option value="no"' . (is_feature_disabled('disable_embeds') ? '' : ' selected') . '>No</option>';
    echo '<option value="yes"' . (is_feature_disabled('disable_embeds') ? ' selected' : '') . '>Yes</option>';
    echo '</select>';
    echo '<h2>Disable XML-RPC</h2>';
    echo '<p>XML-RPC is a feature that allows remote connections to your WordPress site. Some plugins and apps use it to provide services, but it can also be a security risk and slow down your site. If you don\'t use it, it\'s better to disable it. You can read more about WordPress XML-RPC on the <a href="https://codex.wordpress.org/XML-RPC" target="_blank">official WordPress documentation</a>.</p>';
    echo '<label for="disable_xmlrpc">Disable XML-RPC</label>';
    echo '<select name="disable_xmlrpc" id="disable_xmlrpc">';
    echo '<option value="no"' . (is_feature_disabled('disable_xmlrpc') ? '' : ' selected') . '>No</option>';
    echo '<option value="yes"' . (is_feature_disabled('disable_xmlrpc') ? ' selected' : '') . '>Yes</option>';
    echo '</select>';
    echo '<input type="submit" value="Save">';
    echo '</form>';
    echo '</div>';
}
?>
