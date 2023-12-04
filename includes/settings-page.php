<?php
/*
Plugin Name: Speed Up WordPress
Description: Remove unused features to speed up your website.
Version: 1.0
Author: Your Name
*/

class SpeedUpWordPress {

    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_menu_page'));
    }

    public function register_settings() {
        register_setting('speed_up_wordpress_options', 'speed_up_wordpress_disable_emoji', 'intval');
        register_setting('speed_up_wordpress_options', 'speed_up_wordpress_disable_xmlrpc', 'intval');
        register_setting('speed_up_wordpress_options', 'speed_up_wordpress_enable_emoji', 'intval');
        register_setting('speed_up_wordpress_options', 'speed_up_wordpress_enable_xmlrpc', 'intval');
    }

    public function add_menu_page() {
        add_menu_page(
            'Speed Up WordPress',
            'Speed Up WordPress',
            'manage_options',
            'speed-up-wordpress-settings',
            array($this, 'render_settings_page'),
            'dashicons-admin-tools'
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h2>Speed Up WordPress - Remove Unused Features</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('speed_up_wordpress_options');
                do_settings_sections('speed-up-wordpress-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

// Instantiate the class
$speed_up_wordpress_plugin = new SpeedUpWordPress();
