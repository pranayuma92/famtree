<?php

function famtree_cpt(){
	$plugin_name = 'famtree';

	$labels = [
        'name'                => _x( 'Family Tree', 'Post Type General Name', $plugin_name ),
        'singular_name'       => _x( 'Family Tree', 'Post Type Singular Name', $plugin_name ),
        'menu_name'           => __( 'Family Tree', $plugin_name ),
        'all_items'           => __( 'All Family Tree', $plugin_name ),
        'view_item'           => __( 'Family Tree', $plugin_name ),
        'add_new_item'        => __( 'Add New Family Tree', $plugin_name ),
        'add_new'             => __( 'Add New Family Tree', $plugin_name ),
        'edit_item'           => __( 'Edit Family Tree', $plugin_name),
        'update_item'         => __( 'Update Family Tree', $plugin_name ),
        'search_items'        => __( 'Search Family Tree', $plugin_name ),
        'not_found'           => __( 'Not Found', $plugin_name ),
        'not_found_in_trash'  => __( 'Not found in Trash', $plugin_name ),
    ];

	$args = [
        'label'               => __( 'Family Tree', $plugin_name ),
        'description'         => __( 'Family Tree App', $plugin_name),
        'labels'              => $labels,
        'supports'            => [ 'title' ],
        'menu_icon'           => 'dashicons-networking', 
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 30,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    ];


    register_post_type( 'family_tree', $args );
	flush_rewrite_rules();

}

function famtree_metabox(){
	$mb = new VP_Metabox([
		'id'          => 'ft_mb',
		'types'       => ['family_tree'],
		'title'       => __('Family Member', FT_SLUG),
		'priority'    => 'high',
		'is_dev_mode' => false,
		'template'    => FT_PLUGIN_DIR . 'includes/metabox.php',
	]);
}

function famtree_settings() {
	    
	    $settings = new VP_Option(array(
	        'is_dev_mode'           => false,
	        'option_key'            => 'ft_option',
	        'page_slug'             => 'ft_option',
	        'template'              => FT_PLUGIN_DIR . 'includes/settings_page.php',
	        'menu_page'             => 'edit.php?post_type=family_tree',
	        'use_auto_group_naming' => true,
	        'use_exim_menu'         => true,
	        'minimum_role'          => 'edit_theme_options',
	        'layout'                => 'fixed',
	        'page_title'            => __( 'Famtree Settings', '' ),
	        'menu_label'            => __( 'Famtree Settings', '' ),
	    ));
	}

function admin_footer(){ ?>
	<script type="text/javascript">
		(function(){
			let btn = jQuery('.post-type-family_tree .docopy-member'),
				delBtn = jQuery('.dodelete.vp-wpa-group-remove');
				//parent = jQuery('input[name="ft_mb[parent]"]').parent().parent().parent().parent();
			
			let getChecked = jQuery('input[name="ft_mb[status]"]:checked').val()
			if(getChecked == 'single'){
				btn.hide();
				delBtn.hide();
				//parent.show();
			} else {
				btn.show();
				delBtn.show();
				//parent.hide();
			}

			jQuery('input[name="ft_mb[status]"]').on('change', function(){ 
				let val = jQuery(this).val()
				if(val == 'single'){
					btn.hide();
					delBtn.hide();
					//parent.show();
				} else {
					btn.show();
					delBtn.show();
					//parent.hide();
				}
			})
		})()
	</script>

<?php
}