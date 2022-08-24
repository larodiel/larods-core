<?php
namespace LarodsCoreBlocks\AcfExample;

use LarodsCoreApp\TaxonomyFunctions;

class AcfExampleFields {
    public function __construct()
    {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_62fb1b3e9f2d8',
                'title' => '[Blocks] Posts Slider',
                'fields' => array(
                    array(
                        'key' => 'field_62fb1c46beb93',
                        'label' => 'Title',
                        'name' => 'b_post_slider_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_62fb1c55beb94',
                        'label' => 'Posts category',
                        'name' => 'b_post_slider_category',
                        'type' => 'taxonomy',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'taxonomy' => 'category',
                        'field_type' => 'select',
                        'allow_null' => 0,
                        'add_term' => 0,
                        'save_terms' => 0,
                        'load_terms' => 0,
                        'return_format' => 'object',
                        'multiple' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/larods-core-post-slider',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ));
        }
    }

    public function sanitizeData($data) {
        $categoryId = $data['b_post_slider_category'];
        $title = $data['b_post_slider_title'] ?? '';
        $postsList = [];
        $posts = [];
        $taxMethods = new TaxonomyFunctions();

        if($categoryId) {
            $postsList = $taxMethods->getTaxPosts($categoryId, 'category', [
                'numberposts' => !wp_is_mobile() ? 28 : 3
            ]);

            foreach ($postsList as $post) {
                $primaryCatDetails = $taxMethods->getPrimaryTaxTerm($post->ID);
                array_push($posts, [
                    'post_title' => strlen($post->post_title) > 30 ? substr($post->post_title, 0, 30) . '...' : $post->post_title,
                    'post_url' => get_permalink($post),
                    'post_category' => $primaryCatDetails,
                    'post_thumbnail' => get_the_post_thumbnail($post, 'full')
                ]);
            }
        }

        return [
            'posts' => $posts,
            'title' => $title,
            'selected_category' =>  $taxMethods->getTaxDetails($categoryId)
        ];
    }
}