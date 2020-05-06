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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'testsite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// This is keys for s3 AWS to control it by wordpress WP Offload Media Lite plugin
define( 'AS3CF_AWS_ACCESS_KEY_ID', 'AKIAXAHZEDVUQGILXA5X' );
define( 'AS3CF_AWS_SECRET_ACCESS_KEY', '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' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ugk7ez{G$fTR>Mr$xAKDMG;e=Dj85Ys2qR T``,1(`s8AZ[$eszGhsi}mTBEAgo4' );
define( 'SECURE_AUTH_KEY',  '*z}:P|Mpu%h+ Yj3`-6adR-Y.d!ZmIXeW%x<n,8>JCp1A?KUKeO_9uKTr.YC(<kB' );
define( 'LOGGED_IN_KEY',    'BV]5+p3QD:P)k]+%0+aY]7Qa8uLBmecy<I77/Bfz(>2WIBm8IEdKs[?`V9cDQcVA' );
define( 'NONCE_KEY',        'MXj^ 5@KCMgsc2ui!RVgoj|K<f!d]J6b_v:bL,<Z wJ|MkAG<.f`40/:s(T*:&<?' );
define( 'AUTH_SALT',        'Eo|s~JtXDtCyG}?/>axi;dh;D#;B:h&101M<GCAD3>m^Jz3a[kXeip@G-e.2&<0d' );
define( 'SECURE_AUTH_SALT', '_m>8;?D!(qe%C}i<1S~&.8q[EYl_gwovle4FdBzH?=quqtR[xet>$ErXm|cO)+(z' );
define( 'LOGGED_IN_SALT',   '~lT931e,vB1U>n|Gr 7pV}jf+zd3YXH>Y/BHjEqJ0oXh?;h22d5bnWV!R*pt[C*j' );
define( 'NONCE_SALT',       'bYW.}1>O(eM!(LZeE8`;u<Ra(k!B(m[{ |3[ZuU_Xmc~YUY{/:k.RjpGrPb>|3$o' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
