<?php

/**
 * initializing the plugin
 * @param $class_name
 */
function schedule_class_loader($class_name)
{
    $class_file = schedule_DIR . 'classes/class.'
        . trim(strtolower(str_replace('\\', '_', $class_name)), '\\') . '.php';
    if (is_file($class_file)) {
        require_once $class_file;
    }
}

/**
 * To add the token to DB
 */
function schedule_addtoken()
{
    $token_value = $_POST['token_value'];
    if (get_option('user_token')) {
        update_option('user_token', $token_value);
        echo "updated";
    } else if (get_option('user_token') == "") {
        update_option('user_token', $token_value);
        echo "updated";
    } else {
        add_option('user_token', $token_value);
        echo "added";
    }
}

/**
 * Insert metabox into the post edit page
 */
function schedule_add_metabox_shortcode()
{
    global $settings_schedule;
    add_meta_box(
        'schedule_add_metabox_shortcode',
        $settings_schedule['shortcode']['short_code_label'],
        'schedule_metabox_shortcode_show',
        'post',
        'side',
        'default',
        'high'
    );
}


/**
 * Insert metabox into the page edit page
 */
function schedule_add_metabox_shortcode_page()
{
    global $settings_schedule;
    add_meta_box(
        'schedule_add_metabox_shortcode',
        $settings_schedule['shortcode']['short_code_label'],
        'schedule_metabox_shortcode_show',
        'page',
        'side',
        'default',
        'high'
    );
}

/**
 * @param $post
 * printing id in metabox
 */
function schedule_metabox_shortcode_show($post)
{
    echo "<b>Events</b>";
    echo "<br>(please select an event to display on post)";
    echo '<span id="id-schedule-selector"></span>';
    echo "<br><b>Agent Wise Events</b>";
    echo "<br>(please select an Agent to display Events)";
    echo '<span id="agent-selector"></span>';
    echo "<br><b>Workspace Events</b>";
    echo "<br>(please click on below button to show workspace)";
    echo '<br><span id="embed-selector"></span>';
}

/**
 * To Preview Single Event
 */
function schedule_preview_single_event($atts)
{
    $id            = $atts['id'];
    $jwtPayload    = schedule_extract_token();
    $token         = get_option('user_token');
    $user_id       = $jwtPayload->user_id;
    $region        = $jwtPayload->env;
    $tenant_id     = $jwtPayload->tenant_id;
    $single_event  = "https://my.$region.500apps.com/pcors?url=https://schedule.$region.500apps.com/v2/event_types?where=id=$id&limit=50";
    $request_url    = $single_event;
    $token          = $token;
    $headers        = array(
        'Content-type' => 'application/json',
        'Accept'    => 'text/plain',
        'token'     =>  $token
    );
    $args_get = array(
        'timeout'     => 10,
        'redirection' => 15,
        'httpversion' => '1.0',
        'sslverify'   => false,
        'blocking'    => true,
        'token'       =>  $token,
        'headers'     => $headers,
        'cookies'     => array(),
    );
    $request    = wp_remote_get($request_url, $args_get);
    $result     = wp_remote_retrieve_body($request);
    $json_array = json_decode($result);
    file_put_contents("cf7outputtest.txt", print_r($json_array, true));
    file_put_contents("cf7outputtest.txt", print_r($args_get, true));
    $schedule_append = "";
    foreach ($json_array as $html_res) {
        $schedule_append = '
        <input type="hidden" id="event_id" name="event_id" value="' . $html_res->id . '">
        <input type="hidden" id="domain_id" name="domain_id" value="' . $html_res->domain_id . '">
        <input type="hidden" id="domain_user_id" name="domain_user_id" value="' . $html_res->created_by . '">
        <div id="load_single_event" style="margin-left: 198px;max-width: 1500px;"></div>';
    }
    $schedule_append .= '<input type="hidden" id="region" name="region" value="' . $region . '">';
    return $schedule_append;
}
add_shortcode('Event', 'schedule_preview_single_event');

/**
 * To Preview Single agent events
 */
function schedule_preview_agent_events($atts)
{
    $id            = $atts['id'];
    $jwtPayload    = schedule_extract_token();
    $user_id       = $jwtPayload->user_id;
    $region        = $jwtPayload->env;
    $tenant_id     = $jwtPayload->tenant_id;
    $schedule_append   = '<input type="hidden" id="region" name="region" value="' . $region . '">
    <input type="hidden" id="domain_id" name="domain_id" value="' . $tenant_id . '">
    <input type="hidden" id="domain_user_id" name="domain_user_id" value="' . $id . '">
    <div id="load_event" style="margin-left: 198px;max-width: 1500px;"></div>';
    return $schedule_append;
}
add_shortcode('Agent', 'schedule_preview_agent_events');

/**
 * To Preview workspace
 */
function schedule_embed_events_preview($atts)
{
    $jwtPayload    = schedule_extract_token();
    $token         = "";
    $user_id       = $jwtPayload->user_id;
    $region        = $jwtPayload->env;
    $tenant_id     = $jwtPayload->tenant_id;
    $embed_events  = "https://api.$region.500apps.com/schedulely/v1/$tenant_id/$user_id?limit=50";
    $request_url    = $embed_events;
    $token          = $token;
    $headers        = array(
        'Content-type' => 'application/json',
        'Accept'    => 'text/plain',
        'token'     =>  $token
    );
    $args_get = array(
        'timeout'     => 10,
        'redirection' => 15,
        'httpversion' => '1.0',
        'sslverify'   => false,
        'blocking'    => true,
        'token'       =>  $token,
        'headers'     => $headers,
        'cookies'     => array(),
    );
    $request    = wp_remote_get($request_url, $args_get);
    $result     = wp_remote_retrieve_body($request);
    $json_array = json_decode($result);
    $schedule_append = '
    <input type="hidden" id="domain_id" name="domain_id" value="' . $tenant_id . '">
    <input type="hidden" id="region" name="region" value="' . $region . '">
    <div id="embed_events" style="margin-left: 198px;max-width: 1500px;"></div>';
    return $schedule_append;
}
add_shortcode('Events', 'schedule_embed_events_preview');

/** To extract the Token **/
function schedule_extract_token()
{
    $token         = get_option('user_token');
    $tokenParts    = explode(".", $token);
    $tokenHeader   = base64_decode($tokenParts[0]);
    $tokenPayload  = base64_decode($tokenParts[1]);
    $jwtHeader     = json_decode($tokenHeader);
    $jwtPayload    = json_decode($tokenPayload);
    return $jwtPayload;
}