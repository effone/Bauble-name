<?php

/**
 * Bauble Name
 * 
 * @package MyBB Plugin
 * @author effone <effone@mybb.com>
 * @copyright 2018 MyBB Group <http://mybb.group>
 * @version 1.0.0
 * @license GPL-3.0
 * 
 */

if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.");
}

function baublename_info()
{
    return array(
        'name' => 'Bauble Name',
        'description' => 'Decorate usernames with group color / avatars.',
        'website' => 'https://github.com/mybbgroup/MyBB_Bauble-name',
        'author' => 'effone',
        'authorsite' => 'https://eff.one',
        'version' => '1.0.0',
        'compatibility' => '18*',
    );
}

$plugins->add_hook('global_end', 'welcome_polish');
$plugins->add_hook('index_end', 'index_polish');

function baublename_activate()
{
    global $db;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";
    find_replace_templatesets('header_welcomeblock_member', '#{\$lang->welcome_back}#', '<!-- start: header_welcome_back -->{\$lang->welcome_back}<!-- end: header_welcome_back -->');
    find_replace_templatesets('index_stats', '#{\$lang->stats_newestuser}#', '<!-- start: index_newestuser -->{\$lang->stats_newestuser}<!-- end: index_newestuser -->');

    $style = '.inline_avatar{height:16px; width:16px; display: inline-block; margin-right: 2px; margin-bottom: -2px; border-radius: 50%;}';
    $stylesheet = array(
        "name" => "avatar.css",
        "tid" => 1,
        "attachedto" => "",
        "stylesheet" => $db->escape_string($style),
        "cachefile" => "avatar.css",
        "lastmodified" => TIME_NOW,
    );

    $sid = $db->insert_query("themestylesheets", $stylesheet);

    require_once MYBB_ADMIN_DIR . '/inc/functions_themes.php';
    cache_stylesheet($stylesheet['tid'], $stylesheet['cachefile'], $style);
    update_theme_stylesheet_list(1, false, true);
}

function baublename_deactivate()
{
    global $db;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";
    $templates = array('header_welcomeblock_member', 'index_stats');
    foreach ($templates as $template) {
        find_replace_templatesets($template, '#<!--(.*?)-->#', '');
    }
    $db->delete_query('themestylesheets', "name='avatar.css'");
    $query = $db->simple_select('themes', 'tid');
    while ($theme = $db->fetch_array($query)) {
        require_once MYBB_ADMIN_DIR . 'inc/functions_themes.php';
        update_theme_stylesheet_list($theme['tid']);
    }
}

function welcome_polish()
{
    global $lang, $mybb, $header;
    if ((int) $mybb->user['uid']) {
        $lang->welcome_back = preg_replace('#(<a)[\s\S]+(<\/a>)#', format_user((int) $mybb->user['uid'], 0, 'inline_avatar'), $lang->welcome_back);
        $header = preg_replace('#(<!-- start: header_welcome_back)[\s\S]+(end: header_welcome_back -->)#', $lang->welcome_back, $header);
    }
}

function index_polish()
{
    global $lang, $stats, $boardstats;
    $lang->stats_newestuser = preg_replace('#(<a)[\s\S]+(<\/a>)#', format_user($stats['lastusername'], 1, 'inline_avatar'), $lang->stats_newestuser);
    $boardstats = preg_replace('#(<!-- start: index_newestuser)[\s\S]+(end: index_newestuser -->)#', $lang->stats_newestuser, $boardstats);
}

function format_user($data, $name = 0, $avatar = '')
{
    if (empty($data)) {
        return;
    }
    $default = true;
    $user = ($name) ? get_user_by_username($data, ['fields' => ['username', 'usergroup', 'displaygroup', 'avatar']]) : get_user((int) $data);
    if (empty($user['avatar'])) {
        if ($default) {
            global $mybb, $theme;
            $user['avatar'] = str_replace('{theme}', $theme['imgdir'], $mybb->settings['useravatar']);
        } else {
            $avatar = '';
        }
    }
    if (!empty($avatar)) {
        $avatar = '<img class="' . $avatar . '" src="' . $user['avatar'] . '" />';
    }

    $user = build_profile_link(format_name($avatar . htmlspecialchars_uni($user['username']), $user['usergroup'], $user['displaygroup']), $user['uid']);

    return $user;
}