<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://rextheme.com/
 * @since      1.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wpvr
 * @subpackage Wpvr/public
 * @author     Rextheme <sakib@coderex.co>
 */

class Wpvr_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wpvr_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wpvr_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        global $wp;
        $wpvr_script_control = get_option('wpvr_script_control');
        $wpvr_script_list = get_option('wpvr_script_list');
        $allowed_pages_modified = array();
        $allowed_pages = explode(",", $wpvr_script_list);
        foreach ($allowed_pages as $value) {
            $allowed_pages_modified[] = untrailingslashit($value);
        }
        $current_url = home_url(add_query_arg(array($_GET), $wp->request));

        if ($wpvr_script_control == 'true') {
            foreach ($allowed_pages_modified as $value) {
                if ($value) {
                    if (strpos($current_url, $value) !== false) {
                        $fontawesome_disable = get_option('wpvr_fontawesome_disable');
                        if ($fontawesome_disable == 'true') {
                        } else {
                            wp_enqueue_style($this->plugin_name . 'fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', array(), $this->version, 'all');
                        }
                        wp_enqueue_style('panellium-css', plugin_dir_url(__FILE__) . 'lib/pannellum/src/css/pannellum.css', array(), true);
                        wp_enqueue_style('videojs-css', plugin_dir_url(__FILE__) . 'lib/pannellum/src/css/video-js.css', array(), true);
                        wp_enqueue_style('owl-css', plugin_dir_url(__FILE__) . 'css/owl.carousel.css', array(), $this->version, 'all');
                        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpvr-public.css', array(), $this->version, 'all');
                    }
                }
            }
        } else {
            $fontawesome_disable = get_option('wpvr_fontawesome_disable');
            if ($fontawesome_disable == 'true') {
            } else {
                wp_enqueue_style($this->plugin_name . 'fontawesome', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', array(), $this->version, 'all');
            }
            wp_enqueue_style('panellium-css', plugin_dir_url(__FILE__) . 'lib/pannellum/src/css/pannellum.css', array(), true);
            wp_enqueue_style('videojs-css', plugin_dir_url(__FILE__) . 'lib/pannellum/src/css/video-js.css', array(), true);
            wp_enqueue_style('owl-css', plugin_dir_url(__FILE__) . 'css/owl.carousel.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpvr-public.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wpvr_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wpvr_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $notice = '';
        $wpvr_frontend_notice = get_option('wpvr_frontend_notice');
        if ($wpvr_frontend_notice) {
            $notice = get_option('wpvr_frontend_notice_area');
        }
        global $wp;
        $wpvr_script_control = get_option('wpvr_script_control');
        $wpvr_script_list = get_option('wpvr_script_list');
        $allowed_pages_modified = array();
        $allowed_pages = explode(",", $wpvr_script_list);
        foreach ($allowed_pages as $value) {
            $allowed_pages_modified[] = untrailingslashit($value);
        }

        $wpvr_video_script_control = get_option('wpvr_video_script_control');
        $wpvr_video_script_list = get_option('wpvr_video_script_list');
        $allowed_video_pages_modified = array();
        $allowed_video_pages = explode(",", $wpvr_video_script_list);
        foreach ($allowed_video_pages as $value) {
            $allowed_video_pages_modified[] = untrailingslashit($value);
        }

        $current_url = home_url(add_query_arg(array($_GET), $wp->request));

        if ($wpvr_script_control == 'true') {
            foreach ($allowed_pages_modified as $value) {
                if (strpos($current_url, $value) !== false) {
                    wp_enqueue_script('panellium-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/pannellum.js', array(), true);
                    wp_enqueue_script('panelliumlib-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/libpannellum.js', array(), true);
                    wp_enqueue_script('videojs-js', plugin_dir_url(__FILE__) . 'js/video.js', array(), true);
                    wp_enqueue_script('panelliumvid-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/videojs-pannellum-plugin.js', array(), true);
                    wp_enqueue_script('owl-js', plugin_dir_url(__FILE__) . 'js/owl.carousel.js', array('jquery'), false);
                    wp_enqueue_script('jquery_cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js', array('jquery'), true);
                    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpvr-public.js', array('jquery', 'jquery_cookie'), $this->version, false);
                    wp_localize_script('wpvr', 'wpvr_public', array(
                        'notice_active' => $wpvr_frontend_notice,
                        'notice' => $notice,
                    ));
                }
            }
        } else {
            wp_enqueue_script('panellium-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/pannellum.js', array(), true);
            wp_enqueue_script('panelliumlib-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/libpannellum.js', array(), true);
            wp_enqueue_script('videojs-js', plugin_dir_url(__FILE__) . 'js/video.js', array(), true);
            wp_enqueue_script('panelliumvid-js', plugin_dir_url(__FILE__) . 'lib/pannellum/src/js/videojs-pannellum-plugin.js', array(), true);
            wp_enqueue_script('owl-js', plugin_dir_url(__FILE__) . 'js/owl.carousel.js', array('jquery'), false);
            wp_enqueue_script('jquery_cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js', array('jquery'), true);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpvr-public.js', array('jquery', 'jquery_cookie'), $this->version, true);
            wp_localize_script('wpvr', 'wpvr_public', array(
                'notice_active' => $wpvr_frontend_notice,
                'notice' => $notice,
            ));
        }

        $match_found = false;
        if ($wpvr_video_script_control == 'true') {
            foreach ($allowed_video_pages_modified as $value) {
                if (strpos($current_url, $value) !== false) {
                    $match_found = true;
                    wp_enqueue_script('videojs-js', plugin_dir_url(__FILE__) . 'js/video.js', array(), true);
                }
            }
            if (!$match_found) {
                wp_dequeue_script('videojs-js');
            }
        }
    }

    /**
     * Init the edit screen of the plugin post type item
     *
     * @since 1.0.0
     */
    public function public_init()
    {
        add_shortcode($this->plugin_name, array($this, 'wpvr_shortcode'));
    }


    /**
     * Shortcode output for the plugin
     *
     * @since 1.0.0
     */
    public function wpvr_shortcode($atts)
    {
        extract(
            shortcode_atts(
                array(
                    'id' => 0,
                    'width' => null,
                    'height' => null,
                    'radius' => null
                ),
                $atts
            )
        );

        if (!$id) {
            $obj = get_page_by_path($slug, OBJECT, $this->post_type);
            if ($obj) {
                $id = $obj->ID;
            } else {
                return __('Invalid Wpvr slug attribute', $this->plugin_name);
            }
        }

        $postdata = get_post_meta($id, 'panodata', true);
        $panoid = 'pano' . $id;

        if (isset($postdata['streetviewdata'])) {
            if (empty($width)) {
                $width = '600px';
            }
            if (empty($height)) {
                $height = '400px';
            }
            $streetviewurl = $postdata['streetviewurl'];
            $html = '';
            $html .= '<div class="vr-streetview" style="text-align: center; max-width:100%; width:' . $width . '; height:' . $height . '; margin: 0 auto;">';
            $html .= '<iframe src="' . $streetviewurl . '" frameborder="0" style="border:0; width:100px; height:100%;" allowfullscreen=""></iframe>';
            $html .= '</div>';
            return $html;
        }


        if (isset($postdata['vidid'])) {
            if (empty($width)) {
                $width = '600px';
            }
            if (empty($height)) {
                $height = '400px';
            }

            $videourl = $postdata['vidurl'];
            $autoplay = 'off';
            if (isset($postdata['autoplay'])) {
                $autoplay = $postdata['autoplay'];
            }

            $loop = 'off';
            if (isset($postdata['loop'])) {
                $loop = $postdata['loop'];
            }

            if (strpos($videourl, 'youtube') > 0 || strpos($videourl, 'youtu') > 0) {
                $explodeid = '';
                $explodeid = explode("=", $videourl);
                $foundid = '';
                $muted = '&mute=1';

                if ($loop == 'on') {
                    $loop = '&loop=1';
                } else {
                    $loop = '';
                }

                if (strpos($videourl, 'youtu') > 0) {
                    $explodeid = explode("/", $videourl);
                    $foundid = $explodeid[3] . '?' . $autoplay . $loop;
                    $expdata = $explodeid[3];
                } else {
                    $foundid = $explodeid[1] . '?' . $autoplay . $loop;
                    $expdata = $explodeid[1];
                }

                $html = '';
                $html .= '<div style="text-align:center; max-width:100%; width:' . $width . '; height:' . $height . '; border-radius: ' . $radius . '; margin: 0 auto;">';

                //     $html .= '
                //       <iframe src="https://www.youtube.com/embed/' . $expdata . '?rel=0&modestbranding=1' . $loop . '&autohide=1' . $muted . '&showinfo=0&controls=1' . $autoplay . '&playlist='.$expdata.'"  width="100%" height="100%" style="border-radius: '.$radius.';" frameborder="0" allowfullscreen></iframe>
                //   ';
                $html .= '
              <iframe src="https://www.youtube.com/embed/' . $expdata . '?rel=0&modestbranding=1' . $loop . '&autohide=1' . $muted . '&showinfo=0&controls=1' . $autoplay . '" width="100%" height="100%" style="border-radius: ' . $radius . ';" frameborder="0" allowfullscreen></iframe>
      ';
                $html .= '</div>';
            } elseif (strpos($videourl, 'vimeo') > 0) {
                $explodeid = '';
                $explodeid = explode("/", $videourl);
                $foundid = '';
                if ($autoplay == 'on') {
                    $autoplay = '&autoplay=1&muted=1';
                } else {
                    $autoplay = '';
                }

                if ($loop == 'on') {
                    $loop = '&loop=1';
                } else {
                    $loop = '';
                }
                $foundid = $explodeid[3] . '?' . $autoplay . $loop;
                $html = '';
                $html .= '<div style="text-align: center; max-width:100%; width:' . $width . '; height:' . $height . '; margin: 0 auto;">';
                $html .= '<iframe src="https://player.vimeo.com/video/' . $foundid . '" width="' . trim($width, 'px') . '" height="' . trim($height, 'px') . '" style="border-radius: ' . $radius . ';" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                $html .= '</div>';
            } else {

                $html = '';
                $html .= '<div id="pano' . $id . '" class="pano-wrap" style="max-width:100%; width: ' . $width . '; height: ' . $height . '; border-radius: ' . $radius . '; margin: 0 auto;">';
                $html .= '<div style="width:100%; height:100%; ">' . $postdata['panoviddata'] . '</div>';

                $html .= '
                <style>
                    .video-js {
                        border-radius:' . $radius . ';
                    }
                </style>
                
                ';
                $html .= '<script>';
                $html .= 'var player = videojs(' . $postdata['vidid'] . ', {';
                $html .= 'plugins: {';
                $html .= 'pannellum: {}';
                $html .= '}';
                $html .= '});';
                $html .= '
								    videojs(' . $postdata['vidid'] . ').play();
								';
                $html .= '</script>';
                $html .= '</div>';
            }

            return $html;
        }

        $control = false;
        if (isset($postdata['showControls'])) {
            $control = $postdata['showControls'];
        }

        if ($control) {
            if (isset($postdata['customcontrol'])) {
                $custom_control = $postdata['customcontrol'];
                if ($custom_control['panupSwitch'] == "on" || $custom_control['panDownSwitch'] == "on" || $custom_control['panLeftSwitch'] == "on" || $custom_control['panRightSwitch'] == "on" || $custom_control['panZoomInSwitch'] == "on" || $custom_control['panZoomOutSwitch'] == "on" || $custom_control['panFullscreenSwitch'] == "on" || $custom_control['gyroscopeSwitch'] == "on" || $custom_control['backToHomeSwitch'] == "on") {
                    $control = false;
                }
            }
        }

        $vrgallery = false;
        if (isset($postdata['vrgallery'])) {
            $vrgallery = $postdata['vrgallery'];
        }

        $vrgallery_title = false;
        if (isset($postdata['vrgallery_title'])) {
            $vrgallery_title = $postdata['vrgallery_title'];
        }

        $vrgallery_display = false;
        if (isset($postdata['vrgallery_display'])) {
            $vrgallery_display = $postdata['vrgallery_display'];
        }

        $gyro = false;
        $gyro_orientation = false;
        if (isset($postdata['gyro'])) {
            $gyro = $postdata['gyro'];
            if (isset($postdata['deviceorientationcontrol'])) {
                $gyro_orientation = $postdata['deviceorientationcontrol'];
            }
        }

        $compass = false;
        $audio_right = "5px";
        if (isset($postdata['compass'])) {
            $compass = $postdata['compass'];
            if ($compass) {
                $audio_right = "60px";
            }
        }

        $mouseZoom = true;
        if (isset($postdata['mouseZoom'])) {
            $mouseZoom = $postdata['mouseZoom'];
        }

        $draggable = true;
        if (isset($postdata['draggable'])) {
            $draggable = $postdata['draggable'];
        }

        $diskeyboard = false;
        if (isset($postdata['diskeyboard'])) {
            $diskeyboard = $postdata['diskeyboard'];
        }

        $keyboardzoom = true;
        if (isset($postdata['keyboardzoom'])) {
            $keyboardzoom = $postdata['keyboardzoom'];
        }

        $autoload = false;

        if (isset($postdata['autoLoad'])) {
            $autoload = $postdata['autoLoad'];
        }

        $default_scene = '';
        if (isset($postdata['defaultscene'])) {
            $default_scene = $postdata['defaultscene'];
        }

        $default_global_zoom = '';
        if (isset($postdata['hfov'])) {
            $default_global_zoom = $postdata['hfov'];
        }

        $max_global_zoom = '';
        if (isset($postdata['maxHfov'])) {
            $max_global_zoom = $postdata['maxHfov'];
        }

        $min_global_zoom = '';
        if (isset($postdata['minHfov'])) {
            $min_global_zoom = $postdata['minHfov'];
        }

        $preview = '';
        if (isset($postdata['preview'])) {
            $preview = $postdata['preview'];
        }

        $autorotation = '';
        if (isset($postdata["autoRotate"])) {
            $autorotation = $postdata["autoRotate"];
        }
        $autorotationinactivedelay = '';
        if (isset($postdata["autoRotateInactivityDelay"])) {
            $autorotationinactivedelay = $postdata["autoRotateInactivityDelay"];
        }
        $autorotationstopdelay = '';
        if (isset($postdata["autoRotateStopDelay"])) {
            $autorotationstopdelay = $postdata["autoRotateStopDelay"];
        }

        $scene_fade_duration = '';
        if (isset($postdata['scenefadeduration'])) {
            $scene_fade_duration = $postdata['scenefadeduration'];
        }

        $panodata = '';
        if (isset($postdata['panodata'])) {
            $panodata = $postdata['panodata'];
        }

        $hotspoticoncolor = '#00b4ff';
        $hotspotblink = 'on';
        $default_data = array();
        if ($default_global_zoom != '' && $max_global_zoom != '' && $min_global_zoom != '') {
            $default_data = array("firstScene" => $default_scene, "sceneFadeDuration" => $scene_fade_duration, "hfov" => $default_global_zoom, "maxHfov" => $max_global_zoom, "minHfov" => $min_global_zoom);
        } else {
            $default_data = array("firstScene" => $default_scene, "sceneFadeDuration" => $scene_fade_duration);
        }

        $scene_data = array();

        if (!empty($panodata["scene-list"])) {
            foreach ($panodata["scene-list"] as $panoscenes) {
                $scene_ititle = '';
                if (isset($panoscenes["scene-ititle"])) {
                    $scene_ititle = sanitize_text_field($panoscenes["scene-ititle"]);
                }

                $scene_author = '';
                if (isset($panoscenes["scene-author"])) {
                    $scene_author = sanitize_text_field($panoscenes["scene-author"]);
                }

                $scene_author_url = '';
                if (isset($panoscenes["scene-author-url"])) {
                    $scene_author_url = sanitize_text_field($panoscenes["scene-author-url"]);
                }

                $scene_vaov = 180;
                if (isset($panoscenes["scene-vaov"])) {
                    $scene_vaov = (float)$panoscenes["scene-vaov"];
                }

                $scene_haov = 360;
                if (isset($panoscenes["scene-haov"])) {
                    $scene_haov = (float)$panoscenes["scene-haov"];
                }


                $scene_vertical_offset = 0;
                if (isset($panoscenes["scene-vertical-offset"])) {
                    $scene_vertical_offset = (float)$panoscenes["scene-vertical-offset"];
                }

                $default_scene_pitch = null;
                if (isset($panoscenes["scene-pitch"])) {
                    $default_scene_pitch = (float)$panoscenes["scene-pitch"];
                }

                $default_scene_yaw = null;
                if (isset($panoscenes["scene-yaw"])) {
                    $default_scene_yaw = (float)$panoscenes["scene-yaw"];
                }

                $scene_max_pitch = '';
                if (isset($panoscenes["scene-maxpitch"])) {
                    $scene_max_pitch = (float)$panoscenes["scene-maxpitch"];
                }


                $scene_min_pitch = '';
                if (isset($panoscenes["scene-minpitch"])) {
                    $scene_min_pitch = (float)$panoscenes["scene-minpitch"];
                }


                $scene_max_yaw = '';
                if (isset($panoscenes["scene-maxyaw"])) {
                    $scene_max_yaw = (float)$panoscenes["scene-maxyaw"];
                }


                $scene_min_yaw = '';
                if (isset($panoscenes["scene-minyaw"])) {
                    $scene_min_yaw = (float)$panoscenes["scene-minyaw"];
                }

                $default_zoom = 100;
                if (isset($panoscenes["scene-zoom"]) && $panoscenes["scene-zoom"] != "") {
                    $default_zoom = $panoscenes["scene-zoom"];
                } else {
                    if ($default_global_zoom != '') {
                        $default_zoom =  (int)$default_global_zoom;
                    }
                }


                $max_zoom = 120;
                if (isset($panoscenes["scene-maxzoom"]) && $panoscenes["scene-maxzoom"] != '') {
                    $max_zoom = (int)$panoscenes["scene-maxzoom"];
                } else {
                    if ($max_global_zoom != '') {
                        $max_zoom =  (int)$max_global_zoom;
                    }
                }



                $min_zoom = 50;
                if (isset($panoscenes["scene-minzoom"]) && $panoscenes["scene-minzoom"] != '') {
                    $min_zoom = (int)$panoscenes["scene-minzoom"];
                } else {
                    if ($min_global_zoom != '') {
                        $min_zoom =  (int)$min_global_zoom;
                    }
                }


                $hotspot_datas = array();
                if (isset($panoscenes["hotspot-list"])) {
                    $hotspot_datas = $panoscenes["hotspot-list"];
                    
                }

                $hotspots = array();


                foreach ($hotspot_datas as $hotspot_data) {
                    $status  = get_option('wpvr_edd_license_status');
                    if ($status !== false && $status == 'valid') {
                        if (isset($hotspot_data["hotspot-customclass-pro"]) && $hotspot_data["hotspot-customclass-pro"] != 'none') {
                            $hotspot_data["hotspot-customclass"] = $hotspot_data["hotspot-customclass-pro"];
                            $hotspoticoncolor = $hotspot_data["hotspot-customclass-color-icon-value"];
                        }
                        if (isset($hotspot_data['hotspot-blink'])) {
                            $hotspotblink = $hotspot_data['hotspot-blink'];
                        }
                    }
                    $hotspot_scene_pitch = '';
                    if (isset($hotspot_data["hotspot-scene-pitch"])) {
                        $hotspot_scene_pitch = $hotspot_data["hotspot-scene-pitch"];
                    }
                    $hotspot_scene_yaw = '';
                    if (isset($hotspot_data["hotspot-scene-yaw"])) {
                        $hotspot_scene_yaw = $hotspot_data["hotspot-scene-yaw"];
                    }

                    $hotspot_type = $hotspot_data["hotspot-type"] !== 'scene' ? 'info' : $hotspot_data["hotspot-type"];
                    $hotspot_content = '';

                    ob_start();
                    do_action('wpvr_hotspot_content', $hotspot_data);
                    $hotspot_content = ob_get_clean();

                    if (!$hotspot_content) {
                        $hotspot_content = $hotspot_data["hotspot-content"];
                    }

                    $hotspot_info = array(
                        "text" => $hotspot_data["hotspot-title"],
                        "pitch" => $hotspot_data["hotspot-pitch"],
                        "yaw" => $hotspot_data["hotspot-yaw"],
                        "type" => $hotspot_type,
                        "cssClass" => $hotspot_data["hotspot-customclass"],
                        "URL" => $hotspot_data["hotspot-url"],
                        "wpvr_url_open" => $hotspot_data["wpvr_url_open"][0],
                        "clickHandlerArgs" => $hotspot_content,
                        "createTooltipArgs" => $hotspot_data["hotspot-hover"],
                        "sceneId" => $hotspot_data["hotspot-scene"],
                        "targetPitch" => (float)$hotspot_scene_pitch,
                        "targetYaw" => (float)$hotspot_scene_yaw,
                        'hotspot_type' => $hotspot_data['hotspot-type'],
                        'hotspot_target' => 'notBlank'
                    );

                    $hotspot_info['URL'] = ($hotspot_data['hotspot-type'] === 'fluent_form' || $hotspot_data['hotspot-type'] === 'wc_product') ? '' : $hotspot_info['URL'];

                    if ($hotspot_data["hotspot-customclass"] == 'none' || $hotspot_data["hotspot-customclass"] == '') {
                        unset($hotspot_info["cssClass"]);
                    }
                    if (empty($hotspot_data["hotspot-scene"])) {
                        unset($hotspot_info['targetPitch']);
                        unset($hotspot_info['targetYaw']);
                    }
                    array_push($hotspots, $hotspot_info);
                }

                $device_scene = $panoscenes['scene-attachment-url'];
                $mobile_media_resize = get_option('mobile_media_resize');
                $file_accessible = ini_get('allow_url_fopen');

                if ($mobile_media_resize == "true") {
                    if ($file_accessible == "1") {
                        $image_info = getimagesize($device_scene);
                        if ($image_info[0] > 4096) {
                            $src_to_id_for_mobile = '';
                            $src_to_id_for_desktop = '';
                            if (wpvr_isMobileDevice()) {
                                $src_to_id_for_mobile = attachment_url_to_postid($panoscenes['scene-attachment-url']);
                                if ($src_to_id_for_mobile) {
                                    $mobile_scene = wp_get_attachment_image_src($src_to_id_for_mobile, 'wpvr_mobile');
                                    if ($mobile_scene[3]) {
                                        $device_scene = $mobile_scene[0];
                                    }
                                }
                            } else {
                                $src_to_id_for_desktop = attachment_url_to_postid($panoscenes['scene-attachment-url']);
                                if ($src_to_id_for_desktop) {
                                    $desktop_scene = wp_get_attachment_image_src($src_to_id_for_mobile, 'full');
                                    if ($desktop_scene[0]) {
                                        $device_scene = $desktop_scene[0];
                                    }
                                }
                            }
                        }
                    }
                }

                $scene_info = array();

                if ($panoscenes["scene-type"] == 'cubemap') {
                    $pano_attachment = array(
                        $panoscenes["scene-attachment-url-face0"],
                        $panoscenes["scene-attachment-url-face1"],
                        $panoscenes["scene-attachment-url-face2"],
                        $panoscenes["scene-attachment-url-face3"],
                        $panoscenes["scene-attachment-url-face4"],
                        $panoscenes["scene-attachment-url-face5"]
                    );

                    $scene_info = array("type" => $panoscenes["scene-type"], "cubeMap" => $pano_attachment, "pitch" => $default_scene_pitch, "maxPitch" => $scene_max_pitch, "minPitch" => $scene_min_pitch, "maxYaw" => $scene_max_yaw, "minYaw" => $scene_min_yaw, "yaw" => $default_scene_yaw, "hfov" => $default_zoom, "maxHfov" => $max_zoom, "minHfov" => $min_zoom, "title" => $scene_ititle, "author" => $scene_author, "authorURL" => $scene_author_url, "vaov" => $scene_vaov, "haov" => $scene_haov, "vOffset" => $scene_vertical_offset, "hotSpots" => $hotspots);
                } else {
                    $scene_info = array("type" => $panoscenes["scene-type"], "panorama" => $device_scene, "pitch" => $default_scene_pitch, "maxPitch" => $scene_max_pitch, "minPitch" => $scene_min_pitch, "maxYaw" => $scene_max_yaw, "minYaw" => $scene_min_yaw, "yaw" => $default_scene_yaw, "hfov" => $default_zoom, "maxHfov" => $max_zoom, "minHfov" => $min_zoom, "title" => $scene_ititle, "author" => $scene_author, "authorURL" => $scene_author_url, "vaov" => $scene_vaov, "haov" => $scene_haov, "vOffset" => $scene_vertical_offset, "hotSpots" => $hotspots);
                }


                if (isset($panoscenes["ptyscene"])) {
                    if ($panoscenes["ptyscene"] == "off") {
                        unset($scene_info['pitch']);
                        unset($scene_info['yaw']);
                    }
                }

                if (empty($panoscenes["scene-ititle"])) {
                    unset($scene_info['title']);
                }
                if (empty($panoscenes["scene-author"])) {
                    unset($scene_info['author']);
                }
                if (empty($panoscenes["scene-author-url"])) {
                    unset($scene_info['authorURL']);
                }

                if (empty($scene_vaov)) {
                    unset($scene_info['vaov']);
                }

                if (empty($scene_haov)) {
                    unset($scene_info['haov']);
                }

                if (empty($scene_vertical_offset)) {
                    unset($scene_info['vOffset']);
                }

                if (isset($panoscenes["cvgscene"])) {
                    if ($panoscenes["cvgscene"] == "off") {
                        unset($scene_info['maxPitch']);
                        unset($scene_info['minPitch']);
                    }
                }
                if (empty($panoscenes["scene-maxpitch"])) {
                    unset($scene_info['maxPitch']);
                }

                if (empty($panoscenes["scene-minpitch"])) {
                    unset($scene_info['minPitch']);
                }

                if (isset($panoscenes["chgscene"])) {
                    if ($panoscenes["chgscene"] == "off") {
                        unset($scene_info['maxYaw']);
                        unset($scene_info['minYaw']);
                    }
                }
                if (empty($panoscenes["scene-maxyaw"])) {
                    unset($scene_info['maxYaw']);
                }

                if (empty($panoscenes["scene-minyaw"])) {
                    unset($scene_info['minYaw']);
                }

                // if (isset($panoscenes["czscene"])) {
                //     if ($panoscenes["czscene"] == "off") {
                //         unset($scene_info['hfov']);
                //         unset($scene_info['maxHfov']);
                //         unset($scene_info['minHfov']);
                //     }
                // }

                $scene_array = array();
                $scene_array = array(
                    $panoscenes["scene-id"] => $scene_info
                );
                $scene_data[$panoscenes["scene-id"]] = $scene_info;
            }
        }

        $pano_id_array = array();
        $pano_id_array = array("panoid" => $panoid);
        $pano_response = array();
        $pano_response = array("autoLoad" => $autoload, "showControls" => $control, "orientationSupport" => 'false', "compass" => $compass, 'orientationOnByDefault' => $gyro_orientation, "mouseZoom" => $mouseZoom, "draggable" => $draggable, 'disableKeyboardCtrl' => $diskeyboard, 'keyboardZoom' => $keyboardzoom, "preview" => $preview, "autoRotate" => $autorotation, "autoRotateInactivityDelay" => $autorotationinactivedelay, "autoRotateStopDelay" => $autorotationstopdelay, "default" => $default_data, "scenes" => $scene_data);
        if (empty($autorotation)) {
            unset($pano_response['autoRotate']);
            unset($pano_response['autoRotateInactivityDelay']);
            unset($pano_response['autoRotateStopDelay']);
        }
        if (empty($autorotationinactivedelay)) {
            unset($pano_response['autoRotateInactivityDelay']);
        }
        if (empty($autorotationstopdelay)) {
            unset($pano_response['autoRotateStopDelay']);
        }
        $response = array();
        $response = array($pano_id_array, $pano_response);
        if (!empty($response)) {
            $response = json_encode($response);
        }


        if (empty($width)) {
            $width = '600px';
        }
        if (empty($height)) {
            $height = '400px';
        }
        $foreground_color = '#fff';
        $pulse_color = wpvr_hex2rgb($hotspoticoncolor);
        $rgb = wpvr_HTMLToRGB($hotspoticoncolor);
        $hsl = wpvr_RGBToHSL($rgb);
        if ($hsl->lightness > 200) {
            $foreground_color = '#000000';
        } else {
            $foreground_color = '#fff';
        }
        $html = '';

        $html .= '<style>';
        if ($width == 'embed') {
            $html .= 'body{
                overflow: hidden;
           }';
        }
        $html .= '#' . $panoid . ' div.pnlm-hotspot-base.fas,
					#' . $panoid . ' div.pnlm-hotspot-base.fab,
					#' . $panoid . ' div.pnlm-hotspot-base.fa,
					#' . $panoid . ' div.pnlm-hotspot-base.far {
					    display: block !important;
					    background-color: ' . $hotspoticoncolor . ';
					    color: ' . $foreground_color . ';
					    border-radius: 100%;
					    width: 30px;
					    height: 30px;
					    animation: icon-pulse' . $panoid . ' 1.5s infinite cubic-bezier(.25, 0, 0, 1);
					}';
        if ($hotspotblink == 'on') {
            $html .= '@-webkit-keyframes icon-pulse' . $panoid . ' {
					    0% {
					        box-shadow: 0 0 0 0px rgba(' . $pulse_color[0] . ', 1);
					    }
					    100% {
					        box-shadow: 0 0 0 10px rgba(' . $pulse_color[0] . ', 0);
					    }
					}
					@keyframes icon-pulse' . $panoid . ' {
					    0% {
					        box-shadow: 0 0 0 0px rgba(' . $pulse_color[0] . ', 1);
					    }
					    100% {
					        box-shadow: 0 0 0 10px rgba(' . $pulse_color[0] . ', 0);
					    }
					}';
        }

        $status  = get_option('wpvr_edd_license_status');
        if ($status !== false && $status == 'valid') {
            if (!$gyro) {
                $html .= '#' . $panoid . ' div.pnlm-orientation-button {
                    display: none;
                }';
            }
        } else {
            $html .= '#' . $panoid . ' div.pnlm-orientation-button {
                    display: none;
                }';
        }

        $html .= '</style>';
        if ($width == 'fullwidth') {
            if (wpvr_isMobileDevice()) {
                if ($radius) {
                    $html .= '<div id="pano' . $id . '" class="pano-wrap" style="text-align:center; border-radius:' . $radius . '; direction:ltr;">';
                } else {
                    $html .= '<div id="pano' . $id . '" class="pano-wrap" style="text-align:center;">';
                }
            } else {
                if ($radius) {
                    $html .= '<div id="pano' . $id . '" class="pano-wrap vrfullwidth" style=" text-align:center; height: ' . $height . '; border-radius:' . $radius . '; direction:ltr;" >';
                } else {
                    $html .= '<div id="pano' . $id . '" class="pano-wrap vrfullwidth" style=" text-align:center; height: ' . $height . '; direction:ltr;" >';
                }
            }
        } elseif ($width == 'embed') {
            // if (apply_filters('is_wpvr_embed_addon_premium', false)) {
            $html .= '<div id="pano' . $id . '" class="pano-wrap vrembed" style=" text-align:center; direction:ltr;" >';
            // }
        } else {
            if ($radius) {
                $html .= '<div id="pano' . $id . '" class="pano-wrap" style=" text-align:center; max-width:100%; width: ' . $width . '; height: ' . $height . '; margin: 0 auto; border-radius:' . $radius . '; direction:ltr;">';
            } else {
                $html .= '<div id="pano' . $id . '" class="pano-wrap" style=" text-align:center; max-width:100%; width: ' . $width . '; height: ' . $height . '; margin: 0 auto; direction:ltr;">';
            }
        }

        //===company logo===//
        if (isset($postdata['cpLogoSwitch'])) {
            $cpLogoImg = $postdata['cpLogoImg'];
            $cpLogoContent = $postdata['cpLogoContent'];
            if ($postdata['cpLogoSwitch'] == 'on') {
                $html .= '<div id="cp-logo-controls">';
                $html .= '<div class="cp-logo-ctrl" id="cp-logo">';
                if ($cpLogoImg) {
                    $html .= '<img src="' . $cpLogoImg . '" alt="Company Logo">';
                }

                if ($cpLogoContent) {
                    $html .= '<div class="cp-info">' . $cpLogoContent . '</div>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        //===company logo ends===//

        //===Background Tour===//
        if (isset($postdata['bg_tour_enabler'])) {

            $bg_tour_enabler = $postdata['bg_tour_enabler'];
            if ($bg_tour_enabler == 'on') {
                $bg_tour_navmenu = $postdata['bg_tour_navmenu'];
                $bg_tour_title = $postdata['bg_tour_title'];
                $bg_tour_subtitle = $postdata['bg_tour_subtitle'];

                if ($bg_tour_navmenu == 'on') {
                    $menuLocations = get_nav_menu_locations();
                    if (!empty($menuLocations['primary'])) {
                        $menuID = $menuLocations['primary'];
                        $primaryNav = wp_get_nav_menu_items($menuID);
                        $html .= '<ul class="wpvr-navbar-container">';
                        foreach ($primaryNav as $primaryNav_key => $primaryNav_value) {
                            if ($primaryNav_value->menu_item_parent == "0") {
                                $html .= '<li>';
                                $html .= '<a href="' . $primaryNav_value->url . '">' . $primaryNav_value->title . '</a>';
                                $html .= '<ul class="wpvr-navbar-dropdown">';
                                foreach ($primaryNav as $pm_key => $pm_value) {
                                    if ($pm_value->menu_item_parent == $primaryNav_value->ID) {
                                        $html .= '<li>';
                                        $html .= '<a href="' . $pm_value->url . '">' . $pm_value->title . '</a>';
                                        $html .= '</li>';
                                    }
                                }
                                $html .= '</ul>';
                                $html .= '</li>';
                            }
                        }
                        $html .= '</ul>';
                    }
                }

                $html .= '<div class="wpvr-home-content">';
                $html .= '<div class="wpvr-home-title">' . $bg_tour_title . '</div>';
                $html .= '<div class="wpvr-home-subtitle">' . $bg_tour_subtitle . '</div>';
                $html .= '</div>';
            }
        }
        //===Background Tour End===//

        //===Custom Control===//
        if (isset($custom_control)) {
            if ($custom_control['panZoomInSwitch'] == "on" || $custom_control['panZoomOutSwitch'] == "on" || $custom_control['gyroscopeSwitch'] == "on" || $custom_control['backToHomeSwitch'] == "on") {
                $html .= '<div id="zoom-in-out-controls' . $id . '" class="zoom-in-out-controls">';

                if ($custom_control['backToHomeSwitch'] == "on") {
                    $html .= '<div class="ctrl" id="backToHome' . $id . '"><i class="' . $custom_control['backToHomeIcon'] . '" style="color:' . $custom_control['backToHomeColor'] . ';"></i></div>';
                }

                if ($custom_control['panZoomInSwitch'] == "on") {
                    $html .= '<div class="ctrl" id="zoom-in' . $id . '"><i class="' . $custom_control['panZoomInIcon'] . '" style="color:' . $custom_control['panZoomInColor'] . ';"></i></div>';
                }

                if ($custom_control['panZoomOutSwitch'] == "on") {
                    $html .= '<div class="ctrl" id="zoom-out' . $id . '"><i class="' . $custom_control['panZoomOutIcon'] . '" style="color:' . $custom_control['panZoomOutColor'] . ';"></i></div>';
                }
                if ($custom_control['gyroscopeSwitch'] == "on") {
                    $html .= '<div class="ctrl" id="gyroscope' . $id . '" ><i class="' . $custom_control['gyroscopeIcon'] . '" id="' . $custom_control['gyroscopeIcon'] . '" style="color:' . $custom_control['gyroscopeColor'] . ';"></i></div>';
                }
                $html .= '</div>';
            }
            //===zoom in out Control===//

            if ($custom_control['panupSwitch'] == "on" || $custom_control['panDownSwitch'] == "on" || $custom_control['panLeftSwitch'] == "on" || $custom_control['panRightSwitch'] == "on" || $custom_control['panFullscreenSwitch'] == "on") {
                //===Custom Control===//
                $html .= '<div class="controls" id="controls' . $id . '">';

                if ($custom_control['panupSwitch'] == "on") {
                    $html .= '<div class="ctrl pan-up" id="pan-up' . $id . '"><i class="' . $custom_control['panupIcon'] . '" style="color:' . $custom_control['panupColor'] . ';"></i></div>';
                }

                if ($custom_control['panDownSwitch'] == "on") {
                    $html .= '<div class="ctrl pan-down" id="pan-down' . $id . '"><i class="' . $custom_control['panDownIcon'] . '" style="color:' . $custom_control['panDownColor'] . ';"></i></div>';
                }

                if ($custom_control['panLeftSwitch'] == "on") {
                    $html .= '<div class="ctrl pan-left" id="pan-left' . $id . '"><i class="' . $custom_control['panLeftIcon'] . '" style="color:' . $custom_control['panLeftColor'] . ';"></i></div>';
                }

                if ($custom_control['panRightSwitch'] == "on") {
                    $html .= '<div class="ctrl pan-right" id="pan-right' . $id . '"><i class="' . $custom_control['panRightIcon'] . '" style="color:' . $custom_control['panRightColor'] . ';"></i></div>';
                }

                if ($custom_control['panFullscreenSwitch'] == "on") {
                    $html .= '<div class="ctrl fullscreen" id="fullscreen' . $id . '"><i class="' . $custom_control['panFullscreenIcon'] . '" style="color:' . $custom_control['panFullscreenColor'] . ';"></i></div>';
                }
                $html .= '</div>';
            }
        }
        //===Custom Control===//

        if ($vrgallery) {
            //===Carousal setup===//
            $html .= '<div id="vrgcontrols' . $id . '" class="vrgcontrols">';

            $html .= '<div class="vrgctrl' . $id . ' vrbounce">';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div id="sccontrols' . $id . '" class="scene-gallery vrowl-carousel owl-theme">';
            if (isset($panodata["scene-list"])) {
                foreach ($panodata["scene-list"] as $panoscenes) {
                    $scene_key = $panoscenes['scene-id'];
                    if ($vrgallery_title == 'on') {
                        $scene_key_title = $panoscenes['scene-ititle'];
                        // $scene_key_title = $panoscenes['scene-id'];
                    } else {
                        $scene_key_title = "";
                    }
                    if ($panoscenes['scene-type'] == 'cubemap') {
                        $img_src_url = $panoscenes['scene-attachment-url-face0'];
                    } else {
                        $img_src_url = $panoscenes['scene-attachment-url'];
                    }
                    $src_to_id = attachment_url_to_postid($img_src_url);
                    $thumbnail_array = wp_get_attachment_image_src($src_to_id, 'thumbnail');
                    if ($thumbnail_array) {
                        $thumbnail = $thumbnail_array[0];
                    } else {
                        $thumbnail = $img_src_url;
                    }

                    $html .= '<ul style="width:150px;"><li title="Double click to view scene">' . $scene_key_title . '<img class="scctrl" id="' . $scene_key . '_gallery_' . $id . '" src="' . $thumbnail . '"></li></ul>';
                }
            }

            $html .= '</div>';

            $html .= '
            <div class="owl-nav wpvr_slider_nav">
            <button type="button" role="presentation" class="owl-prev wpvr_owl_prev">
                <div class="nav-btn prev-slide"><i class="fa fa-angle-left"></i></div>
            </button>
            <button type="button" role="presentation" class="owl-next wpvr_owl_next">
                <div class="nav-btn next-slide"><i class="fa fa-angle-right"></i></div>
            </button>
            </div>
            ';

            //===Carousal setup end===//
        }

        if (isset($postdata['bg_music'])) {
            $bg_music = $postdata['bg_music'];
            $bg_music_url = $postdata['bg_music_url'];
            $autoplay_bg_music = $postdata['autoplay_bg_music'];
            $loop_bg_music = $postdata['loop_bg_music'];
            $bg_loop = '';
            if ($loop_bg_music == 'on') {
                $bg_loop = 'loop';
            }

            if ($bg_music == 'on') {
                $html .= '<div id="adcontrol' . $id . '" class="adcontrol" style="right:' . $audio_right . '">';
                $html .= '<audio id="vrAudio' . $id . '" class="vrAudioDefault" data-autoplay="' . $autoplay_bg_music . '" onended="audionEnd' . $id . '()" ' . $bg_loop . '>
                                <source src="' . $bg_music_url . '" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <button onclick="playPause' . $id . '()" class="ctrl audio_control" data-play="' . $autoplay_bg_music . '" data-play="' . $autoplay_bg_music . '" id="audio_control' . $id . '"><i id="vr-volume' . $id . '" class="wpvrvolumeicon' . $id . ' fas fa-volume-up" style="color:#fff;"></i></button>
                            ';
                $html .= '</div>';
            }
        }




        $html .= '<div class="wpvr-hotspot-tweak-contents-wrapper" style="display: none">';
        $html .= '<i class="fa fa-times cross" data-id="' . $id . '"></i>';
        $html .= '<div class="wpvr-hotspot-tweak-contents-flex">';
        $html .= '<div class="wpvr-hotspot-tweak-contents">';
        ob_start();
        do_action('wpvr_hotspot_tweak_contents', $scene_data);
        $hotspot_content = ob_get_clean();
        $html .= $hotspot_content;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="custom-ifram-wrapper" style="display: none;">';
        $html .= '<i class="fa fa-times cross" data-id="' . $id . '"></i>';

        $html .= '<div class="custom-ifram-flex">';
        $html .= '<div class="custom-ifram">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';



        //script started
        $html .= '<script>';
        if (isset($postdata['bg_music'])) {
            if ($bg_music == 'on') {
                $html .= '
							var x' . $id . ' = document.getElementById("vrAudio' . $id . '");

							var playing' . $id . ' = false;

								function playPause' . $id . '() {

									if (playing' . $id . ') {
										jQuery("#vr-volume' . $id . '").removeClass("fas fa-volume-up");
										jQuery("#vr-volume' . $id . '").addClass("fas fa-volume-mute");
										x' . $id . '.pause();
                    jQuery("#audio_control' . $id . '").attr("data-play", "off");
										playing' . $id . ' = false;

									}
									else {
										jQuery("#vr-volume' . $id . '").removeClass("fas fa-volume-mute");
										jQuery("#vr-volume' . $id . '").addClass("fas fa-volume-up");
										x' . $id . '.play();
                    jQuery("#audio_control' . $id . '").attr("data-play", "on");
										playing' . $id . ' = true;
									}
								}

								function audionEnd' . $id . '() {
									playing' . $id . ' = false;
									jQuery("#vr-volume' . $id . '").removeClass("fas fa-volume-up");
									jQuery("#vr-volume' . $id . '").addClass("fas fa-volume-mute");
                  jQuery("#audio_control' . $id . '").attr("data-play", "off");
								}
								';

                if ($autoplay_bg_music == 'on') {
                    $html .= '
									document.getElementById("pano' . $id . '").addEventListener("click", musicPlay' . $id . ');
									function musicPlay' . $id . '() {
											playing' . $id . ' = true;
											document.getElementById("vrAudio' . $id . '").play();
											document.getElementById("pano' . $id . '").removeEventListener("click", musicPlay' . $id . ');
									}
									';
                }
            }
        }
        $html .= 'jQuery(document).ready(function() {';
        $html .= 'var response = ' . $response . ';';
        $html .= 'var scenes = response[1];';
        $html .= 'if(scenes) {';
        $html .= 'var scenedata = scenes.scenes;';
        $html .= 'for(var i in scenedata) {';
        $html .= 'var scenehotspot = scenedata[i].hotSpots;';
        $html .= 'for(var i = 0; i < scenehotspot.length; i++) {';
        $html .= 'if(scenehotspot[i]["clickHandlerArgs"] != "") {';

        $html .= 'scenehotspot[i]["clickHandlerFunc"] = wpvrhotspot;';
        $html .= '}';
        
        if (wpvr_isMobileDevice() && get_option( 'dis_on_hover' ) == "true") {
        } else {
            $html .= 'if(scenehotspot[i]["createTooltipArgs"] != "") {';
            $html .= 'scenehotspot[i]["createTooltipFunc"] = wpvrtooltip;';
            $html .= '}';
        }

        $html .= '}';
        $html .= '}';
        $html .= '}';
        $html .= 'var panoshow' . $id . ' = pannellum.viewer(response[0]["panoid"], scenes);';
        $html .= 'panoshow' . $id . '.on("load", function (){
            setTimeout(() => {
                window.dispatchEvent(new Event("resize"));
            }, 200);
						if (jQuery("#pano' . $id . '").children().children(".pnlm-panorama-info:visible").length > 0) {
	               jQuery("#controls' . $id . '").css("bottom", "55px");
	           }
	           else {
	             jQuery("#controls' . $id . '").css("bottom", "5px");
	           }
					});';

        $html .= 'panoshow' . $id . '.on("render", function (){
              window.dispatchEvent(new Event("resize"));
            });';

        $html .= '
					if (scenes.autoRotate) {
						panoshow' . $id . '.on("load", function (){
						 setTimeout(function(){ panoshow' . $id . '.startAutoRotate(scenes.autoRotate, 0); }, 3000);
						});
						panoshow' . $id . '.on("scenechange", function (){
						 setTimeout(function(){ panoshow' . $id . '.startAutoRotate(scenes.autoRotate, 0); }, 3000);
						});
					}
					';
        $html .= 'var touchtime = 0;';
        if ($vrgallery) {
            if (isset($panodata["scene-list"])) {
                foreach ($panodata["scene-list"] as $panoscenes) {
                    $scene_key = $panoscenes['scene-id'];
                    $scene_key_gallery = $panoscenes['scene-id'] . '_gallery_' . $id;
                    $img_src_url = $panoscenes['scene-attachment-url'];
                    // $html .= 'document.getElementById("'.$scene_key_gallery.'").addEventListener("click", function(e) { ';
                    // $html .= 'if (touchtime == 0) {';
                    // $html .= 'touchtime = new Date().getTime();';
                    // $html .= '} else {';
                    // $html .= 'if (((new Date().getTime()) - touchtime) < 800) {';
                    // $html .= 'panoshow'.$id.'.loadScene("'.$scene_key.'");';
                    // $html .= 'touchtime = 0;';
                    // $html .= '} else {';
                    // $html .= 'touchtime = new Date().getTime();';
                    // $html .= '}';
                    // $html .= '}';
                    // $html .= '});';
                    $html .= '
                    jQuery(document).on("click","#' . $scene_key_gallery . '",function() {
                        panoshow' . $id . '.loadScene("' . $scene_key . '");
    		        });
                    ';
                }
            }
        }

        //===Custom Control===//
        if (isset($custom_control)) {
            if ($custom_control['panupSwitch'] == "on") {
                $html .= 'document.getElementById("pan-up' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setPitch(panoshow' . $id . '.getPitch() + 10);';
                $html .= '});';
            }

            if ($custom_control['panDownSwitch'] == "on") {
                $html .= 'document.getElementById("pan-down' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setPitch(panoshow' . $id . '.getPitch() - 10);';
                $html .= '});';
            }

            if ($custom_control['panLeftSwitch'] == "on") {
                $html .= 'document.getElementById("pan-left' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setYaw(panoshow' . $id . '.getYaw() - 10);';
                $html .= '});';
            }

            if ($custom_control['panRightSwitch'] == "on") {
                $html .= 'document.getElementById("pan-right' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setYaw(panoshow' . $id . '.getYaw() + 10);';
                $html .= '});';
            }

            if ($custom_control['panZoomInSwitch'] == "on") {
                $html .= 'document.getElementById("zoom-in' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setHfov(panoshow' . $id . '.getHfov() - 10);';
                $html .= '});';
            }

            if ($custom_control['panZoomOutSwitch'] == "on") {
                $html .= 'document.getElementById("zoom-out' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.setHfov(panoshow' . $id . '.getHfov() + 10);';
                $html .= '});';
            }

            if ($custom_control['panFullscreenSwitch'] == "on") {
                $html .= 'document.getElementById("fullscreen' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.toggleFullscreen();';
                $html .= '});';
            }

            if ($custom_control['backToHomeSwitch'] == "on") {
                $html .= 'document.getElementById("backToHome' . $id . '").addEventListener("click", function(e) {';
                $html .= 'panoshow' . $id . '.loadScene("' . $default_scene . '");';
                $html .= '});';
            }

            if ($custom_control['gyroscopeSwitch'] == "on") {
                $html .= 'document.getElementById("gyroscope' . $id . '").addEventListener("click", function(e) {';
                $html .= '
                if (panoshow' . $id . '.isOrientationActive()) {
                    panoshow' . $id . '.stopOrientation();
                    document.getElementById("' . $custom_control['gyroscopeIcon'] . '").style.color = "red";
                }
                else {
                    panoshow' . $id . '.startOrientation();
                    document.getElementById("' . $custom_control['gyroscopeIcon'] . '").style.color = "' . $custom_control['gyroscopeColor'] . '";
                }

              ';
                $html .= '});';
            }
        }

        $angle_up = '<i class="fa fa-angle-up"></i>';
        $angle_down = '<i class="fa fa-angle-down"></i>';
        $sin_qout = "'";

        if ($vrgallery_display) {

            if (!$autoload) {
                $html .= '
                jQuery(document).ready(function($){
                    jQuery("#sccontrols' . $id . '").hide();
  		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_up . $sin_qout . ');
                    jQuery("#sccontrols' . $id . '").hide();
                    jQuery(".wpvr_slider_nav").hide();
                });
                ';

                $html .= '
    		          var slide' . $id . ' = "down";
    		          jQuery(document).on("click","#vrgcontrols' . $id . '",function() {

    		            if (slide' . $id . ' == "up") {
    		              jQuery(".vrgctrl' . $id . '").empty();
    		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_up . $sin_qout . ');
    		              slide' . $id . ' = "down";
    		            }
    		            else {
    		              jQuery(".vrgctrl' . $id . '").empty();
    		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_down . $sin_qout . ');
    		              slide' . $id . ' = "up";
    		            }
                        jQuery(".wpvr_slider_nav").slideToggle();
    		            jQuery("#sccontrols' . $id . '").slideToggle();
    		          });
    		          ';
            } else {
                $html .= '
                jQuery(document).ready(function($){
                  jQuery("#sccontrols' . $id . '").show();
                    jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_down . $sin_qout . ');
                    jQuery(".wpvr_slider_nav").show();
                });
                ';

                $html .= '
                var slide' . $id . ' = "down";
                jQuery(document).on("click","#vrgcontrols' . $id . '",function() {

                  if (slide' . $id . ' == "up") {
                    jQuery(".vrgctrl' . $id . '").empty();
                    jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_down . $sin_qout . ');
                    slide' . $id . ' = "down";
                  }
                  else {
                    jQuery(".vrgctrl' . $id . '").empty();
                    jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_up . $sin_qout . ');
                    slide' . $id . ' = "up";
                  }
                  jQuery(".wpvr_slider_nav").slideToggle();
                  jQuery("#sccontrols' . $id . '").slideToggle();
                });
                ';
            }
        } else {
            $html .= '
		          jQuery(document).ready(function($){
		              jQuery("#sccontrols' . $id . '").hide();
                      jQuery(".wpvr_slider_nav").hide();
		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_up . $sin_qout . ');
		          });
		          ';

            $html .= '
		          var slide' . $id . ' = "down";
		          jQuery(document).on("click","#vrgcontrols' . $id . '",function() {

		            if (slide' . $id . ' == "up") {
		              jQuery(".vrgctrl' . $id . '").empty();
		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_up . $sin_qout . ');
		              slide' . $id . ' = "down";
		            }
		            else {
		              jQuery(".vrgctrl' . $id . '").empty();
		              jQuery(".vrgctrl' . $id . '").html(' . $sin_qout . $angle_down . $sin_qout . ');
		              slide' . $id . ' = "up";
		            }
                    jQuery(".wpvr_slider_nav").slideToggle(); 
		            jQuery("#sccontrols' . $id . '").slideToggle();
		          });
		          ';
        }




        if (!$autoload) {
            $html .= '
                jQuery(document).ready(function(){
                    jQuery("#controls' . $id . '").hide();
                    jQuery("#zoom-in-out-controls' . $id . '").hide();
                    jQuery("#adcontrol' . $id . '").hide();
                    jQuery("#pano' . $id . '").find(".pnlm-panorama-info").hide();
                });

            ';

            if ($vrgallery_display) {
                $html .= 'var load_once = "true";';
                $html .= 'panoshow' . $id . '.on("load", function (){
                      if (load_once == "true") {
                        load_once = "false";
                        jQuery("#sccontrols' . $id . '").slideToggle();
                      }
              });';
            }

            $html .= 'panoshow' . $id . '.on("load", function (){
                    jQuery("#controls' . $id . '").show();
                    jQuery("#zoom-in-out-controls' . $id . '").show();
                    jQuery("#adcontrol' . $id . '").show();
                    jQuery("#pano' . $id . '").find(".pnlm-panorama-info").show();
            });';
        }

        //==Old code working properly==//
        $html .= '
            jQuery(".elementor-tab-title").click(function(){
                      var element_id;
                      var pano_id;
                      var element_id = this.id;
                      element_id = element_id.split("-");
                      element_id = element_id[3];
                      jQuery("#elementor-tab-content-"+element_id).children("div").addClass("awwww");
                      var pano_id = jQuery(".awwww").attr("id");
                      jQuery("#elementor-tab-content-"+element_id).children("div").removeClass("awwww");
                      if (pano_id != undefined) {
                        pano_id = pano_id.split("o");
                        pano_id = pano_id[1];
                        if (pano_id == "' . $id . '") {
                          jQuery("#pano' . $id . '").children(".pnlm-render-container").remove();
                          jQuery("#pano' . $id . '").children(".pnlm-ui").remove();
                          panoshow' . $id . ' = pannellum.viewer(response[0]["panoid"], scenes);
                          setTimeout(function() {
                                  panoshow' . $id . '.loadScene("' . $default_scene . '");
                                  window.dispatchEvent(new Event("resize"));
                                  if (jQuery("#pano' . $id . '").children().children(".pnlm-panorama-info:visible").length > 0) {
                                       jQuery("#controls' . $id . '").css("bottom", "55px");
                                   }
                                   else {
                                     jQuery("#controls' . $id . '").css("bottom", "5px");
                                   }
                          }, 200);
                        }
                      }
            });
        ';
        $html .= '
            jQuery(".geodir-tab-head dd, #vr-tour-tab").click(function(){
              jQuery("#pano' . $id . '").children(".pnlm-render-container").remove();
              jQuery("#pano' . $id . '").children(".pnlm-ui").remove();
              panoshow' . $id . ' = pannellum.viewer(response[0]["panoid"], scenes);
              setTimeout(function() {
                      panoshow' . $id . '.loadScene("' . $default_scene . '");
                      window.dispatchEvent(new Event("resize"));
                      if (jQuery("#pano' . $id . '").children().children(".pnlm-panorama-info:visible").length > 0) {
                           jQuery("#controls' . $id . '").css("bottom", "55px");
                       }
                       else {
                         jQuery("#controls' . $id . '").css("bottom", "5px");
                       }
              }, 200);
            });
        ';
        if (isset($postdata['previewtext']) && $postdata['previewtext'] != '') {
            $html .= '
            jQuery("#pano' . $id . '").children(".pnlm-ui").find(".pnlm-load-button p").text("' . $postdata['previewtext'] . '")
            ';
        }

        if ($default_global_zoom != '' || $max_global_zoom != '' || $min_global_zoom != '') {
            $html .= '
            jQuery(".globalzoom").val("on").change();
            ';
        }


        $html .= '});';
        $html .= '</script>';
        //script end

        return $html;
    }
}
