<?php
/**
 * WP_Block_Type_Registry Tests
 *
 * @package Gutenberg
 */

/**
 * Tests for WP_Block_Type_Registry
 */
class Gutenberg_REST_API_Test extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();

		$this->administrator = $this->factory->user->create( array(
			'role' => 'administrator',
		) );
	}

	function tearDown() {
		parent::tearDown();
	}

	/**
	 * Should return an extra public field on response when in edit context.
	 */
	function test_public_field() {
		wp_set_current_user( $this->administrator );

		$request = new WP_REST_Request( 'GET', '/wp/v2/taxonomies/category' );
		$request->set_param( 'context', 'edit' );
		$response = rest_do_request( $request );

		$result = $response->get_data();

		$this->assertTrue( isset( $result['public'] ) );
		$this->assertTrue( $result['public'] );
	}

	/**
	 * Should not return an extra public field without context set.
	 */
	function test_public_field_without_context() {
		$request = new WP_REST_Request( 'GET', '/wp/v2/taxonomies/category' );
		$response = rest_do_request( $request );

		$result = $response->get_data();

		$this->assertTrue( ! isset( $result['public'] ) );
	}
}
