<?php
/*
Plugin Name: Optimization Tools | ItnYou
Description: Optimization Tools can help you optimize your site for SEO and other purposes. Currently plugin can remove duplicates of the category page, to expand your Yoast SEO JSON LD of Organization (you can add contact phones / emails), remove type="text/script" or "text/css" from your site for a match to w3c standards
Author: Vladimir Shulika
Version: 0.1.0
Author URI: http://itnyou.top/
*/

function ItnYou_plugin_name($echo = 1)
{
    $plugin_name = 'Optimization Tools';

    if ($echo) {
        echo $plugin_name;
    } else {
        return $plugin_name;
    }
}

if (get_option('enable_404_on_not_exists_pagination')) {
    add_action('template_redirect', 'ItnYou_template_redirect', 0);
    function ItnYou_template_redirect()
    {
        if (is_singular()) {
            global $post, $page;
            $num_pages = substr_count($post->post_content, '<!--nextpage-->') + 1;
            if ($page > $num_pages) {
                if (file_exists(get_template_directory().'/404.php')) {
                    include get_template_directory().'/404.php';
                } else {
                    header('HTTP/1.0 404 Not Found');
                    die('Sorry, this page does not exists!');
                }
                exit;
            }
        }
    }
}

if (get_option('enable_yoast_organization_contacts')) {
    if (defined('WPSEO_FILE')) {
        add_filter('wpseo_json_ld_output', function ($data, $context) {
            if ($data['@type'] == 'Organization') {
                $phones = get_option('yoast_organization_phone');
                $emails = get_option('yoast_organization_email');

                if ($phones) {
                    $data['telephone'] = array(explode(',', $phones));
                }

                if ($emails) {
                    $data['email'] = array(explode(',', $emails));
                }
            }

            return $data;
        }, 10, 2);
    }
}

if (get_option('enable_removing_typetext')) {
    add_filter('style_loader_tag', 'ItnYou_remove_type_attr', 10, 2);
    add_filter('script_loader_tag', 'ItnYou_remove_type_attr', 10, 2);

    function ItnYou_remove_type_attr($tag, $handle)
    {
        return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
    }
}

if (get_option('enable_replacing_current_links')) {
    add_filter('walker_nav_menu_start_el', function ($item_output, $item, $depth, $args) {
        if ($item->current) {
            return '<span>'.$item->title.'</span>';
        } else {
            return $item_output;
        }
    }, 10, 4);
}

add_action('admin_menu', 'ItnYou_create_menu');

function ItnYou_create_menu()
{
    add_submenu_page('options-general.php', ItnYou_plugin_name(false), ItnYou_plugin_name(false), 'administrator', 'itnyou-toolset', 'ItnYou_settings_page');
    add_action('admin_init', 'register_ItnYou_settings');
}

function register_ItnYou_settings()
{
    register_setting('ItnYou-settings-group', 'enable_404_on_not_exists_pagination');
    register_setting('ItnYou-settings-group', 'enable_yoast_organization_contacts');
    register_setting('ItnYou-settings-group', 'yoast_organization_phone');
    register_setting('ItnYou-settings-group', 'yoast_organization_email');
    register_setting('ItnYou-settings-group', 'enable_removing_typetext');
    register_setting('ItnYou-settings-group', 'enable_replacing_current_links');
}

function ItnYou_settings_page()
{
    include 'template-parts/settings-form.php';
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_ItnYou_action_links' );

function add_ItnYou_action_links($links)
{
    $mylinks = array(
        '<a href="'.admin_url('options-general.php?page=itnyou-toolset').'">Settings</a>',
    );

    return array_merge($links, $mylinks);
}


