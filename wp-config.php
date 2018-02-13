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
/** The name of the database for WordPress */
define('DB_NAME', 'cxo');

/** MySQL database username */
define('DB_USER', 'cxo');

/** MySQL database password */
define('DB_PASSWORD', 'cxo');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'vQF,?O~OqQ4-]%<Ye.d1:H]/8w1Gpb{T(pU`J~I5/k<tDasspN)l`|NffP))`*^!');
define('SECURE_AUTH_KEY',  '7T$zL2<O->H*jaF8F6tNtS:k*7` ,Xj~wq{lEMoEHFB6V-4VbpR58F!l!&SNQ- i');
define('LOGGED_IN_KEY',    'U(>Bj,0SQ+:nYn,Sm*q>~a>mpIS(]B=k#TWI~ra|J6MSxM!X.*p)]4>T<}=lTs;3');
define('NONCE_KEY',        ' O/b/DHy<JJ2x9fFn<.u%zjv$xABrT&xG0Yq>]l((7:g5eT:bvQNBN6n+!$10}G0');
define('AUTH_SALT',        'W:9HjLY#2Az1wPWyDPYf0T7SVbKXjry~F3u&*4H<PY>3Fbr3tT-?$TN(Q/Hn8>KG');
define('SECURE_AUTH_SALT', '7plL^vNr,u;HyvpLfu=w>/a:QUWlh)GK:[.GFda&S_mTyPUpTH*z!2jj|RdrM<Ew');
define('LOGGED_IN_SALT',   '9$S|-*Zt+BWNi4pxVapES@8<]PBKcl[*P*c:mfaopBs/-pPZa<xa;2w=*=&kZ|c&');
define('NONCE_SALT',       ',O{e*|~/pj;|E0hD,0 W-8KftF6j#1K9+m$-o|]=I@XK4jrb`D&M7EYVp%eugBud');

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
