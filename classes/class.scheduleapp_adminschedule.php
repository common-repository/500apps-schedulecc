<?php
namespace scheduleapp;
class AdminSchedule
{
    public static $class = __CLASS__;
    /**
     * @param $action_id
     */
    public static function appContent($action_id){
        global $settings_schedule;
        if ($action_id == 'Events') {
            $scheduledata = $settings_schedule['wp']['Events'];
            include 'schedule_content.php';
        }
    }
    public static function action_1(){
        self::appContent('Events');
    }
    public static function action_2(){
        self::appContent('Other');
    }
    public static function init()
    {
        add_action('admin_menu', array(__CLASS__, 'register_menu_schedule'),10,0);
    }
    public static function register_menu_schedule()
    {
        global $settings_schedule;
        add_menu_page($settings_schedule['menus']['menu'], $settings_schedule['menus']['menu'], 'manage_options', __FILE__, array(__CLASS__, 'action_1'),plugin_dir_url( __FILE__ ) . 'images/schedule-symbol.png');
        add_submenu_page(__FILE__, $settings_schedule['menus']['sub_menu_title_4'], $settings_schedule['menus']['sub_menu_title_4'], 'manage_options', $settings_schedule['menus']['sub_menu_url_4'], array(__CLASS__, 'action_2'));
    }
}