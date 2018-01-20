<?php
/*
Plugin Name: Vine Media
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Media manager for the Vine Theme
Version:     0.0.1
Author:      Bryan Orozco
Author URI:  https://github.com/borozcod
Text Domain: vine_media
Domain Path: /languages
License:     GPL3

Vine Media is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Vine Media is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Vine Media. If not, see https://www.gnu.org/licenses/gpl.html.
*/

/*
* Register Post Type
*/
require_once plugin_dir_path(__FILE__) . 'includes/posttypes.php';
register_activation_hook(__FILE__, 'series_rewrite');

/*
* Register Series Admin Role
*/
require_once plugin_dir_path(__FILE__) . 'includes/roles.php';
register_activation_hook(__FILE__, 'register_series_role');
register_deactivation_hook(__FILE__, 'remove_series_role');


/*
* Add role capabilities
*/
register_activation_hook(__FILE__, 'series_add_capabilities');
register_deactivation_hook(__FILE__, 'series_remove_capabilities');

/*
* Add CMB2 fields
*/
require_once plugin_dir_path(__FILE__) . 'includes/cmb2-functions.php';
