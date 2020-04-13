<?php

function initFamTree(){
	add_action('wp_enqueue_scripts', 'famtree_scripts');
	add_shortcode('famtree-view', 'famtree_view');
	add_action('init', 'famtree_cpt');
    add_action( 'after_setup_theme', 'famtree_metabox');
    add_action( 'after_setup_theme', 'famtree_settings');
    add_action( 'admin_footer', 'admin_footer');
    add_action( 'init', 'fetch_data');
    add_action( 'wp_ajax_get_child_data', 'get_child_data');
    add_action( 'wp_ajax_nopriv_get_child_data', 'get_child_data');
    add_action('rest_api_init', 'famtree_rest_route');
}

function famtree_scripts(){
    wp_enqueue_script('d3-js', FT_PLUGIN_URL . 'assets/js/d3.min.js', array());
    //wp_enqueue_script('app-js', FT_PLUGIN_URL . 'assets/js/app.js', array('jquery'), '1.0', true);
    wp_register_script( 'app-js', FT_PLUGIN_URL . 'assets/js/app.js', array('jquery'), '1.0', true );
 
    // Localize the script with new data
    $translation_array = array(
        'baseurl' => home_url('/wp-json/famtree/v1/get-data'),
    );
    wp_localize_script( 'app-js', 'famtree_vars', $translation_array );
     
    // Enqueued script with localized data.
    wp_enqueue_script( 'app-js' );
}

function famtree_rest_route(){
  register_rest_route( 'famtree/v1', 'get-data', array(
        'methods'  => 'GET',
         'callback' => 'fetch_data'
    ));
}

function fetch_data(){

    $famtrees = get_posts([
        'post_type' => 'family_tree',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'order' => 'ASC',
    ]);

    $nodes = [];
    $temp = [];

    $i = 0;
    foreach ($famtrees as $famtree) {
        $meta = get_post_meta($famtree->ID, 'ft_mb', true);
        $status = $meta['status'];

        $name = '';
        $img = [];

        foreach ($meta['member'] as $member) {
            $pic = $member['pic'];
            $img[] = $pic;
            
            if(count($meta['member']) > 1){
                $name .= $member['member_name'] . ' & ';
            } else {
                $name = $member['member_name'];
            }

            if($status == 'single' && $member['gender'] == 'man') {
                $image = FT_PLUGIN_URL  . 'assets/img/man.png';
            } else if($status == 'single' && $member['gender'] == 'woman') {
                $image = FT_PLUGIN_URL  . 'assets/img/woman.png';
            } else {
                $image = FT_PLUGIN_URL  . 'assets/img/couple.png';
            }
        }

        $nodes[$i] = [
            'id' => $famtree->ID,
            'name' => rtrim($name, ' & '),
            'image' => $img ? $img : [$image],
            'parent' => $meta['parent'] ? (int)$meta['parent'] : ''
        ];

        $i++;
    }


  $response = new WP_REST_Response($nodes);
  $response->set_status(200);
  return $response;
}

function famtree_view(){ 
    ob_start() ?>
    <style type="text/css">
      path {
        fill: none;
        stroke: black;
      }

      rect {
        fill: white;
        stroke: black;
        height: 40px;
        width: 120px;
        cursor: pointer;
      }

      text {
        dominant-baseline: middle;
        text-anchor: middle;
      }

      #node-details {
        display: none;
      }

      #node-details.show {
        display: block;
      }

      #famtree-canvas {
        background: #fff;
    }
    </style>
    <div id="famtree-canvas"></div>
    <div id="node-details">
      <div id="close">X</div>
      <div id="data"></div>
    </div>
<?php
    return ob_get_clean();
}