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
define('DB_NAME', 'buyprepnow');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'Kmsqb8kkN(wVeP2zA,5luV#W<f~R3obHH]NyhY9>js~9}L5@+Znps+f#}R$F$6g@');
define('SECURE_AUTH_KEY',  ';$m}cop-3Lx~+pi.C}?0REQ)mgV.Bpx}:8Vj:@t3F~:Gfbq]Ug#uA9vY}<,?2LH1');
define('LOGGED_IN_KEY',    'j}dF`fi@|VB6xXu5asCglFUiy(V;a0e>MF/V#<-`4AEF.=^XJ)}!KzG.YXkk_!(,');
define('NONCE_KEY',        '4h~yZ3}~a}`$X+DxOh$GYip(Pa;%Pt3p3v(m{h*C2xr<9zyE$$+L$R?aORZ@5*/k');
define('AUTH_SALT',        'U/MFac3zQOHn-g?~N5_`{[bn4//YnP7e1)8ferR@A6`O$1d][U0`NxYWC)aZS1g$');
define('SECURE_AUTH_SALT', 'B|#GoB73*n862}LajiN711J$e,y}8$[|NC=%uvz+pWsC5sMw(Oi1u.|E8Y^#.DA5');
define('LOGGED_IN_SALT',   '4)X}V]CKX8hk2/{ x _>W{<4RQ! <qlbIH2_bgf7R&<=V4H(6peBmBYVJNjXU>6 ');
define('NONCE_SALT',       'KX,W~vF{?Z/O~&Td0:+1Plj8ar17yER>A4oSjXv$!BRkU&+KU@)E,5<29}Wc/8!g');

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
