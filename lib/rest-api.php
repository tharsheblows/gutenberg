<?php
/**
 * Internationalization-related functions for the Gutenberg editor plugin.
 *
 * @package gutenberg
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Silence is golden.' );
}

/**
 * Add additional 'public' rest api field to taxonomies.
 *
 * Used so private taxonomies are not displayed in the UI.
 */
function gutenberg_add_taxonomy_public_field() {
	register_rest_field(
		'taxonomy',
		'public',
		array(
			'get_callback'    => 'get_post_meta_for_api',
			'schema'          => array(
				'description' => __( 'Whether taxonomy is public.', 'gutenberg' ),
				'type'        => 'boolean',
				'context'     => array( 'edit' ),
				'readonly'    => true,
			),
		)
	);
}

/**
 * Gets taxonomy public property.
 *
 * @param array $object Taxonomy data from REST API.
 * @return boolean Whether the taxonomy is public.
 */
function get_post_meta_for_api( $object ) {
	$taxonomy = get_taxonomy( $object['slug'] );
	return $taxonomy->public;
}

add_action( 'rest_api_init', 'gutenberg_add_taxonomy_public_field' );
