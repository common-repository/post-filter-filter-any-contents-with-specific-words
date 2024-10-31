<?php
/**
 * Plugin Name: Post Filter - Filter any contents with specific words
 * Plugin URI:  https://postfilter.cupcode.ir
 * Description: A simple plugin to filter any content such as posts, comments etc. with specific keywords
 * Version:     1.1.0
 * Author:      Artin
 * Author URI:  https://cupcode.ir
 * Text Domain: postfilter
 * Domain Path: /languages
 * License:     GPL2
 */
defined('ABSPATH') or die('No script kiddies please!');
include_once 'cupcode-options.php';

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'CPF_add_plugin_page_settings_link');
function CPF_add_plugin_page_settings_link($links)
{
    $links[] = '<a href="' .
        admin_url('admin.php?page=post-filter-plugin-options') .
        '">' . __('Settings') . '</a>';

    return $links;
}

function CPF_filter_handler($data, $postarr)
{

    $settings = get_option("pf-settings");
    if ($settings) {
        $settings = json_decode($settings);
        $postTypeCheck = array_search($data['post_type'], $settings->post_types);
        $mode = false;
        $words_array = explode(",", $settings->words);
        if ($settings->mode === "strict") $mode = true;
        if ($postTypeCheck !== false) {
            if ($settings->action == "draft") {

                foreach ($words_array as $word) {

                    $check = CPF_search_word(
                        $data['post_title'] . " " .
                        rawurldecode($data['post_name']) . " " .
                        $data['post_content'] . " " .
                        $data['post_excerpt'],
                        $word,
                        $mode
                    );


                    if ($check !== false) {
                        if ((!$mode && $check > 0) || $mode) {
                            $data['post_status'] = 'draft';
                            break;
                        }
                    }


                }


            } else {
                $replace_word = $settings->replace_word;
                foreach ($words_array as $word) {
                    $data['post_title'] = CPF_search_word($data['post_title'], $word, $mode, $replace_word);
                    $data['post_name'] = rawurlencode(CPF_search_word(rawurldecode($data['post_name']), $word, $mode, $replace_word));
                    $data['post_content'] = CPF_search_word($data['post_content'], $word, $mode, $replace_word);
                    $data['post_excerpt'] = CPF_search_word($data['post_excerpt'], $word, $mode, $replace_word);

                }


            }

        }


    }

    return $data;
}


add_filter('wp_insert_post_data', 'CPF_filter_handler', '99', 2);

function CPF_search_word($term, $word, $mode_strict = false, $replace_word = null)
{
    if (!$mode_strict) {
        $pattern = "/\b$word\b/u";
        if ($replace_word != null) {
            $result = preg_replace($pattern, $replace_word, $term);
            if ($result != null) return $result;
            else return false;
        } else {
            $result = preg_match_all($pattern, $term);
            if ($result) return $result;
            else return false;
        }
    } else {

        if ($replace_word != null) return str_replace($word, $replace_word, $term);

        else return mb_strpos($term, $word);

    }
}

