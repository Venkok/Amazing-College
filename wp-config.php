<?php
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

// ** MySQL settings - You can get this info from your web host ** //

if (strstr($_SERVER['SERVER_NAME'], 'amazing-college.local')) {
	define( 'DB_NAME', 'local' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'root' );
	define( 'DB_HOST', 'localhost' );
	
} else {
	define( 'DB_NAME', 'binkowsk_amazing_college' );
	define( 'DB_USER', 'binkowsk_live' );
	define( 'DB_PASSWORD', '@[@#-*hg=kv!' );
	define( 'DB_HOST', 'localhost' );
}



/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'j/wsAJzmLWn26xWKun8KBn03hZbkBLUuG94idN/VcaiIRB/F17dDqbksZneN5sBscpvy56Kd+6HWVkbt9Dv/CA==');
define('SECURE_AUTH_KEY',  'kHcec9zKBVPle/EUazwQBjAzsW12JKWaTTBxc5NOKZXxIrVjFKHjDHbhLRGrSosw34vN40vgI4H1RVitpzU86g==');
define('LOGGED_IN_KEY',    '9zmcCFEuQL+TE+ROvle0Ul6pyceYNqjyi4MhJ3QnTwpYoisyPrz+QDJRsORa2IDUa/thetcPzqlc/Uxux65nQA==');
define('NONCE_KEY',        'GznQEKHHUJNN2gODYeBX1dVB/h7RWDibPq77pNGMFl/8YG1DYrghpW5AWmkE6lPvzYWgypZUOG25t6pmKauWYw==');
define('AUTH_SALT',        'lEWL/U5rXQEYwDpJqaB4f49CmzzvB0Z8z6zabTMXo3pysabVCQA+EVZhvVYoLScC+yKapUQMgh8YYeH9tdhT6g==');
define('SECURE_AUTH_SALT', 'wYQWUh6u9ACzoQ3yi07Qu9vcHeciK2bDYsugSopPC56cV+DU2xHRvY/fbpJN0wBM/W3emWVQCo1VZ09kJt6s4g==');
define('LOGGED_IN_SALT',   '5l1q2onfkFJXEEppEYkvUhNepXGGlSbsU2KHDa6ARCxJkF+bToe20VK9SOYZ3yI6L3ovHsfyNzQ4CLp+d+7IhQ==');
define('NONCE_SALT',       'GXeY8IfqDfAmwBYHTo5yL3MMWFQV1dkeHUlGLeZEiHp8dXcLCn3FYv56EqweD/vZBJXSm8HRQDP+kJgyAonW1Q==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
