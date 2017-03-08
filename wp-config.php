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
define('DB_NAME', 'startupmza_wp');

/** MySQL database username */
define('DB_USER', 'startupmza_web');

/** MySQL database password */
define('DB_PASSWORD', '8Xg*3*68_6QN');

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
define('AUTH_KEY',         'm!OZ/;pI2HhK{,.L!2K}>/IY^JZXnghwGQ_IEI<4BIx:pT}@S og[wywE}I`#P{&');
define('SECURE_AUTH_KEY',  'Uu4f<TTu/5x3Ov%r^D+;<x?Ioj!2Olk7>,pF/pL#2.9qekAUQ}E3mmYIaD5SPx2E');
define('LOGGED_IN_KEY',    'PQ5#O;uN2%EA:w_d8*b#RfIV$R!UWQ&6En0qa&%T/LHx/5CKJ#srDHMfuK-Bb~rp');
define('NONCE_KEY',        '7ILfO}K_C{uKZOx4.W%FpGm[T%}dRl4B]QI49zP@G{l(AcNP^zdoW%4p-Zaa-rwW');
define('AUTH_SALT',        'eRfPbn6?otjr&Veed)mS(]ruG;>$sDZI0[)D?ldvM- a9$-s,3t=05{?viq0H7qY');
define('SECURE_AUTH_SALT', 'L*uCC9axW[<Ql~E-#}m)/jWF~-x7SHeVH(70fB/ui3ayqbB&4ZQ}w/T6pQ$%!5c`');
define('LOGGED_IN_SALT',   'sgI6+={+G8Qn;f@I-lU>Dhw7Pmi.0<kg|ik3!dH LP<z}1P;YC1LP$VvsP&]0(gg');
define('NONCE_SALT',       '1rFm*0Af{[OGf#$h|SMb[,24czbGs?i`5]NF#]uph3@gSSvowbO]fkUn@Ngc0898');

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
