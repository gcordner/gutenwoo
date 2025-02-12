<?php
/**
 * Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package child-theme
 * @since 1.0.0.1
 */

/**
 * Enable Gutenberg for products
 *
 * @param bool   $can_edit Whether the post type can be edited.
 * @param string $post_type The post type being checked.
 * @return bool
 */
function enable_gutenberg_for_products( $can_edit, $post_type ) {
	if ( 'product' === $post_type ) {
		$can_edit = true;
	}
	return $can_edit;
}
add_filter( 'use_block_editor_for_post_type', 'enable_gutenberg_for_products', 10, 2 );

/**
 * Save the Gutenberg content for product categories
 *
 * @param [type] $taxonomy
 * @return void
 */
function add_gutenberg_editor_to_product_categories( $taxonomy ) {
	if ( $taxonomy !== 'product_cat' ) {
		return;
	}

	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="product_cat_gutenberg"><?php _e( 'Category Content', 'plk-astra-child' ); ?></label></th>
		<td>
			<?php
			$content = get_term_meta( get_queried_object_id(), 'product_cat_gutenberg', true );
			wp_editor( $content, 'product_cat_gutenberg', array( 'media_buttons' => true ) );
			?>
			<p class="description"><?php _e( 'Use Gutenberg blocks for this category page.', 'plk-astra-child' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'add_gutenberg_editor_to_product_categories' );

/**
 * Save the Gutenberg content for product categories
 *
 * @param [type] $term_id
 * @return void
 */
function save_gutenberg_content_for_product_category( $term_id ) {
	if ( isset( $_POST['product_cat_gutenberg'] ) ) {
		update_term_meta( $term_id, 'product_cat_gutenberg', wp_kses_post( $_POST['product_cat_gutenberg'] ) );
	}
}
add_action( 'edited_product_cat', 'save_gutenberg_content_for_product_category' );
