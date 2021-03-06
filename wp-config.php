<?php
define('WP_CACHE', true); // Added by WP Rocket
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
 	
//set_time_limit(300);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vinaphim');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' %4(5S@55.n$f,|#Y.k,2LN M][@^725FGAQUtGEvPs^)d+1PH4Cc;%6}a7H`RmG');
define('SECURE_AUTH_KEY',  '*<Iv67/NQ7gFv^,7!z}MPal+==lSxjcv!GzJ$O^P!NS]eFT^Lr2ioyNY>CyW$ z&');
define('LOGGED_IN_KEY',    ';AoQ!`;e_b8[c,=`,a1$AgGSLje<1Q.vWpE [|>H}$3F:A*U`]N&*4zw}}B,NAYe');
define('NONCE_KEY',        'bSN_:=nK>o4JMV%@B[A`1 $uQ#Kp%z`A`th Fe0i r D^#*a8W8e{fM>O/Rl%5!|');
define('AUTH_SALT',        'XF`(OKYd=~k TsEY{^EU-,.V*DB#!7?5FoY*Nf-_m!QQGwrafF/g`<-MQ0//Iixi');
define('SECURE_AUTH_SALT', '=UgL&^w_n( D1TfQmd,<@:KnY8`MSn#620UO3)BWm%R]?a|i1R5wHE9<ZS&XAd8a');
define('LOGGED_IN_SALT',   ')T]3nvbD/2yC0IQ%/To=_RGgua[0=M68/YQT+].`8.}2(fhK/E9N{]GMhgbbMI_X');
define('NONCE_SALT',       '@7Z9Vq9#<z=K/[22@T:OHr0vbp7S.>BAozbh}/:n6d!>ual$i> XyUQHUPkKP8D=');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
