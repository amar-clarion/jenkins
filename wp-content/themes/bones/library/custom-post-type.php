<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


add_action('init','create_resi_gallery_post_type');

function create_resi_gallery_post_type() {
    $labels = array(
        'name' => 'Residential Galleries',
        'singular_name' => 'Residential Galleries',
    );
    $args = array(
        'labels' => $labels,
        'description' => "Residential Gallery",
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'show_in_nav_menus' => false, 
        'show_in_menu' => true,
        'show_in_admin_bar' => false,
        'menu_position' => 20,
        'menu_icon' => null,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title','thumbnail','editor'),
        'has_archive' => 'residential-galleries',
        'rewrite' => array('slug' => 'residential-galleries/%resi_cats%'),
        'query_var' => true,
        'can_export' => true,
        "taxonomy" => "resi_cats"
    ); 
    register_post_type('resi_gallery',$args);
}

// taxonomy

add_action( 'init', 'create_resi_gallery_taxonomies', 0 );


function create_resi_gallery_taxonomies() 
{
  $labels = array(
    'name' => _x( 'Residential Gallery Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Residential Gallery Category', 'taxonomy singular name' ),
  );    

  register_taxonomy('resi_cats',array('resi_gallery'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'residential-galleries' ),
  ));
}



//get that nice url structure

add_filter('post_type_link', 'filter_post_type_link', 10, 2);


function filter_post_type_link($link, $post) {
    if (!in_array($post -> post_type, array(
            'resi_gallery',
            'testimonials'
        )))
        return $link;


    if ($catsegors = get_the_terms($post -> ID, 'resi_cats')) {
        $link = str_replace('%resi_cats%', array_pop($catsegors) -> slug, $link); 
	}
	elseif ($cats = get_the_terms($post -> ID, 'testimonials')) {
		      //  $link = str_replace('%testimoninal_cats%', array_pop($catsegors) -> slug, $link);
		
	}
   
   
    
    return $link;
}
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
	

?>
