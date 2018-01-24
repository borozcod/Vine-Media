<?php



/**
 * Register custom query vars
 *
 * @param array $vars The array of available query variables
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */
function vine_register_query_vars( $vars ) {
	$vars[] = 'series';
	$vars[] = 'sermon';
	return $vars;
}
add_filter( 'query_vars', 'vine_register_query_vars' );


/**
 * Add rewrite tags and rules
 *
 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_tag
 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
 */
/**
 * Add rewrite tags and rules
 */
function vine_rewrite_tag_rule() {
    add_rewrite_tag('%sermon%', '([^&]+)');
    add_rewrite_rule( 'series/([^/]*)/([^/]*)/?', 'index.php?series=$matches[1]&sermon=$matches[2]', 'top' );
    flush_rewrite_rules();
}
add_action('init', 'vine_rewrite_tag_rule', 10, 0);

function prefix_url_rewrite_templates() {

        if(is_singular('series')){
            add_filter( 'template_include', function() {
                return get_template_directory() . '/single-series.php';
            });
        }
}

add_action( 'template_redirect', 'prefix_url_rewrite_templates' );



 ?>
