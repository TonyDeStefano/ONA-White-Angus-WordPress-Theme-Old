<?php
/**
 * @category Pinnacle Theme
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

// Show on tempalte filter
add_filter( 'cmb_show_on', 'kt_metabox_show_on_kt_template', 10, 2 );
function kt_metabox_show_on_kt_template( $display, $meta_box ) {
    if( 'kt-template' !== $meta_box['show_on']['key'] )
        return $display;
    // Get the current ID
    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
    elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
    if( !isset( $post_id ) ) return false;

    $template_name = get_page_template_slug( $post_id );
    $template_name = substr($template_name, 0, -4);

    // If value isn't an array, turn it into one
    $meta_box['show_on']['value'] = !is_array( $meta_box['show_on']['value'] ) ? array( $meta_box['show_on']['value'] ) : $meta_box['show_on']['value'];

    // See if there's a match
    if(in_array( $template_name, $meta_box['show_on']['value'] )) {
    	return false;
    } else {
    	return true;
	}
}

// render numbers
add_action( 'cmb_render_kt_text_number', 'kt_cmb_render_kt_text_number', 10, 5 );
function kt_cmb_render_kt_text_number($field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 'class' => 'cmb_text_small', 'type' => 'kt_text_number' ) );
}
// validate the field
add_filter( 'cmb_validate_kt_text_number', 'kt_cmb_validate_kt_text_number' );
function kt_cmb_validate_kt_text_number($new ) {
   $bnew = preg_replace("/[^0-9]/","",$new);
    return $new;
}
// Get taxonomy
add_filter( 'cmb_render_imag_select_taxonomy', 'imag_render_imag_select_taxonomy', 10, 2 );
function imag_render_imag_select_taxonomy( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All", 'one-white-angus' ),
            'hierarchical' => 1,
            'taxonomy' => $field['taxonomy'],
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';
}
// Get category
add_filter( 'cmb_render_imag_select_category', 'imag_render_imag_select_category', 10, 2 );
function imag_render_imag_select_category( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All Blog Posts", 'one-white-angus' ),
            'hierarchical' => 1,
            'taxonomy' => 'category',
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
// Get pages
add_filter( 'cmb_render_select_pages', 'imag_render_select_pages', 10, 2 );
function imag_render_select_pages( $field, $meta ) {	
	$pages = get_pages(); 
    if (!empty($pages)) {
			 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
			  echo '<option value="default"', $meta == 'default' ? ' selected="selected"' : '', '>Theme Options Default</option>';
		  foreach ($pages as $page) {
		    echo '<option value="', $page->ID, '"', $meta == $page->ID ? ' selected="selected"' : '', '>', $page->post_title, '</option>';
		  }
		  echo '</select>'; 
		}
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
// Get sidebars
add_filter( 'cmb_render_imag_select_sidebars', 'imag_render_imag_select_sidebars', 10, 2 );
function imag_render_imag_select_sidebars( $field, $meta ) {
	global $kad_sidebars;	
	
	 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
  foreach ($kad_sidebars as $side) {
    echo '<option value="', $side['id'], '"', $meta == $side['id'] ? ' selected="selected"' : '', '>', $side['name'], '</option>';
  }
  echo '</select>';
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
// Get sidebars products
add_filter( 'cmb_render_imag_select_sidebars_product', 'imag_render_imag_select_sidebars_product', 10, 2 );
function imag_render_imag_select_sidebars_product( $field, $meta ) {
	global $kad_sidebars;	
	
	 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	 echo '<option value="default" selected="selected">Theme Options Default</option>';
  foreach ($kad_sidebars as $side) {
    echo '<option value="', $side['id'], '"', $meta == $side['id'] ? ' selected="selected"' : '', '>', $side['name'], '</option>';
  }
  echo '</select>';
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
// post format filter
function kad_metabox_post_format( $display, $meta_box ) {
    if ( 'format' !== $meta_box['show_on']['key'] )
        return $display;

    // If we're showing it based on ID, get the current ID                  
    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
    elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
    if( !isset( $post_id ) )
        return $display;

    $format = get_post_format( $post_id );
    if ( false === $format ) {$format = 'standard';}
    if ($format == $meta_box['show_on']['value']) 
    	return true;
    	 else 
        return false;
}
add_filter( 'cmb_show_on', 'kad_metabox_post_format', 10, 2 );

add_filter( 'cmb_meta_boxes', 'pinnacle_metaboxes' );
function pinnacle_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kad_';

$meta_boxes[] = array(
				'id'         => 'standard_post_metabox',
				'title'      => __("Standard Post Options", 'one-white-angus'),
				'pages'      => array( 'post',), // Post type
				//'show_on' => array( 'key' => 'format', 'value' => 'standard'),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name'    => __("Post Summary", 'one-white-angus' ),
				'desc'    => '',
				'id'      => $prefix . 'post_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Standard Post Default', 'ona-white-angus' ), 'value' => 'default', ),
					array( 'name' => __('Text', 'ona-white-angus' ), 'value' => 'text', ),
					array( 'name' => __('Portrait Image', 'ona-white-angus'), 'value' => 'img_portrait', ),
					array( 'name' => __('Landscape Image', 'ona-white-angus'), 'value' => 'img_landscape', ),
				),
			),
		),
	);
$meta_boxes[] = array(
				'id'         => 'image_post_metabox',
				'title'      => __("Image Post Options", 'one-white-angus'),
				'pages'      => array( 'post',), // Post type
				//'show_on' => array( 'key' => 'format', 'value' => 'standard'),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __("Head Content", 'one-white-angus' ),
				'desc'    => '',
				'id'      => $prefix . 'blog_head',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __("Image Post Default", 'one-white-angus' ), 'value' => 'default', ),
					array( 'name' => __("Image", 'one-white-angus' ), 'value' => 'image', ),
					array( 'name' => __("None", 'one-white-angus' ), 'value' => 'none', ),
				),
			),
			array(
				'name' => __("Max Image Width", 'one-white-angus' ),
				'desc' => __("Default is: 848 or 1140 on fullwidth posts (Note: just input number, example: 650)", 'one-white-angus' ),
				'id'   => $prefix . 'image_posthead_width',
				'type' => 'text_small',
			),
			array(
				'name'    => __("Post Summary", 'one-white-angus' ),
				'desc'    => '',
				'id'      => $prefix . 'image_post_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Image Post Default', 'ona-white-angus' ), 'value' => 'default', ),
					array( 'name' => __('Text', 'ona-white-angus' ), 'value' => 'text', ),
					array( 'name' => __('Portrait Image', 'ona-white-angus'), 'value' => 'img_portrait', ),
					array( 'name' => __('Landscape Image', 'ona-white-angus'), 'value' => 'img_landscape', ),
				),
			),
		),
	);
	$meta_boxes[] = array(
				'id'         => 'post_metabox',
				'title'      => __("Post Options", 'one-white-angus'),
				'pages'      => array( 'post'), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Display Sidebar?', 'ona-white-angus'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'ona-white-angus'),
				'id'   => $prefix . 'post_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'ona-white-angus'), 'value' => 'default', ),
					array( 'name' => __('Yes', 'ona-white-angus'), 'value' => 'yes', ),
					array( 'name' => __('No', 'ona-white-angus'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
			),
			array(
				'name' => __('Author Info', 'ona-white-angus'),
				'desc' => __('Display an author info box?', 'ona-white-angus'),
				'id'   => $prefix . 'blog_author',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'ona-white-angus'), 'value' => 'default', ),
					array( 'name' => __('No', 'ona-white-angus'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'ona-white-angus'), 'value' => 'yes', ),
				),
			),	
			array(
				'name' => __('Posts Carousel', 'ona-white-angus'),
				'desc' => __('Display a carousel with similar or recent posts?', 'ona-white-angus'),
				'id'   => $prefix . 'blog_carousel_similar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'ona-white-angus'), 'value' => 'default', ),
					array( 'name' => __('No', 'ona-white-angus'), 'value' => 'no', ),
					array( 'name' => __('Yes - Display Recent Posts', 'ona-white-angus'), 'value' => 'recent', ),
					array( 'name' => __('Yes - Display Similar Posts', 'ona-white-angus'), 'value' => 'similar', )
				),
				
			),
			array(
				'name' => __('Carousel Title', 'ona-white-angus'),
				'desc' => __('ex. Similar Posts', 'ona-white-angus'),
				'id'   => $prefix . 'blog_carousel_title',
				'type' => 'text_medium',
			),
		),
	);
	$meta_boxes[] = array(
				'id'         => 'bloglist_metabox',
				'title'      => __('Blog List Options', 'ona-white-angus'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'template-blog.php') ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Blog Category', 'ona-white-angus'),
                'desc' => __('Select all blog posts or a specific category to show', 'ona-white-angus'),
                'id' => $prefix .'blog_cat',
                'type' => 'imag_select_category',
                'taxonomy' => 'category',
            ),
			array(
				'name'    => __('How Many Posts Per Page', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'blog_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'ona-white-angus'), 'value' => 'all', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name'    => __('Display Post Content as:', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'blog_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Summary', 'ona-white-angus'), 'value' => 'summery', ),
					array( 'name' => __('Full', 'ona-white-angus'), 'value' => 'full', ),
				),
			),
				
			));
			$meta_boxes[] = array(
				'id'         => 'bloggrid_metabox',
				'title'      => __('Blog Grid Options', 'ona-white-angus'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'template-blog-grid.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Blog Category', 'ona-white-angus'),
                'desc' => __('Select all blog posts or a specific category to show', 'ona-white-angus'),
                'id' => $prefix .'blog_cat',
                'type' => 'imag_select_category',
                'taxonomy' => 'category',
            ),
			array(
				'name'    => __('How Many Posts Per Page', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'blog_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'ona-white-angus'), 'value' => 'all', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name'    => __('Choose Column Layout:', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'blog_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'ona-white-angus'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'ona-white-angus'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'ona-white-angus'), 'value' => '2', ),
				),
			),		
			));
			$meta_boxes[] = array(
				'id'         => 'page_sidebar',
				'title'      => __('Sidebar Options', 'ona-white-angus'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array( 'key' => 'kt-template', 'value' => array('template-portfolio-grid','template-contact')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true,
				'fields' => array(
			array(
				'name' => __('Display Sidebar?', 'ona-white-angus'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'ona-white-angus'),
				'id'   => $prefix . 'page_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'ona-white-angus'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'ona-white-angus'), 'value' => 'yes', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'ona-white-angus'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));

	return $meta_boxes;
}

add_action( 'init', 'initialize_showcase_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function initialize_showcase_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'cmb/init.php';

}