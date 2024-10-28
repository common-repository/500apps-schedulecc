<?php
/*
Plugin Name: 500apps-schedulecc
Plugin URI: https://schedule.cc/
Author: 500apps
Author URI: 500apps.com/
Version: 0.2
Description: Appointment Scheduling Software, Grow your business and boost efficiency while saving time for you and your clients.
 */

define('schedulefile_root', __FILE__);
define('schedule_DIR', plugin_dir_path(__FILE__));

require __DIR__ . '/schedule_functions.php';
spl_autoload_register('schedule_class_loader');

/**
 * Parse configuration
 */
$settings_schedule = parse_ini_file(__DIR__ . '/schedule_settings.ini', true);
add_action('plugins_loaded', array(\scheduleAPP\AdminSchedule::$class, 'init'));

add_action('admin_menu', 'schedule_add_metabox_shortcode');
add_action('admin_menu', 'schedule_add_metabox_shortcode_page');

add_action('wp_enqueue_scripts', 'schedule_stylesheet');
add_action('admin_enqueue_scripts', 'schedule_stylesheet');
function schedule_stylesheet() 
{
    wp_enqueue_style( 'schedule_CSS', plugins_url( '/schedule.css', __FILE__ ) );
}

function schedule_scripts(){
    wp_register_script('schedule_script', plugins_url('/js/schedule_admin.js', schedulefile_root), array('jquery'),time(),true);
    wp_enqueue_script('schedule_script');
}    

add_action('wp_enqueue_scripts', 'schedule_scripts');
add_action('admin_enqueue_scripts', 'schedule_scripts');

add_action('wp_ajax_schedule_addtoken', 'schedule_addtoken');