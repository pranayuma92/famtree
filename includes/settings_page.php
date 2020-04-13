<?php

return array(
    'title' => __('Famtree Settings', ''),
    'logo'  => get_template_directory_uri() .  '/assets/images/ukmgood.png',
    'menus' => apply_filters('ug_option_array', array(
        array(
	        'title' => __('General', ''),
	        'icon' => 'font-awesome:fa-gear',
	        'controls' => array(
	           	array(
			        'type' => 'textbox',
			        'name' => 'ft_head_title',
			        'label' => __('Header Title', ''),
			        'default' => 'My Family Tree',
			        'validation' => ''
			    ), 
			    array(
			        'type' => 'toggle',
			        'name' => 'enable_ft_menu',
			        'label' => __('Enable Export Menu', ''),
			        'default' => '0',
			    ),
			    array(
			        'type' => 'toggle',
			        'name' => 'enable_ft_child_sort',
			        'label' => __('Enable child sorting', ''),
			        'default' => '0',
			    ),
			    array(
			        'type' => 'toggle',
			        'name' => 'enable_ft_hor_mode',
			        'label' => __('Horizontal view mode', ''),
			        'default' => '0',
			    ),
	        ),
	    ),
    ))
);