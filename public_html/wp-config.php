<?php
define('WP_CACHE', true); // WP-Optimize Cache
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'admin_db' );
/** Database username */
define( 'DB_USER', 'admin_us' );
/** Database password */
define( 'DB_PASSWORD', 'myIDTzaXFPps7vEpK1Pd' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/** 
 * Custom configs
 *
 */
define( 'WP_REDIS_PASSWORD', 'geB7hvLp' );
define( 'DISALLOW_FILE_EDIT', true );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Hg;={R2.i{=S= do[U.`vm:GefXR&QohH,h&/pqJc %%A4K&LGoHFA?:/LYu}Gp3' );
define( 'SECURE_AUTH_KEY',  'F7U4Li]4K+!#:}n Br*:^#p!j  [8D(cn~$@W{B F9G&(A<R<EY^P<!sJWwcyF@p' );
define( 'LOGGED_IN_KEY',    'l)T:jAT2:!(hh:PSd@3oW<upQId&GyNV=)WG?7HxCzCKLXj`aQi`VPN_^`u$#1O6' );
define( 'NONCE_KEY',        'ZsTlahpqN>AU&?HS#G(wkh[G[yec$&-.9U)a[ehVIGcY%1nw}6VD$ZMu;c3|~F5?' );
define( 'AUTH_SALT',        'biqYgUqEuFSbbL-2#TWsz`l&`@dc_T$h{2(`YSlx[V>vMVbH2$Wul.TO^vkm]- z' );
define( 'SECURE_AUTH_SALT', '<LvN-}U-SsWNUMny+3Ml4*n[aT-0B*l2Rx#}L|CaAeVFakxT,pP$E_.83ZJ|/WN2' );
define( 'LOGGED_IN_SALT',   'gr4$cxt+r>j}<D$i![x$=v&0tUt<o5Opn-zb[>:GCJu8e[v:`)VfnUhHCc+Tl:.(' );
define( 'NONCE_SALT',       'N_k7{ScQ1]ZKNQ$QChmV_8tZhJ%Gw:I=;DR(14E3Y1mC`@xgITlM?#oD=/[4ajbM' );
/**#@-*/
/**
 * WordPress database table prefix.
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
/* Add any custom values between this line and the "stop editing" line. */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

#@ini_set( 'display_errors', 0 );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
