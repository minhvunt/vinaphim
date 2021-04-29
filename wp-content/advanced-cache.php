<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'WP_ROCKET_ADVANCED_CACHE', true );
$rocket_cache_path = '/home/www/v.nhanongxanh.vn/wp-content/cache/wp-rocket/';
$rocket_config_path = '/home/www/v.nhanongxanh.vn/wp-content/wp-rocket-config/';

if ( file_exists( '/home/www/v.nhanongxanh.vn/wp-content/plugins/wp-rocket/inc/front/process.php' ) ) {
	include '/home/www/v.nhanongxanh.vn/wp-content/plugins/wp-rocket/inc/front/process.php';
} else {
	define( 'WP_ROCKET_ADVANCED_CACHE_PROBLEM', true );
}