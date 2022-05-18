<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://rextheme.com/
 * @since      1.0.0
 *
 * @package    Wpvr
 * @subpackage Wpvr/admin/partials
 */
?>
<?php

$post = '';
$id = '';
$postdata = array();
$post = get_post();
$id = $post->ID;

$postdata = get_post_meta( $id, 'panodata', true );
$panoid = 'pano'.$id;

if (isset($postdata['vidid'])) {
  ?>
  <div class="iframe-wrapper">
    <i class="fa fa-times" id="cross"></i>
    <div id="custom-ifram" style="display: none;">


    </div>
    <div id="<?php echo 'pano'.$id; ?>" class="pano-wrap" style="height: 100%;">
          <?php
          echo $postdata['panoviddata'];
          ?>
        <?php
        if ($postdata['vidtype'] == 'selfhost') {
          ?>
            <script>

            videojs(<?php echo $postdata['vidid']; ?>, {
              plugins: {
                  pannellum: {}
              }
            });
          </script>
          <?php
        }
        ?>
    </div>
  </div>

  <div class="rex-add-coordinates" style="text-align: center;">
    <ul>
      <li>
        <div id="panodata" style="text-align: center; font-weight: bold;">
        </div>
      </li>
      <li class="rex-hide-coordinates add-pitch">
          <span class="rex-tooltiptext">Add This Position into active Hotspot</span>
          <i class="fa fa-arrow-down toppitch"></i>
      </li>
    </ul>
  </div>
  <?php
}
elseif (isset($postdata['streetviewdata'])) {
  ?>
  <div class="iframe-wrapper">
    <i class="fa fa-times" id="cross"></i>
    <div id="custom-ifram" style="display: none;">

    </div>
    <div id="<?php echo 'pano'.$id; ?>" class="pano-wrap" style="height: 100%;">
          <?php
          echo $postdata['streetviewdata'];
          ?>
    </div>
  </div>

  <div class="rex-add-coordinates" style="text-align: center;">
    <ul>
      <li>
        <div id="panodata" style="text-align: center; font-weight: bold;">
        </div>
      </li>
      <li class="rex-hide-coordinates add-pitch">
          <span class="rex-tooltiptext">Add This Position into active Hotspot</span>
          <i class="fa fa-arrow-down toppitch"></i>
      </li>
    </ul>
  </div>
  <?php
}
elseif (isset($postdata['flat_image'])) {
    ?>
    <div class="iframe-wrapper">
        <i class="fa fa-times" id="cross"></i>
        <div id="custom-ifram" style="display: none;">

        </div>
        <div id="<?php echo 'pano'.$id; ?>" class="pano-wrap" style="height: 100%;">
            <img src="<?php echo $postdata['flat_image_url']; ?>" style="width: 600px">
        </div>
    </div>

    <div class="rex-add-coordinates" style="text-align: center;">
        <ul>
            <li>
                <div id="panodata" style="text-align: center; font-weight: bold;">
                </div>
            </li>
            <li class="rex-hide-coordinates add-pitch">
                <span class="rex-tooltiptext">Add This Position into active Hotspot</span>
                <i class="fa fa-arrow-down toppitch"></i>
            </li>
        </ul>
    </div>
    <?php
}
else {
$control = false;
if (isset($postdata['showControls'])) {
  $control = $postdata['showControls'];
}
$compass = false;
if (isset($postdata['compass'])) {
  $compass = $postdata['compass'];
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

$panodata = '';
if (isset($postdata['panodata'])) {
  $panodata = $postdata['panodata'];
}


  $default_data = array();
  if($default_global_zoom != '' && $max_global_zoom != '' && $min_global_zoom != ''){
    $default_data = array("firstScene"=>$default_scene,"sceneFadeDuration"=>$scene_fade_duration,"hfov"=>$default_global_zoom,"maxHfov"=>$max_global_zoom,"minHfov"=>$min_global_zoom);
  }else{
    $default_data = array("firstScene"=>$default_scene,"sceneFadeDuration"=>$scene_fade_duration);
  }
  
  $scene_data = array();

  if (!empty($panodata)) {
    foreach ($panodata["scene-list"] as $panoscenes) {

      $scene_ititle = '';
      if (isset($panoscenes["scene-ititle"])) {
        $scene_ititle = sanitize_text_field($panoscenes["scene-ititle"]);
      }

      $scene_author = '';
      if (isset($panoscenes["scene-author"])) {
        $scene_author = sanitize_text_field($panoscenes["scene-author"]);
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
      if (isset($panoscenes["scene-zoom"]) && $panoscenes["scene-zoom"] != '') {
        $default_zoom = (int)$panoscenes["scene-zoom"];
        
      }else{
        if($default_global_zoom != ''){
          $default_zoom = (int)$default_global_zoom;
        
        }
      }

     

      $max_zoom = 120;
      if (isset($panoscenes["scene-maxzoom"]) && $panoscenes["scene-maxzoom"] != '') {
        $max_zoom = (int)$panoscenes["scene-maxzoom"];
      }else{
        if($max_global_zoom != ''){
          $max_zoom = (int)$max_global_zoom;
        }
      }


     
      
      $min_zoom = 50;
      if (isset($panoscenes["scene-minzoom"]) && $panoscenes["scene-minzoom"] != '') {
        $min_zoom = (int)$panoscenes["scene-minzoom"];
      }else{
        if($min_global_zoom != ''){
          $min_zoom = (int)$min_global_zoom;
        }
      }

      $hotspot_datas = array();
      if (isset($panoscenes["hotspot-list"])) {
        $hotspot_datas = $panoscenes["hotspot-list"];
      }

      $hotspots = array();
      foreach ($hotspot_datas as $hotspot_data) {

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

          if(!$hotspot_content) $hotspot_content = $hotspot_data["hotspot-content"];


          $hotspot_info = array(
          "text"=>$hotspot_data["hotspot-title"],
          "pitch"=>$hotspot_data["hotspot-pitch"],
          "yaw"=>$hotspot_data["hotspot-yaw"],
          "type"=>$hotspot_type,
          "URL"=>$hotspot_data["hotspot-url"],
          "clickHandlerArgs"=>$hotspot_content,
          "createTooltipArgs"=>$hotspot_data["hotspot-hover"],
          "sceneId"=>$hotspot_data["hotspot-scene"],
          "targetPitch"=>(float)$hotspot_scene_pitch,
          "targetYaw"=>(float)$hotspot_scene_yaw);
        array_push($hotspots, $hotspot_info);
        if (empty($hotspot_data["hotspot-scene"])) {
          unset($hotspot_info['targetPitch']);
          unset($hotspot_info['targetYaw']);
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

        $scene_info = array("type"=>$panoscenes["scene-type"],"cubeMap"=>$pano_attachment,"pitch"=>$default_scene_pitch,"maxPitch"=>$scene_max_pitch,"minPitch"=>$scene_min_pitch,"maxYaw"=>$scene_max_yaw,"minYaw"=>$scene_min_yaw,"yaw"=>$default_scene_yaw,"hfov"=>$default_zoom,"maxHfov"=>$max_zoom,"minHfov"=>$min_zoom,"title"=>$scene_ititle,"author"=>$scene_author, "vaov"=>$scene_vaov, "haov"=>$scene_haov, "vOffset"=>$scene_vertical_offset, "hotSpots"=>$hotspots);
      }
      else {
        $scene_info = array("type"=>$panoscenes["scene-type"],"panorama"=>$panoscenes["scene-attachment-url"],"pitch"=>$default_scene_pitch,"maxPitch"=>$scene_max_pitch,"minPitch"=>$scene_min_pitch,"maxYaw"=>$scene_max_yaw,"minYaw"=>$scene_min_yaw,"yaw"=>$default_scene_yaw,"hfov"=>$default_zoom,"maxHfov"=>$max_zoom,"minHfov"=>$min_zoom,"title"=>$scene_ititle,"author"=>$scene_author, "vaov"=>$scene_vaov, "haov"=>$scene_haov, "vOffset"=>$scene_vertical_offset, "hotSpots"=>$hotspots);
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
      //   if ($panoscenes["czscene"] == "off") {
      //       unset($scene_info['hfov']);
      //       unset($scene_info['maxHfov']);
      //       unset($scene_info['minHfov']);
      //     }
      // }

      $scene_array = array();
      $scene_array = array(
        $panoscenes["scene-id"]=>$scene_info
      );
      $scene_data[$panoscenes["scene-id"]] = $scene_info;
    }
  }


  $pano_id_array = array();
  $pano_id_array = array("panoid"=>$panoid);
  $pano_response = array();
  $pano_response = array("autoLoad"=>$autoload,"showControls"=>$control,'compass'=>$compass,'mouseZoom'=>$mouseZoom,'draggable'=>$draggable,'disableKeyboardCtrl'=>$diskeyboard,'keyboardZoom'=>$keyboardzoom,"preview"=>$preview,"autoRotate"=>$autorotation,"autoRotateInactivityDelay"=>$autorotationinactivedelay,"autoRotateStopDelay"=>$autorotationstopdelay,"default"=>$default_data,"scenes"=>$scene_data);
  
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
  $response = array($pano_id_array,$pano_response);
  if (!empty($response)) {
  $response = json_encode($response);
  }
  
?>

<div class="iframe-wrapper">
  <i class="fa fa-times" id="cross"></i>
  <div id="custom-ifram" style="display: none;">
    
  </div>
  <div id="<?php echo 'pano'.$id; ?>" class="pano-wrap" style="direction:ltr;">

  </div>
</div>

<div class="rex-add-coordinates" style="text-align: center;">
  <ul>
    <li>
      <div id="panodata" style="text-align: center; font-weight: bold;">

      </div>
    </li>
    <li class="rex-hide-coordinates add-pitch">
        <span class="rex-tooltiptext">Add This Position into active Hotspot</span>
        <i class="fa fa-arrow-down toppitch"></i>
    </li>
  </ul>

  <div class="scene-gallery vrowl-carousel"  style="direction:ltr;">

  </div>

</div>

<?php 
/**
 * Nasim
 * include alert modal
 */

?>
<?php include('wpvr_confirmation_alert.php');?> 





<script>
var response = <?php echo $response; ?>;
var scenes = response[1];

  if (scenes) {
    jQuery.each(scenes.scenes, function (i) {
        jQuery.each(scenes.scenes[i]['hotSpots'], function (key, val) {
            if (val["clickHandlerArgs"] != "") {
              val["clickHandlerFunc"] = wpvrhotspot;
            }
            if (val["createTooltipArgs"] != "") {
              val["createTooltipFunc"] = wpvrtooltip;
            }
        });
    });
  }
  if (scenes) {
    jQuery('.scene-gallery').empty();
  
    jQuery.each(scenes.scenes, function (key, val) {
      if (val.type == 'cubemap') {
        var img_data = val.cubeMap[0];
      }
      else {
        var img_data = val.panorama;
      }
      jQuery('.scene-gallery').append('<ul style="width:150px;"><li class="owlscene owl'+key+'">'+key+'</li><li title="Double click to view scene"><img class="scctrl" id="'+key+'_gallery" src="'+img_data+'"></li></ul>');
    });
  }

  if (response[1]['scenes'] != "") {
    var panoshow = pannellum.viewer(response[0]["panoid"], scenes);

    if (scenes.autoRotate) {
      panoshow.on('load', function (){
       setTimeout(function(){ panoshow.startAutoRotate(scenes.autoRotate, 0); }, 3000);
      });
      panoshow.on('scenechange', function (){
       setTimeout(function(){ panoshow.startAutoRotate(scenes.autoRotate, 0); }, 3000);
      });
    }

    var touchtime = 0;
    if (scenes) {
      jQuery.each(scenes.scenes, function (key, val) {
        // document.getElementById(''+key+'_gallery').addEventListener('click', function(e) {
        //   if (touchtime == 0) {
        //     touchtime = new Date().getTime();
        //   }
        //   else {
        //     if (((new Date().getTime()) - touchtime) < 800) {
        //       panoshow.loadScene(key);
        //       touchtime = 0;
        //     }
        //     else {
        //       touchtime = new Date().getTime();
        //     }
        //   }
        // });
        jQuery(document).on("click",'#' + key + '_gallery',function() {
            panoshow.loadScene(key);
        });
      });
    }

  }

  function wpvrhotspot(hotSpotDiv, args) {
      var argst = args.replace(/\\/g, '');
      jQuery("#custom-ifram").html(argst);
      jQuery("#custom-ifram").fadeToggle();
      jQuery(".iframe-wrapper").toggleClass("show-modal");
      jQuery('button.ff-btn.ff-btn-submit.ff-btn-md').prop('disabled', true);

      //------add to cart button------
      jQuery('.wpvr-product-container p.add_to_cart_inline a.button').wrap('<span class="wpvr-cart-wrap"></span>');
  }

  function wpvrtooltip(hotSpotDiv, args) {
      hotSpotDiv.classList.add('custom-tooltip');
      var span = document.createElement('span');
      if (args != null) {
        args = args.replace(/\\/g, "");
      }
      span.innerHTML = args;
      hotSpotDiv.appendChild(span);
      span.style.marginLeft = -(span.scrollWidth - hotSpotDiv.offsetWidth) / 2 + 'px';
      span.style.marginTop = -span.scrollHeight - 12 + 'px';
  }

  jQuery(document).ready(function($){
   jQuery("#cross").on("click", function(e){
         e.preventDefault();
         jQuery("#custom-ifram").fadeOut();
         jQuery(".iframe-wrapper").removeClass("show-modal");
         jQuery('iframe').attr('src', $('iframe').attr('src'));
      });
  });
</script>
  <?php
}
