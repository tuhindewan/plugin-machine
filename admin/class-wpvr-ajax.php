<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * The admin-specific Ajax files.
 *
 * @link       http://rextheme.com/
 * @since      1.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/admin
 */

class Wpvr_Ajax
{

  /**
   * Preview show ajax function
   */
  function wpvr_show_preview()
  {
    $panoid = '';
    $postid = sanitize_text_field($_POST['postid']);
    $post_type = get_post_type($postid);

    $panoid = 'pano' . $postid;

    $control = sanitize_text_field($_POST['control']);
    if ($control == 'on') {
      $control = true;
    } else {
      $control = false;
    }

    $compass = sanitize_text_field($_POST['compass']);
    if ($compass == 'on') {
      $compass = true;
    } else {
      $compass = false;
    }

    $mouseZoom = sanitize_text_field($_POST['mouseZoom']);
    if ($mouseZoom == 'off') {
      $mouseZoom = false;
    } else {
      $mouseZoom = true;
    }

    $draggable = sanitize_text_field($_POST['draggable']);
    if ($draggable == 'off') {
      $draggable = false;
    } else {
      $draggable = true;  
    }

    $diskeyboard = sanitize_text_field($_POST['diskeyboard']);
    if ($diskeyboard == 'on') {
      $diskeyboard = true;
    } else {
      $diskeyboard = false;
    }

    $keyboardzoom = sanitize_text_field($_POST['keyboardzoom']);
    if ($keyboardzoom == 'off') {
      $keyboardzoom = false;
    } else {
      $keyboardzoom = true;
    }

    $autoload = sanitize_text_field($_POST['autoload']);
    if ($autoload == 'on') {
      $autoload = true;
    } else {
      $autoload = false;
    }

    $default_scene = '';
    // $default_scene = sanitize_text_field($_POST['defaultscene']);
    $preview = '';
    $preview = esc_url($_POST['preview']);

    $rotation = '';
    $rotation = sanitize_text_field($_POST['rotation']);

    $autorotation = '';
    $autorotation = sanitize_text_field($_POST['autorotation']);
    $autorotationinactivedelay = '';
    $autorotationinactivedelay = sanitize_text_field($_POST['autorotationinactivedelay']);
    $autorotationstopdelay = '';
    $autorotationstopdelay = sanitize_text_field($_POST['autorotationstopdelay']);

    $default_global_zoom = '';
    $max_global_zoom = '';
    $min_global_zoom = '';
    if (isset($_POST['gzoom']) == 'on') {
      $default_global_zoom = $_POST['dzoom'];
      $max_global_zoom = $_POST['maxzoom'];
      $min_global_zoom = $_POST['minzoom'];
    }
    if (!empty($autorotationinactivedelay) && !empty($autorotationstopdelay)) {
      wp_send_json_error('<span class="pano-error-title">Dual Action Error for Auto-Rotation</span><p> You can not use both Resume Auto-rotation & Stop Auto-rotation on the same tour. You can use only one of them.</p>');

      die();
    }

    $scene_fade_duration = '';
    $scene_fade_duration = sanitize_text_field($_POST['scenefadeduration']);

    $panodata = $_POST['panodata'];
    $panolist = stripslashes($panodata);
    $panodata = (array)json_decode($panolist);
    $panolist = array();
    if (is_array($panodata["scene-list"])) {
      foreach ($panodata["scene-list"] as $scenes_data) {
        $temp_array = array();
        $temp_array = (array)$scenes_data;
        if ($temp_array['hotspot-list']) {
          $_hotspot_array = array();
          foreach ($temp_array['hotspot-list'] as $temp_hotspot) {
            $temp_hotspot = (array)$temp_hotspot;
            $_hotspot_array[] = $temp_hotspot;
          }
        }
        $temp_array['hotspot-list'] = $_hotspot_array;
        $panolist['scene-list'][] = $temp_array;
      }
    }
    $panodata = $panolist;

    //===Error Control and Validation===//

    if ($panodata["scene-list"] != "") {
      foreach ($panodata["scene-list"] as $scenes_val) {

        $scene_id_validate = $scenes_val["scene-id"];


        if (!empty($scene_id_validate)) {
          $scene_id_validated = preg_replace('/[^0-9a-zA-Z_]/', "", $scene_id_validate);
          if ($scene_id_validated != $scene_id_validate) {
            wp_send_json_error('<span class="pano-error-title">Invalid Scene ID</span> <p>Scene ID can\'t contain spaces and special characters. <br/>Please assign a unique Scene ID with letters and numbers where Scene ID is : ' . $scene_id_validate . '</p>');
            die();
          }

          if ($scenes_val['scene-type'] == 'cubemap') {
            if (empty($scenes_val["scene-attachment-url-face0"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 0</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face1"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 1</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face2"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 2</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face3"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 3</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face4"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 4</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face5"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 5</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }
          } else {
            if (empty($scenes_val["scene-attachment-url"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Scene Image</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-pitch"])) {
            $validate_scene_pitch = $scenes_val["scene-pitch"];
            $validated_scene_pitch = preg_replace('/[^0-9.-]/', '', $validate_scene_pitch);
            if ($validated_scene_pitch != $validate_scene_pitch) {
              wp_send_json_error('<span class="pano-error-title">Invalid Pitch Value</span><p> The Pitch Value can only contain float numbers where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-yaw"])) {
            $validate_scene_yaw = $scenes_val["scene-yaw"];
            $validated_scene_yaw = preg_replace('/[^0-9.-]/', '', $validate_scene_yaw);
            if ($validated_scene_yaw != $validate_scene_yaw) {
              wp_send_json_error('<span class="pano-error-title">Invalid Yaw Value</span><p> The Yaw Value can only contain float numbers where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-zoom"])) {
            $validate_default_zoom = $scenes_val["scene-zoom"];
            $validated_default_zoom = preg_replace('/[^0-9-]/', '', $validate_default_zoom);
            if ($validated_default_zoom != $validate_default_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Default Zoom Value</span><p> You can only set Default Zoom in Degree values from 50 to 120 where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
            $default_zoom_value = (int)$scenes_val["scene-zoom"];
            if ($default_zoom_value > 120 || $default_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Invalid Default Zoom Value</span><p> You can only set Default Zoom in Degree values from 50 to 120 where Scene ID: ' . $scene_id_validate . '</p>');

              die();
            }
          }

          if (!empty($scenes_val["scene-maxzoom"])) {
            $validate_max_zoom = $scenes_val["scene-maxzoom"];
            $validated_max_zoom = preg_replace('/[^0-9-]/', '', $validate_max_zoom);
            if ($validated_max_zoom != $validate_max_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Max-zoom Value:</span><p> You can only set Max-zoom in degree values (50-120) where Scene ID: ' . $scene_id_validate . '</p>');

              die();
            }
            $max_zoom_value = (int)$scenes_val["scene-maxzoom"];
            if ($max_zoom_value > 120) {
              wp_send_json_error('<span class="pano-error-title">Max-zoom Value Limit Exceeded</span><p> You can set the Max-zoom Value up to 120 degrees.</p>');
              die();
            }

            if ($max_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Max-zoom Value Limit Exceeded</span><p> You can not set the Max-zoom Value lower than 50 degrees.</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-minzoom"])) {
            $validate_min_zoom = $scenes_val["scene-minzoom"];
            $validated_min_zoom = preg_replace('/[^0-9-]/', '', $validate_min_zoom);
            if ($validated_min_zoom != $validate_min_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Min-zoom Value</span><p> You can only set Min-zoom in degree values (50-120) where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
            $min_zoom_value = (int)$scenes_val["scene-minzoom"];
            if ($min_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Low Min-Zoom Value</span><p> The Min-zoom value must be more than 50 in degree values where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }

            if ($min_zoom_value > 120) {
              wp_send_json_error('<span class="pano-error-title">High Min-Zoom Value</span><p> The Min-zoom value must be less than 120 in degree values where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if ($scenes_val["hotspot-list"] != "") {
            foreach ($scenes_val["hotspot-list"] as $hotspot_val) {

              $hotspot_title_validate = $hotspot_val["hotspot-title"];


              if (!empty($hotspot_title_validate)) {
                $hotspot_title_validated = preg_replace('/[^0-9a-zA-Z_]/', "", $hotspot_title_validate);
                if ($hotspot_title_validated != $hotspot_title_validate) {
                  wp_send_json_error('<span class="pano-error-title">Invalid Hotspot ID</span> <p>Hotspot ID can\'t contain spaces and special characters. <br/>Please assign a unique Hotspot ID with letters and numbers where Scene id: ' . $scene_id_validate . ' Hotspot ID is: ' . $hotspot_title_validate . '</p>');
                  die();
                }

                $hotspot_pitch_validate = $hotspot_val["hotspot-pitch"];
                if (!empty($hotspot_pitch_validate)) {
                  $hotspot_pitch_validated = preg_replace('/[^0-9.-]/', '', $hotspot_pitch_validate);
                  if ($hotspot_pitch_validated != $hotspot_pitch_validate) {
                    wp_send_json_error('<span class="pano-error-title">Invalid Pitch Value</span> <p>The Pitch Value can only contain float numbers where Scene ID: ' . $scene_id_validate . ' Hotspot ID is: ' . $hotspot_title_validate . '</p>');

                    die();
                  }
                }

                $hotspot_yaw_validate = $hotspot_val["hotspot-yaw"];
                if (!empty($hotspot_yaw_validate)) {
                  $hotspot_yaw_validated = preg_replace('/[^0-9.-]/', '', $hotspot_yaw_validate);
                  if ($hotspot_yaw_validated != $hotspot_yaw_validate) {
                    wp_send_json_error('<span class="pano-error-title">Invalid Yaw Value</span> <p>The Yaw Value can only contain float numbers where Scene ID: ' . $scene_id_validate . ' Hotspot ID is: ' . $hotspot_title_validate . '</p>');

                    die();
                  }
                }

                if (is_plugin_active('wpvr-pro/wpvr-pro.php')) {
                  $status  = get_option('wpvr_edd_license_status');
                  if ($status !== false && $status == 'valid') {
                    if ($hotspot_val["hotspot-customclass-pro"] != 'none' && !empty($hotspot_val["hotspot-customclass"])) {
                      wp_send_json_error('<span class="pano-error-title">Warning!</span> <p>You can not use both Custom Icon and Custom Icon Class for a hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                      die();
                    }
                  }
                }
                $hotspot_type_validate = $hotspot_val["hotspot-type"];
                $hotspot_url_validate = $hotspot_val["hotspot-url"];
                if (!empty($hotspot_url_validate)) {
                  $hotspot_url_validated = esc_url($hotspot_url_validate);
                  if ($hotspot_url_validated != $hotspot_url_validate) {
                    wp_send_json_error('<p><span>Warning:</span> Hotspot Url is invalid where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }
                $hotspot_content_validate = $hotspot_val["hotspot-content"];

                $hotspot_scene_validate = $hotspot_val["hotspot-scene"];

                if ($hotspot_type_validate == "info") {
                  if (!empty($hotspot_scene_validate)) {
                    wp_send_json_error('<p><span>Warning:</span> Don\'t add Target Scene ID on info type hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                  if (!empty($hotspot_url_validate) && !empty($hotspot_content_validate)) {
                    wp_send_json_error('<span class="pano-error-title">Warning!</span> <p>You can not set both On Click Content and URL on a hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }

                if ($hotspot_type_validate == "scene") {
                  if (empty($hotspot_scene_validate)) {
                    wp_send_json_error('<span class="pano-error-title">Target Scene Missing</span> <p>Assign a Target Scene to the Scene-type Hotspot where Scene ID: ' . $scene_id_validate . ' and Hotspot ID : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                  if (!empty($hotspot_url_validate) || !empty($hotspot_content_validate)) {
                    wp_send_json_error('<p><span>Warning:</span> Don\'t add Url or On click content on scene type hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }
              }
            }
          }
        }
      }
    }
    //===Error Control and Validation===//
    foreach ($panodata["scene-list"] as $panoscenes) {
      if (empty($panoscenes['scene-id']) && !empty($panoscenes['scene-attachment-url'])) {
        wp_send_json_error('<span class="pano-error-title">Missing Scene ID</span> <p>Please assign a unique Scene ID to your uploaded scene.</p>');
        die();
      }
    }

    $allsceneids = array();

    foreach ($panodata["scene-list"] as $panoscenes) {
      if (!empty($panoscenes['scene-id'])) {
        array_push($allsceneids, $panoscenes['scene-id']);
      }
    }

    foreach ($panodata["scene-list"] as $panoscenes) {

      if ($panoscenes['dscene'] == 'on') {
        $default_scene = $panoscenes['scene-id'];
      }
    }
    if (empty($default_scene)) {
      if ($allsceneids) {
        $default_scene = $allsceneids[0];
      } else {
        wp_send_json_error('<span class="pano-error-title">Missing Image & Scene ID</span> <p>Please Upload An Image and Set A Scene ID To See The Preview</p>');
        die();
      }
    }

    $allsceneids_count = array_count_values($allsceneids);
    foreach ($allsceneids_count as $key => $value) {
      if ($value > 1) {
        wp_send_json_error('<span class="pano-error-title">Duplicate Scene ID</span> <p>You\'ve assigned a duplicate Scene ID. <br/>Please assign unique Scene IDs to each scene. </p>');
        die();
      }
    }

    foreach ($panodata["scene-list"] as $panoscenes) {
      if (!empty($panoscenes['scene-id'])) {
        $allhotspot = array();
        foreach ($panoscenes["hotspot-list"] as $hotspot_val) {

          if (!empty($hotspot_val["hotspot-title"])) {
            array_push($allhotspot, $hotspot_val["hotspot-title"]);
          }
        }
        $allhotspotcount = array_count_values($allhotspot);
        foreach ($allhotspotcount as $key => $value) {
          if ($value > 1) {
            wp_send_json_error('<span class="pano-error-title">Duplicate Hotspot ID</span> <p>You\'ve assigned a duplicate Hotspot ID. <br/>Please assign unique Hotspot IDs to each Hotspot.</p>');
            die();
          }
        }
      }
    }

    $default_data = array();
    if ($_POST['gzoom'] == 'on') {
      $default_data = array("firstScene" => $default_scene, "sceneFadeDuration" => $scene_fade_duration, "hfov" => $default_global_zoom, "maxHfov" => $max_global_zoom, "minHfov" => $min_global_zoom);
    } else {
      $default_data = array("firstScene" => $default_scene, "sceneFadeDuration" => $scene_fade_duration);
    }
    $scene_data = array();
    foreach ($panodata["scene-list"] as $panoscenes) {
      if (!empty($panoscenes['scene-id'])) {
        $scene_ititle = '';
        $scene_ititle = sanitize_text_field($panoscenes["scene-ititle"]);
        $scene_author = '';
        $scene_author = sanitize_text_field($panoscenes["scene-author"]);

        $scene_vaov = 180;
        $scene_vaov = (float)$panoscenes["scene-vaov"];

        $scene_haov = 360;
        $scene_haov = (float)$panoscenes["scene-haov"];

        $scene_vertical_offset = 0;
        $scene_vertical_offset = (float)$panoscenes["scene-vertical-offset"];

        $default_scene_pitch = null;
        $default_scene_pitch = (float)$panoscenes["scene-pitch"];

        $default_scene_yaw = null;
        $default_scene_yaw = (float)$panoscenes["scene-yaw"];

        $scene_max_pitch = '';
        $scene_max_pitch = (float)$panoscenes["scene-maxpitch"];

        $scene_min_pitch = '';
        $scene_min_pitch = (float)$panoscenes["scene-minpitch"];

        $scene_max_yaw = '';
        $scene_max_yaw = (float)$panoscenes["scene-maxyaw"];

        $scene_min_yaw = '';
        $scene_min_yaw = (float)$panoscenes["scene-minyaw"];

        $default_zoom = 100;
        $default_zoom = $panoscenes["scene-zoom"];
        if (!empty($default_zoom)) {
          $default_zoom = (int)$panoscenes["scene-zoom"];
        } else {
          $default_zoom = 100;
        }

        $max_zoom = 120;
        $max_zoom = $panoscenes["scene-maxzoom"];
        if (!empty($max_zoom)) {
          $max_zoom = (int)$panoscenes["scene-maxzoom"];
        } else {
          $max_zoom = 120;
        }

        $min_zoom = 50;
        $min_zoom = $panoscenes["scene-minzoom"];
        if (!empty($min_zoom)) {
          $min_zoom = (int)$panoscenes["scene-minzoom"];
        } else {
          $min_zoom = 50;
        }

        $hotspot_datas = $panoscenes["hotspot-list"];

        $hotspots = array();
        foreach ($hotspot_datas as $hotspot_data) {

          if (!empty($hotspot_data["hotspot-title"])) {

            $hotspot_type = $hotspot_data["hotspot-type"] !== 'scene' ? 'info' : $hotspot_data["hotspot-type"];
            $hotspot_content = '';

            ob_start();
            do_action('wpvr_hotspot_content_admin', $hotspot_data);
            $hotspot_content = ob_get_clean();


            if (!$hotspot_content) $hotspot_content = $hotspot_data["hotspot-content"];


            $hotspot_info = array(
              "text" => $hotspot_data["hotspot-title"],
              "pitch" => $hotspot_data["hotspot-pitch"],
              "yaw" => $hotspot_data["hotspot-yaw"],
              "type" => $hotspot_type,
              "URL" => $hotspot_data["hotspot-url"],
              "clickHandlerArgs" => $hotspot_content,
              "createTooltipArgs" => $hotspot_data["hotspot-hover"],
              "sceneId" => $hotspot_data["hotspot-scene"],
              "targetPitch" => (float)$hotspot_data["hotspot-scene-pitch"],
              "targetYaw" => (float)$hotspot_data["hotspot-scene-yaw"],
              'hotspot_type' => $hotspot_data['hotspot-type']
            );

            array_push($hotspots, $hotspot_info);
            if (empty($hotspot_data["hotspot-scene"])) {
              unset($hotspot_info['targetPitch']);
              unset($hotspot_info['targetYaw']);
            }
          }
        }

        $scene_info = array();
        if ($panoscenes["scene-type"] == 'cubemap') {
          $pano_type = 'cubemap';
          $pano_attachment = array(
            $panoscenes["scene-attachment-url-face0"],
            $panoscenes["scene-attachment-url-face1"],
            $panoscenes["scene-attachment-url-face2"],
            $panoscenes["scene-attachment-url-face3"],
            $panoscenes["scene-attachment-url-face4"],
            $panoscenes["scene-attachment-url-face5"]
          );

          $scene_info = array("type" => $panoscenes["scene-type"], "cubeMap" => $pano_attachment, "pitch" => $default_scene_pitch, "maxPitch" => $scene_max_pitch, "minPitch" => $scene_min_pitch, "maxYaw" => $scene_max_yaw, "minYaw" => $scene_min_yaw, "yaw" => $default_scene_yaw, "hfov" => $default_zoom, "maxHfov" => $max_zoom, "minHfov" => $min_zoom, "title" => $scene_ititle, "author" => $scene_author, "vaov" => $scene_vaov, "haov" => $scene_haov, "vOffset" => $scene_vertical_offset, "hotSpots" => $hotspots);
        } else {
          $scene_info = array("type" => $panoscenes["scene-type"], "panorama" => $panoscenes["scene-attachment-url"], "pitch" => $default_scene_pitch, "maxPitch" => $scene_max_pitch, "minPitch" => $scene_min_pitch, "maxYaw" => $scene_max_yaw, "minYaw" => $scene_min_yaw, "yaw" => $default_scene_yaw, "hfov" => $default_zoom, "maxHfov" => $max_zoom, "minHfov" => $min_zoom, "title" => $scene_ititle, "author" => $scene_author, "vaov" => $scene_vaov, "haov" => $scene_haov, "vOffset" => $scene_vertical_offset, "hotSpots" => $hotspots);
        }


        if ($panoscenes["ptyscene"] == "off") {
          unset($scene_info['pitch']);
          unset($scene_info['yaw']);
        }

        if (empty($panoscenes["scene-ititle"])) {
          unset($scene_info['title']);
        }
        if (empty($panoscenes["scene-author"])) {
          unset($scene_info['author']);
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

        if ($panoscenes["cvgscene"] == "off") {
          unset($scene_info['maxPitch']);
          unset($scene_info['minPitch']);
        }
        if (empty($panoscenes["scene-maxpitch"])) {
          unset($scene_info['maxPitch']);
        }

        if (empty($panoscenes["scene-minpitch"])) {
          unset($scene_info['minPitch']);
        }

        if ($panoscenes["chgscene"] == "off") {
          unset($scene_info['maxYaw']);
          unset($scene_info['minYaw']);
        }
        if (empty($panoscenes["scene-maxyaw"])) {
          unset($scene_info['maxYaw']);
        }

        if (empty($panoscenes["scene-minyaw"])) {
          unset($scene_info['minYaw']);
        }

        // if ($panoscenes["czscene"] == "off") {
        //   unset($scene_info['hfov']);
        //   unset($scene_info['maxHfov']);
        //   unset($scene_info['minHfov']);
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
    $pano_response = array("autoLoad" => $autoload, "defaultZoom" => $default_global_zoom, "minZoom" => $min_global_zoom, "maxZoom" => $max_global_zoom, "showControls" => $control, "compass" => $compass, "mouseZoom" => $mouseZoom, "draggable" => $draggable, "disableKeyboardCtrl" => $diskeyboard, 'keyboardZoom' => $keyboardzoom, "preview" => $preview, "autoRotate" => $autorotation, "autoRotateInactivityDelay" => $autorotationinactivedelay, "autoRotateStopDelay" => $autorotationstopdelay, "default" => $default_data, "scenes" => $scene_data);

    if ($rotation == 'off') {
      unset($pano_response['autoRotate']);
      unset($pano_response['autoRotateInactivityDelay']);
      unset($pano_response['autoRotateStopDelay']);
    }
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

    // if($_POST['gzoom'] == 'off' ){
    //   unset($pano_response['defaultZoom']);
    //   unset($pano_response['minZoom']);
    //   unset($pano_response['maxZoom']);
    // }
    $response = array();
    $response = array($pano_id_array, $pano_response);
    wp_send_json_success($response);
  }

  /**
   * Video Preview show ajax function
   */
  function wpvrvideo_preview()
  {
    $panoid = '';
    $postid = sanitize_text_field($_POST['postid']);
    $panoid = 'pano' . $postid;
    $randid = rand(1000, 1000000);
    $vidid = 'vid' . $randid;
    $videourl = esc_url_raw($_POST['videourl']);
    $autoplay = sanitize_text_field($_POST['autoplay']);
    $loop = sanitize_text_field($_POST['loop']);

    $vidtype = '';
    if (strpos($videourl, 'youtube') > 0) {
      $vidtype = 'youtube';
      $explodeid = '';
      $explodeid = explode("=", $videourl);

      if ($autoplay == 'on') {
        $autoplay = '&autoplay=1';
        $muted = '&mute=1';
      } else {
        $autoplay = '';
        $muted = '';
      }

      if ($loop == 'on') {
        $loop = '&loop=1';
      } else {
        $loop = '';
      }

      $foundid = '';
      $foundid = $explodeid[1] . '?' . $autoplay . $loop;
      $html = '';
      $html .= '
            <iframe src="https://www.youtube.com/embed/' . $explodeid[1] . '?rel=0&modestbranding=1' . $loop . '&autohide=1' . $muted . '&showinfo=0&controls=1' . $autoplay . '"  width="600" height="400"  frameborder="0" allowfullscreen></iframe>
        ';
    } elseif (strpos($videourl, 'youtu.be') > 0) {
      $vidtype = 'youtube';
      $explodeid = '';
      $explodeid = explode("/", $videourl);

      if ($autoplay == 'on') {
        $autoplay = '&autoplay=1';
      } else {
        $autoplay = '';
      }

      if ($loop == 'on') {
        $loop = '&loop=1';
      } else {
        $loop = '';
      }

      $foundid = '';
      $foundid = $explodeid[3] . '?' . $autoplay . $loop;
      $html = '';
      $html .= '<iframe width="600" height="400" src="https://www.youtube.com/embed/' . $foundid . '" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    } elseif (strpos($videourl, 'vimeo') > 0) {
      $vidtype = 'vimeo';
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
      $html .= '<iframe src="https://player.vimeo.com/video/' . $foundid . '" width="600" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    } else {
      $vidtype = 'selfhost';

      if ($autoplay == 'on') {
        $autoplay = 'autoplay';
      } else {
        $autoplay = '';
      }


      if ($loop == 'on') {
        $loop = 'loop';
      } else {
        $loop = '';
      }

      $html = '';
      $html .= '<video id="' . $vidid . '" class="video-js vjs-default-skin vjs-big-play-centered" ' . $autoplay . ' ' . $loop . ' controls preload="none" style="width:100%;height:400px;" poster="" >';
      $html .= '<source src="' . $videourl . '" type="video/mp4"/>';
      $html .= '<p class="vjs-no-js">';
      $html .= 'To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com html5-video-support/" target="_blank">supports HTML5 video</a>';
      $html .= '</p>';
      $html .= '</video>';
    }

    $response = array();
    $response = array(__("panoid") => $panoid, __("panodata") => $html, __("vidid") => $vidid, __("vidtype") => $vidtype);
    wp_send_json_success($response);
  }

  function wpvr_save_data()
  {

    $panoid = '';
    $html = '';
    $postid = sanitize_text_field($_POST['postid']);
    $prevtext = sanitize_text_field($_POST['previewtext']);
    // error_log(print_r($_POST['customColor'],1));
    $previewtext = '';
    if (strlen($prevtext) <= 50) {
      $previewtext = $prevtext;
    }
    $post_type = get_post_type($postid);
    if ($post_type != 'wpvr_item') {
      die();
    }
    $panoid = 'pano' . $postid;

    $default_global_zoom = '';
    $max_global_zoom = '';
    $min_global_zoom = '';
    if (isset($_POST['gzoom']) == 'on') {
      $default_global_zoom = $_POST['dzoom'];
      $max_global_zoom = $_POST['maxzoom'];
      $min_global_zoom = $_POST['minzoom'];
    }

    if (isset($_POST['streetview'])) {
      $streetview = $_POST['streetview'];
      if ($streetview == 'on') {
        $streetviewurl = esc_url_raw($_POST['streetviewurl']);
        if ($streetviewurl) {
          $html .= '<iframe src="' . $streetviewurl . '" width="600" height="400" frameborder="0" style="border:0;" allowfullscreen=""></iframe>';
        }
        $streetviewarray = array();
        $streetviewarray = array(__("panoid") => $panoid, __("streetviewdata") => $html, __("streetviewurl") => $streetviewurl, __("streetview") => $streetview);
        update_post_meta($postid, 'panodata', $streetviewarray);
        die();
      }
    }


    $pnovideo = $_POST['panovideo'];
    if ($pnovideo == "on") {

      $vidid = 'vid' . $postid;
      $videourl = esc_url_raw($_POST['videourl']);
      $autoplay = sanitize_text_field($_POST['autoplay']);
      $vidautoplay = sanitize_text_field($_POST['autoplay']);
      $loop = sanitize_text_field($_POST['loop']);
      $vidloop = sanitize_text_field($_POST['loop']);
      $vidtype = '';

      if (strpos($videourl, 'youtube') > 0) {
        $vidtype = 'youtube';
        $explodeid = '';
        $explodeid = explode("=", $videourl);
        $foundid = '';

        if ($autoplay == 'on') {
          $autoplay = '&autoplay=1';
        } else {
          $autoplay = '';
        }

        if ($loop == 'on') {
          $loop = '&loop=1';
        } else {
          $loop = '';
        }

        $foundid = $explodeid[1] . '?' . $autoplay . $loop;
        $html = '';
        $html .= '<iframe width="600" height="400" src="https://www.youtube.com/embed/' . $foundid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
      } elseif (strpos($videourl, 'youtu.be') > 0) {
        $vidtype = 'youtube';
        $explodeid = '';
        $explodeid = explode("/", $videourl);
        $foundid = '';

        if ($autoplay == 'on') {
          $autoplay = '&autoplay=1';
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
        $html .= '<iframe width="600" height="400" src="https://www.youtube.com/embed/' . $foundid . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
      } elseif (strpos($videourl, 'vimeo') > 0) {
        $vidtype = 'vimeo';
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
        $html .= '<iframe src="https://player.vimeo.com/video/' . $foundid . '" width="600" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
      } else {
        $vidtype = 'selfhost';
        $vidautoplay = '';
        // $vidautoplay = sanitize_text_field($_POST['vidautoplay']);
        $vidautoplay = sanitize_text_field($_POST['autoplay']);

        if ($autoplay == 'on') {
          $autoplay = 'autoplay muted';
        } else {
          $autoplay = '';
        }

        if ($loop == 'on') {
          $loop = 'loop';
        } else {
          $loop = '';
        }

        $html = '';
        $html .= '<video id="' . $vidid . '" class="video-js vjs-default-skin vjs-big-play-centered" ' . $autoplay . ' ' . $loop . ' controls preload="auto" style="width:100%;height:100%;" poster="" >';
        $html .= '<source src="' . $videourl . '" type="video/mp4"/>';
        $html .= '<p class="vjs-no-js">';
        $html .= 'To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com html5-video-support/" target="_blank">supports HTML5 video</a>';
        $html .= '</p>';
        $html .= '</video>';
      }



      $videoarray = array();
      $videoarray = array(__("panoid") => $panoid, __("panoviddata") => $html, __("vidid") => $vidid, __("vidurl") => $videourl, __("autoplay") => $autoplay, __("loop") => $vidloop, __("vidtype") => $vidtype);
      update_post_meta($postid, 'panodata', $videoarray);
      die();
    }


    $control = sanitize_text_field($_POST['control']);
    if ($control == 'on') {
      $control = true;
    } else {
      $control = false;
    }

    //===Custom Control===//
    $custom_control = $_POST['customcontrol'];

    //===Custom Control End===//

    $vrgallery = sanitize_text_field($_POST['vrgallery']);
    if ($vrgallery == 'on') {
      $vrgallery = true;
    } else {
      $vrgallery = false;
    }

    $vrgallery_title = sanitize_text_field($_POST['vrgallery_title']);
    if ($vrgallery_title == 'on') {
      $vrgallery_title = true;
    } else {
      $vrgallery_title = false;
    }

    $vrgallery_display = sanitize_text_field($_POST['vrgallery_display']);
    if ($vrgallery_display == 'on') {
      $vrgallery_display = true;
    } else {
      $vrgallery_display = false;
    }

    $gyro = false;
    if (isset($_POST['gyro'])) {
      $gyro = sanitize_text_field($_POST['gyro']);
    }

    $deviceorientationcontrol = sanitize_text_field($_POST['deviceorientationcontrol']);

    if ($gyro == 'on') {
      if (!is_ssl()) {
        wp_send_json_error('<p><span>Warning:</span> Please add SSL to enable Gyroscope for WP VR. </p>');
        die();
      }
      $gyro = true;
      if ($deviceorientationcontrol == 'on') {
        $deviceorientationcontrol = true;
      } else {
        $deviceorientationcontrol = false;
      }
    } else {
      $gyro = false;
      $deviceorientationcontrol = false;
    }

    $compass = sanitize_text_field($_POST['compass']);
    if ($compass == 'on') {
      $compass = true;
    } else {
      $compass = false;
    }

    $mouseZoom = sanitize_text_field($_POST['mouseZoom']);
    if ($mouseZoom == 'off') {
      $mouseZoom = false;
    } else {
      $mouseZoom = true;
    }

    $draggable = sanitize_text_field($_POST['draggable']);
    if ($draggable == 'off') {
      $draggable = false;
    } else {
      $draggable = true;
    }

    $diskeyboard = sanitize_text_field($_POST['diskeyboard']);
    if ($diskeyboard == 'on') {
      $diskeyboard = true;
    } else {
      $diskeyboard = false;
    }

    $keyboardzoom = sanitize_text_field($_POST['keyboardzoom']);

    if ($keyboardzoom == 'off') {
      $keyboardzoom = false;
    } else {
      $keyboardzoom = true;
    }

    $autoload = sanitize_text_field($_POST['autoload']);
    if ($autoload == 'on') {
      $autoload = true;
    } else {
      $autoload = false;
    }

    $default_scene = '';

    $preview = '';
    $preview = esc_url($_POST['preview']);

    $rotation = '';
    $rotation = sanitize_text_field($_POST['rotation']);

    $autorotation = '';
    $autorotation = sanitize_text_field($_POST['autorotation']);
    $autorotationinactivedelay = '';
    $autorotationinactivedelay = sanitize_text_field($_POST['autorotationinactivedelay']);
    $autorotationstopdelay = '';
    $autorotationstopdelay = sanitize_text_field($_POST['autorotationstopdelay']);



    if (!empty($autorotationinactivedelay) && !empty($autorotationstopdelay)) {
      wp_send_json_error('<span class="pano-error-title">Dual Action Error for Auto-Rotation</span><p> You can not use both Resume Auto-rotation & Stop Auto-rotation on the same tour. You can use only one of them.</p>');
      die();
    }

    //===Company Logo===//
    $cpLogoSwitch = 'off';
    $cpLogoSwitch = $_POST['cpLogoSwitch'];
    $cpLogoImg = '';
    $cpLogoImg = $_POST['cpLogoImg'];
    $cpLogoContent = '';
    $cpLogoContent = sanitize_text_field($_POST['cpLogoContent']);
    //===Company Logo===//

    //===background tour ===//
    $bg_tour_enabler = sanitize_text_field($_POST['wpvr_bg_tour_enabler']);
    // $bg_tour_navmenu = sanitize_text_field($_POST['wpvr_bg_tour_navmenu_enabler']);
    $bg_tour_title = sanitize_text_field($_POST['bg_tour_title']);
    $bg_tour_subtitle = sanitize_text_field($_POST['bg_tour_subtitle']);
    //===background tour end ===//

    // update_post_meta($postid,'hotspot_colors',$_POST['customColor']);

    $scene_fade_duration = '';
    $scene_fade_duration = $_POST['scenefadeduration'];

    $panodata = $_POST['panodata'];
    $panolist = stripslashes($panodata);
    $panodata = (array)json_decode($panolist);
    $panolist = array();
    if (is_array($panodata["scene-list"])) {
      foreach ($panodata["scene-list"] as $scenes_data) {
        $temp_array = array();
        $temp_array = (array)$scenes_data;
        // $scene_id_ = $temp_array["scene-id"];

        if ($temp_array['hotspot-list']) {
          $_hotspot_array = array();
          foreach ($temp_array['hotspot-list'] as $temp_hotspot) {

            $temp_hotspot = (array)$temp_hotspot;
            $_hotspot_array[] = $temp_hotspot;
          }
        }

        $temp_array['hotspot-list'] = $_hotspot_array;
        $panolist['scene-list'][] = $temp_array;
      }
    }
    $panodata = $panolist;

    //===Error Control and Validation===//

    if ($panodata["scene-list"] != "") {
      foreach ($panodata["scene-list"] as $scenes_val) {

        $scene_id_validate = $scenes_val["scene-id"];
        if (!empty($scene_id_validate)) {
          $scene_id_validated = preg_replace('/[^0-9a-zA-Z_]/', "", $scene_id_validate);
          if ($scene_id_validated != $scene_id_validate) {
            wp_send_json_error('<span class="pano-error-title">Invalid Scene ID</span> <p>Scene ID can\'t contain spaces and special characters. <br/>Please assign a unique Scene ID with letters and numbers where Scene ID is : ' . $scene_id_validate . '</p>');
            die();
          }

          if ($scenes_val['scene-type'] == 'cubemap') {
            if (empty($scenes_val["scene-attachment-url-face0"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 0</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face1"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 1</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face2"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 2</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face3"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 3</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face4"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 4</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }

            if (empty($scenes_val["scene-attachment-url-face5"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Cubemap Scene Face 5</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }
          } else {
            if (empty($scenes_val["scene-attachment-url"])) {
              wp_send_json_error('<span class="pano-error-title">Missing Scene Image</span><p> Please upload a 360 Degree image where Scene ID is: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-pitch"])) {
            $validate_scene_pitch = $scenes_val["scene-pitch"];
            $validated_scene_pitch = preg_replace('/[^0-9.-]/', '', $validate_scene_pitch);
            if ($validated_scene_pitch != $validate_scene_pitch) {
              wp_send_json_error('<span class="pano-error-title">Invalid Pitch Value</span><p> The Pitch Value can only contain float numbers where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-yaw"])) {
            $validate_scene_yaw = $scenes_val["scene-yaw"];
            $validated_scene_yaw = preg_replace('/[^0-9.-]/', '', $validate_scene_yaw);
            if ($validated_scene_yaw != $validate_scene_yaw) {
              wp_send_json_error('<span class="pano-error-title">Invalid Yaw Value</span><p> The Yaw Value can only contain float numbers where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-zoom"])) {
            $validate_default_zoom = $scenes_val["scene-zoom"];
            $validated_default_zoom = preg_replace('/[^0-9-]/', '', $validate_default_zoom);
            if ($validated_default_zoom != $validate_default_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Default Zoom Value</span><p> You can only set Default Zoom in Degree values from 50 to 120 where Scene ID: ' . $scene_id_validate . '</p>');

              die();
            }
            $default_zoom_value = (int)$scenes_val["scene-zoom"];
            if ($default_zoom_value > 120 || $default_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Invalid Default Zoom Value</span><p> You can only set Default Zoom in Degree values from 50 to 120 where Scene ID: ' . $scene_id_validate . '</p>');

              die();
            }
          }

          if (!empty($scenes_val["scene-maxzoom"])) {
            $validate_max_zoom = $scenes_val["scene-maxzoom"];
            $validated_max_zoom = preg_replace('/[^0-9-]/', '', $validate_max_zoom);
            if ($validated_max_zoom != $validate_max_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Max-zoom Value:</span><p> You can only set Max-zoom in degree values (50-120) where Scene ID: ' . $scene_id_validate . '</p>');

              die();
            }
            $max_zoom_value = (int)$scenes_val["scene-maxzoom"];
            if ($max_zoom_value > 120) {
              wp_send_json_error('<span class="pano-error-title">Max-zoom Value Limit Exceeded</span><p> You can set the Max-zoom Value up to 120 degrees.</p>');

              die();
            }

            if ($max_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Max-zoom Value Limit Exceeded</span><p> You can not set the Max-zoom Value lower than 50 degrees.</p>');
              die();
            }
          }

          if (!empty($scenes_val["scene-minzoom"])) {
            $validate_min_zoom = $scenes_val["scene-minzoom"];
            $validated_min_zoom = preg_replace('/[^0-9-]/', '', $validate_min_zoom);
            if ($validated_min_zoom != $validate_min_zoom) {
              wp_send_json_error('<span class="pano-error-title">Invalid Min-zoom Value</span><p> You can only set Min-zoom in degree values (50-120) where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
            $min_zoom_value = (int)$scenes_val["scene-minzoom"];
            if ($min_zoom_value < 50) {
              wp_send_json_error('<span class="pano-error-title">Low Min-Zoom Value</span><p> The Min-zoom value must be more than 50 in degree values where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }

            if ($min_zoom_value > 120) {
              wp_send_json_error('<span class="pano-error-title">Hight Min-Zoom Value</span><p> The Min-zoom value must be less than 120 in degree values where Scene ID: ' . $scene_id_validate . '</p>');
              die();
            }
          }

          if ($scenes_val["hotspot-list"] != "") {
            foreach ($scenes_val["hotspot-list"] as $hotspot_val) {

              $hotspot_title_validate = $hotspot_val["hotspot-title"];

              if (!empty($hotspot_title_validate)) {
                $hotspot_title_validated = preg_replace('/[^0-9a-zA-Z_]/', "", $hotspot_title_validate);
                if ($hotspot_title_validated != $hotspot_title_validate) {
                  wp_send_json_error('<span class="pano-error-title">Invalid Hotspot ID</span> <p>Hotspot ID can\'t contain spaces and special characters.<br/> Please assign a unique Hotspot ID with letters and numbers where Scene id: ' . $scene_id_validate . ' Hotspot ID is: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                  die();
                }
                $hotspot_pitch_validate = $hotspot_val["hotspot-pitch"];
                if (empty($hotspot_pitch_validate)) {
                  wp_send_json_error('<p><span>Warning:</span> Hotspot pitch is required for every hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                  die();
                }
                if (!empty($hotspot_pitch_validate)) {
                  $hotspot_pitch_validated = preg_replace('/[^0-9.-]/', '', $hotspot_pitch_validate);
                  if ($hotspot_pitch_validated != $hotspot_pitch_validate) {
                    wp_send_json_error('<span class="pano-error-title">Invalid Pitch Value</span> <p>The Pitch Value can only contain float numbers where Scene ID: ' . $scene_id_validate . ' Hotspot ID is: ' . $hotspot_title_validate . '</p>');


                    die();
                  }
                }

                $hotspot_yaw_validate = $hotspot_val["hotspot-yaw"];
                if (empty($hotspot_yaw_validate)) {
                  wp_send_json_error('<p><span>Warning:</span> Hotspot yaw is required for every hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                  die();
                }
                if (!empty($hotspot_yaw_validate)) {
                  $hotspot_yaw_validated = preg_replace('/[^0-9.-]/', '', $hotspot_yaw_validate);
                  if ($hotspot_yaw_validated != $hotspot_yaw_validate) {
                    wp_send_json_error('<span class="pano-error-title">Invalid Yaw Value</span> <p>The Yaw Value can only contain float numbers where Scene ID: ' . $scene_id_validate . ' Hotspot ID is: ' . $hotspot_title_validate . '</p>');

                    die();
                  }
                }

                if (is_plugin_active('wpvr-pro/wpvr-pro.php')) {
                  $status  = get_option('wpvr_edd_license_status');
                  if ($status !== false && $status == 'valid') {
                    if ($hotspot_val["hotspot-customclass-pro"] != 'none' && !empty($hotspot_val["hotspot-customclass"])) {
                      wp_send_json_error('<span class="pano-error-title">Warning!</span> <p>You can not use both Custom Icon and Custom Icon Class for a hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                      die();
                    }
                  }
                }
                $hotspot_type_validate = $hotspot_val["hotspot-type"];
                $hotspot_url_validate = $hotspot_val["hotspot-url"];
                if (!empty($hotspot_url_validate)) {
                  $hotspot_url_validated = esc_url($hotspot_url_validate);
                  if ($hotspot_url_validated != $hotspot_url_validate) {
                    wp_send_json_error('<p><span>Warning:</span> Hotspot Url is invalid where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }
                $hotspot_content_validate = $hotspot_val["hotspot-content"];

                $hotspot_scene_validate = $hotspot_val["hotspot-scene"];

                if ($hotspot_type_validate == "info") {
                  if (!empty($hotspot_scene_validate)) {
                    wp_send_json_error('<p><span>Warning:</span> Don\'t add Target Scene ID on info type hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                  if (!empty($hotspot_url_validate) && !empty($hotspot_content_validate)) {
                    wp_send_json_error('<span class="pano-error-title">Warning!</span> <p>You can not set both On Click Content and URL on a hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }



                if ($hotspot_type_validate == "shortcode_editor") {
                  if (substr($hotspot_val['hotspot-shortcode'], 0, 1) === '[') {
                    $pattern = get_shortcode_regex();
                    preg_match('/' . $pattern . '/s', $hotspot_val['hotspot-shortcode'], $matches);
                    if (is_array($matches) && !isset($matches[2])) {
                      wp_send_json_error('<p><span>Warning:</span> This is not a valid shortcode where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                      die();
                    }
                  }
                }

                if ($hotspot_type_validate == "scene") {
                  if (empty($hotspot_scene_validate)) {
                    wp_send_json_error('<span class="pano-error-title">Target Scene Missing</span> <p>Assign a Target Scene to the Scene-type Hotspot where Scene ID: ' . $scene_id_validate . ' and Hotspot ID : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                  if (!empty($hotspot_url_validate) || !empty($hotspot_content_validate)) {
                    wp_send_json_error('<p><span>Warning:</span> Don\'t add Url or On click content on scene type hotspot where scene id: ' . $scene_id_validate . ' and hotspot id : ' . $hotspot_title_validate . '</p>');
                    die();
                  }
                }
              }
            }
          }
        }
      }
    }
    //===Error Control and Validation===//

    foreach ($panodata["scene-list"] as $panoscenes) {
      if (empty($panoscenes['scene-id']) && !empty($panoscenes['scene-attachment-url'])) {
        wp_send_json_error('<span class="pano-error-title">Missing Scene ID</span> <p>Please assign a unique Scene ID to your uploaded scene.</p>');
        die();
      }
    }

    $allsceneids = array();

    foreach ($panodata["scene-list"] as $panoscenes) {
      if (!empty($panoscenes['scene-id'])) {
        array_push($allsceneids, $panoscenes['scene-id']);
      }
    }

    foreach ($panodata["scene-list"] as $panoscenes) {

      if ($panoscenes['dscene'] == 'on') {
        $default_scene = $panoscenes['scene-id'];
      }
    }
    if (empty($default_scene)) {
      if ($allsceneids) {
        $default_scene = $allsceneids[0];
      } else {
        
        wp_send_json_error('<span class="pano-error-title">Missing Image & Scene ID</span> <p>Please Upload An Image and Set A Scene ID To See The Preview</p>');
        die();
      }
    }

    $allsceneids_count = array_count_values($allsceneids);
    foreach ($allsceneids_count as $key => $value) {
      if ($value > 1) {
        wp_send_json_error('<span class="pano-error-title">Duplicate Scene ID</span> <p>You\'ve assigned a duplicate Scene ID. <br/>Please assign unique Scene IDs to each scene. </p>');
        die();
      }
    }

    foreach ($panodata["scene-list"] as $panoscenes) {
      if (!empty($panoscenes['scene-id'])) {
        $allhotspot = array();
        foreach ($panoscenes["hotspot-list"] as $hotspot_val) {
          if (!empty($hotspot_val["hotspot-title"])) {
            array_push($allhotspot, $hotspot_val["hotspot-title"]);
          }
        }
        $allhotspotcount = array_count_values($allhotspot);
        foreach ($allhotspotcount as $key => $value) {
          if ($value > 1) {
            wp_send_json_error('<span class="pano-error-title">Duplicate Hotspot ID</span> <p>You\'ve assigned a duplicate Hotspot ID. <br/>Please assign unique Hotspot IDs to each Hotspot.</p>');
            die();
          }
        }
      }
    }

    $panolength = count($panodata["scene-list"]);
    for ($i = 0; $i < $panolength; $i++) {
      if (empty($panodata["scene-list"][$i]['scene-id'])) {
        unset($panodata["scene-list"][$i]);
      } else {
        $panohotspotlength = count($panodata["scene-list"][$i]['hotspot-list']);
        for ($j = 0; $j < $panohotspotlength; $j++) {
          if (empty($panodata["scene-list"][$i]['hotspot-list'][$j]['hotspot-title'])) {
            unset($panodata["scene-list"][$i]['hotspot-list'][$j]);
          }
        }
      }
    }

    //===audio===//
    $bg_music = 'off';
    $bg_music_url = '';
    $autoplay_bg_music = 'off';
    $loop_bg_music = 'off';
    $bg_music = sanitize_text_field($_POST['bg_music']);
    $bg_music_url = esc_url_raw($_POST['bg_music_url']);
    $autoplay_bg_music = sanitize_text_field($_POST['autoplay_bg_music']);
    $loop_bg_music = sanitize_text_field($_POST['loop_bg_music']);
    if ($bg_music == 'on') {
      if (empty($bg_music_url)) {
        wp_send_json_error('<p><span>Warning:</span> Please add an audio file as you enabled audio for this tour </p>');
        die();
      }
    }
    //===audio===//

    $pano_array = array();
    $pano_array = array(__("panoid") => $panoid, __("autoLoad") => $autoload, __("hfov") => $default_global_zoom, __("maxHfov") => $max_global_zoom, __("minHfov") => $min_global_zoom, __("showControls") => $control, __("cpLogoSwitch") => $cpLogoSwitch, __("cpLogoImg") => $cpLogoImg, __("cpLogoContent") => $cpLogoContent, __("vrgallery") => $vrgallery, __("vrgallery_title") => $vrgallery_title, __("vrgallery_display") => $vrgallery_display, __("customcontrol") => $custom_control, __("gyro") => $gyro, __("deviceorientationcontrol") => $deviceorientationcontrol, __("compass") => $compass, __("mouseZoom") => $mouseZoom, __("draggable") => $draggable, __("diskeyboard") => $diskeyboard, __("keyboardzoom") => $keyboardzoom, __("autoRotate") => $autorotation, __("autoRotateInactivityDelay") => $autorotationinactivedelay, __("autoRotateStopDelay") => $autorotationstopdelay, __("preview") => $preview, __("defaultscene") => $default_scene, __("scenefadeduration") => $scene_fade_duration, __("bg_music") => $bg_music, __("bg_music_url") => $bg_music_url, __("autoplay_bg_music") => $autoplay_bg_music, __("loop_bg_music") => $loop_bg_music, __("panodata") => $panodata, __("previewtext") => $previewtext, __("bg_tour_enabler") => $bg_tour_enabler, __("bg_tour_navmenu") => $bg_tour_navmenu, __("bg_tour_title") => $bg_tour_title, __("bg_tour_subtitle") => $bg_tour_subtitle);

    if ($rotation == 'off') {
      unset($pano_array['autoRotate']);
      unset($pano_array['autoRotateInactivityDelay']);
      unset($pano_array['autoRotateStopDelay']);
    }
    if (empty($autorotation)) {
      unset($pano_array['autoRotate']);
      unset($pano_array['autoRotateInactivityDelay']);
      unset($pano_array['autoRotateStopDelay']);
    }
    if (empty($autorotationinactivedelay)) {
      unset($pano_array['autoRotateInactivityDelay']);
    }
    if (empty($autorotationstopdelay)) {
      unset($pano_array['autoRotateStopDelay']);
    }
    if (empty($autorotationstopdelay)) {
      unset($pano_array['autoRotateStopDelay']);
    }
    update_post_meta($postid, 'panodata', $pano_array);
    die();
  }

  function wpvr_file_import()
  {
    set_time_limit(20000000000000000);
    wpvr_delete_temp_file();
    if ($_POST['fileurl']) {
      WP_Filesystem();
      $file_save_url = wp_upload_dir();
      $fileurl = $_POST['fileurl'];
      $attachment_id = $_POST['data_id'];
      $zip_file_path = get_attached_file($attachment_id);
      $unzipfile = unzip_file($zip_file_path, $file_save_url['basedir'] . '/wpvr/temp/');

      if (is_wp_error($unzipfile)) {
        wpvr_delete_temp_file();
        wp_send_json_error('Failed to unzip file');
      }
      $result = glob($file_save_url["basedir"] . '/wpvr/temp/*.json');
      // var_dump($result);
      // die();
      if (!$result) {
        wpvr_delete_temp_file();
        wp_send_json_error('Tour json file not found');
      }
      $tour_json = $result[0];
      $arrContextOptions = array(
        "ssl" => array(
          "verify_peer" => false,
          "verify_peer_name" => false,
        ),
      );
      $getfile = file_get_contents($tour_json, false, stream_context_create($arrContextOptions));
      $file_content = json_decode($getfile, true);

      $new_title = $file_content['title'];
      $new_data = $file_content['data'];
      $new_post_id = wp_insert_post(array(
        'post_title'    => $new_title,
        'post_type'     => 'wpvr_item',
        'post_status'     => 'publish',
      ));
      if ($new_post_id) {
        if ($new_data['panoid']) {
          $new_data['panoid'] = 'pano' . $new_post_id;
        }
        if ($new_data['preview']) {
          $preview_url = $file_save_url['baseurl'] . '/wpvr/temp/scene_preview.jpg';
          $media_get = wpvr_handle_media_import($preview_url, $new_post_id);
          if ($media_get['status'] == 'error') {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error($media_get['message']);
          } elseif ($media_get['status'] == 'success') {
            $new_data['preview'] = $media_get['message'];
          } else {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error('Media transfer process failed');
          }
        }
        if ($new_data['preview']) {
          $preview_url = $file_save_url['baseurl'] . '/wpvr/temp/scene_preview.jpg';
          $media_get = wpvr_handle_media_import($preview_url, $new_post_id);
          if ($media_get['status'] == 'error') {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error($media_get['message']);
          } elseif ($media_get['status'] == 'success') {
            $new_data['preview'] = $media_get['message'];
          } else {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error('Media transfer process failed');
          }
        }
        if ($new_data['cpLogoImg']) {
          $logo = $new_data['cpLogoImg'];
          $get_logo_format = explode(".", $logo);
          $logo_format = end($get_logo_format);
          $logo_img = $file_save_url['baseurl'] . '/wpvr/temp/logo_img.' . $logo_format;
          $media_get = wpvr_handle_media_import($logo_img, $new_post_id);
          if ($media_get['status'] == 'error') {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error($media_get['message']);
          } elseif ($media_get['status'] == 'success') {
            $new_data['cpLogoImg'] = $media_get['message'];
          } else {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error('Media transfer process failed');
          }
        }
        if ($new_data['bg_music_url']) {
          $music_url = $new_data['bg_music_url'];
          $get_music_format = explode(".", $music_url);
          $music_format = end($get_music_format);
          $music_url = $file_save_url['baseurl'] . '/wpvr/temp/music_url.' . $music_format;
          $media_get = wpvr_handle_media_import($music_url, $new_post_id);
          if ($media_get['status'] == 'error') {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error($media_get['message']);
          } elseif ($media_get['status'] == 'success') {
            $new_data['bg_music_url'] = $media_get['message'];
          } else {
            wp_delete_post($new_post_id, true);
            wpvr_delete_temp_file();
            wp_send_json_error('Media transfer process failed');
          }
        }
        if ($new_data['panodata']) {

          if ($new_data['panodata']["scene-list"]) {

            foreach ($new_data['panodata']["scene-list"] as $key => $panoscenes) {

              if ($panoscenes['scene-type'] == 'cubemap') {

                // face 0
                if ($panoscenes["scene-attachment-url-face0"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face0.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }

                // face 1
                if ($panoscenes["scene-attachment-url-face1"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face1.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }

                // face 2
                if ($panoscenes["scene-attachment-url-face2"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face2.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }

                // face 3
                if ($panoscenes["scene-attachment-url-face0"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face3.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }

                // face 4
                if ($panoscenes["scene-attachment-url-face4"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face4.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }

                // face 5
                if ($panoscenes["scene-attachment-url-face5"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '_face5.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }
              } else {
                if ($panoscenes["scene-attachment-url"]) {
                  $scene_id = $panoscenes['scene-id'];
                  $url = $file_save_url['baseurl'] . '/wpvr/temp/' . $scene_id . '.jpg';
                  $media_get = wpvr_handle_media_import($url, $new_post_id);
                  if ($media_get['status'] == 'error') {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error($media_get['message']);
                  } elseif ($media_get['status'] == 'success') {
                    $new_data['panodata']["scene-list"][$key]['scene-attachment-url'] = $media_get['message'];
                  } else {
                    wp_delete_post($new_post_id, true);
                    wpvr_delete_temp_file();
                    wp_send_json_error('Media transfer process failed');
                  }
                }
              }
            }
          }
          update_post_meta($new_post_id, 'panodata', $new_data);
          wpvr_delete_temp_file();
        }
      }
    } else {
      wpvr_delete_temp_file();
      wp_send_json_error('No file found to import');
    }
    die();
  }

  /**
   * Video Preview show ajax function
   */
  function wpvrstreetview_preview()
  {
    $panoid = '';
    $html = '';
    $postid = sanitize_text_field($_POST['postid']);
    $panoid = 'pano' . $postid;
    $randid = rand(1000, 1000000);
    $streetviewid = 'streetview' . $randid;
    $streetviewurl = $_POST['streetview'];
    if ($streetviewurl) {
      $html .= '<iframe src="' . $streetviewurl . '" width="600" height="400" frameborder="0" style="border:0;" allowfullscreen=""></iframe>';
    }

    $response = array();
    $response = array(__("panoid") => $panoid, __("panodata") => $html, __("streetview") => $streetviewid);
    wp_send_json_success($response);
  }

  /**
   * Role management
   */
  function wpvr_role_management()
  {
    $editor = sanitize_text_field($_POST['editor']);
    $author = sanitize_text_field($_POST['author']);
    $fontawesome = sanitize_text_field($_POST['fontawesome']);
    $mobile_media_resize = sanitize_text_field($_POST['mobile_media_resize']);
    $high_res_image = sanitize_text_field($_POST['high_res_image']);
    $dis_on_hover = sanitize_text_field($_POST['dis_on_hover']);
    $wpvr_frontend_notice = sanitize_text_field($_POST['wpvr_frontend_notice']);
    $wpvr_frontend_notice_area = sanitize_text_field($_POST['wpvr_frontend_notice_area']);
    $wpvr_script_control = sanitize_text_field($_POST['wpvr_script_control']);
    $wpvr_script_list = sanitize_text_field($_POST['wpvr_script_list']);

    $wpvr_video_script_control = sanitize_text_field($_POST['wpvr_video_script_control']);
    $wpvr_video_script_list = sanitize_text_field($_POST['wpvr_video_script_list']);

    //        $enable_woocommerce = sanitize_text_field($_POST['woocommerce']);

    $wpvr_script_list = str_replace(' ', '', $wpvr_script_list);

    update_option('wpvr_editor_active', $editor);
    update_option('wpvr_author_active', $author);
    update_option('wpvr_fontawesome_disable', $fontawesome);
    update_option('mobile_media_resize', $mobile_media_resize);
    update_option('high_res_image', $high_res_image);
    update_option('dis_on_hover', $dis_on_hover);
    update_option('wpvr_frontend_notice', $wpvr_frontend_notice);
    update_option('wpvr_frontend_notice_area', $wpvr_frontend_notice_area);
    update_option('wpvr_script_control', $wpvr_script_control);
    update_option('wpvr_script_list', $wpvr_script_list);

    update_option('wpvr_video_script_control', $wpvr_video_script_control);
    update_option('wpvr_video_script_list', $wpvr_video_script_list);

    //        update_option('wpvr_enable_woocommerce', $enable_woocommerce);

    $response = array(
      'status' => 'success',
      'message' => 'Successfully saved',
    );
    wp_send_json($response);
  }

  /**
   * Notice
   */
  function wpvr_notice()
  {
    update_option('wpvr_warning', '1');
  }
}
