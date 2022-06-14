<?php

namespace LarodsCoreApp;

use WP_Posts;

class TaxonomyFunctions
{
    /**
     * Function to get all details from a specific term
     *
     * @param integer $taxId
     * @param string $taxonomy
     * @return array
     */
    public function getTaxDetails(int $taxId, string $taxonomy = 'category'): array
    {
        $term = get_term($taxId, $taxonomy);

        if (is_wp_error($term) || empty($term)) {
            return [];
        }

        $childrenIds = get_term_children($term->term_id, $taxonomy);
        $children = [];

        if ($term->parent && is_numeric($term->parent)) {
            $term->parent = $this->getTaxDetails($term->parent, $taxonomy);
        }

        if (!is_wp_error($childrenIds) && !empty($childrenIds) && $term->parent === 0) {
            for ($i = 0, $j = count($childrenIds); $i < $j; $i++) {
                $children[$i] = get_term($childrenIds[$i], $taxonomy);
                $children[$i]->url = get_term_link($childrenIds[$i]);
            }
        }

        return (object) [
            'ID'    => $term->term_id,
            'name'  => $term->name,
            'slug'  => $term->slug,
            'url'   => get_term_link($term->term_id),
            'children' => $children,
            'parent' => $term->parent,
            'count' => $term->count,
            'description' => wp_strip_all_tags(term_description($term->term_id), true)
        ];
    }

    /**
     * Get the posts of a taxonomy
     *
     * @param integer $taxId
     * @param string $tax
     * @param array $queryOptions
     * @return WP_Posts[]|false
     */
    public function getTaxPosts(int $taxId, string $tax = 'category', array $queryOptions = [])
    {
        $term = get_term_by('id', $taxId, $tax);

        if (is_wp_error($term)) {
            return [];
        }

        $defaultQuery = [
            'numberposts' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => [[
                'taxonomy' => $term->taxonomy,
                'field'    => 'slug',
                'terms'    => $term->slug,
                'include_children' => true,
            ]]
        ];

        $queryOptions = $queryOptions + $defaultQuery;

        return get_posts($queryOptions);
    }

    /**
     * Get the primary category set on YOAST Plugin
    *
    *
    * @param integer $postId Post ID must be integer and greater than 0.
    * @param string $taxonomy
    * @return object|false
    */
    public function getPrimaryTaxTerm(int $postId, string $taxonomy = 'category'): array
    {
        $postType  = get_post_type($postId);
        $taxonomies = get_object_taxonomies($postType);

        if (!in_array($taxonomy, $taxonomies)) {
            return [];
        }

        $terms = get_the_terms($postId, $taxonomy);
        $primaryTerm = array();

        if (!is_wp_error($terms) && empty($terms) === false) {
            $primaryTerm = $this->getTaxDetails($terms[0]->term_id, $taxonomy);

            if (class_exists('\WPSEO_Primary_Term')) {
                $wpSeoPrimaryTerm = new \WPSEO_Primary_Term($taxonomy, $postId);
                $wpSeoPrimaryTerm = $wpSeoPrimaryTerm->get_primary_term();
                $term = get_term($wpSeoPrimaryTerm, $taxonomy);

                if (is_wp_error($term) || empty($term)) {
                    return $primaryTerm;
                }

                $primaryTerm = $this->getTaxDetails($term->term_id, $taxonomy);
            }

            return $primaryTerm;
        }

        return false;
    }
}
