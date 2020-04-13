<?php

function get_parent(){
    $fid = $_GET['post'];
    $famtrees = get_posts([
        'post_type' => 'family_tree',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        
    ]);

    $temp = [];

    foreach ($famtrees as $famtree) {
        $meta = get_post_meta($famtree->ID, 'ft_mb', true);
        if($meta['status'] == 'marriage' && $fid != $famtree->ID ){

            $temp[] = [
                'value' => $famtree->ID,
                'label' => $famtree->post_title
            ];
        }

    }

    return $temp;
}

return [
    [
        'type' => 'radiobutton',
        'name' => 'status',
        'label' => __('Member Status', ''),
        'items' => [
            [
                'value' => 'marriage',
                'label' => __('Marriage', ''),
            ],
            [
                'value' => 'single',
                'label' => __('Single', ''),
            ],
        ],
        'default' => [
            'single',
        ],
    ],
    [
        'type' => 'radiobutton',
        'name' => 'parent',
        'label' => __('Parent', ''),
        'items' => get_parent(),
        'default' => [
            'single',
        ],
    ],
    [
        'type'      => 'group',
        'name'      => 'member',
        'repeating' => true,
        'title'     => __('Member', ''),
        'sortable' => true,
        'fields'    => [
            [
                'type' => 'textbox',
                'name' => 'member_name',
                'label' => __('Name', ''),
                'default' => '',
                'validation' => '',
            ],
            [
                'type' => 'radiobutton',
                'name' => 'gender',
                'label' => __('Gender', ''),
                'items' => [
                    [
                        'value' => 'man',
                        'label' => __('Man', ''),
                    ],
                    [
                        'value' => 'woman',
                        'label' => __('Woman', ''),
                    ],
                ],
                'default' => ''
            ],
            [
                'type' => 'date',
                'name' => 'date_birth',
                'label' => __('Date Birth', ''),
                'format' => 'dd-mm-yy',
                'default' => 'today',
            ],
            [
                'type' => 'textbox',
                'name' => 'address',
                'label' => __('Address', ''),
                'default' => '',
                'validation' => '',
            ],
            [
                'type' => 'upload',
                'name' => 'pic',
                'label' => __('Image', ''),
                'default' => '',
            ],
        ]
    ]
];