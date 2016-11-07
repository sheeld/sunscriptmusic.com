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
define('DB_NAME', 'sunscrip_wp596');

/** MySQL database username */
define('DB_USER', 'sunscrip_wp596');

/** MySQL database password */
define('DB_PASSWORD', '))A6S18Ip1');

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
define('AUTH_KEY',         '2oed0ryzq6bj03otimi3o17g8altx41sr1aawa2t9djegzmgefamzw9zjl8kncp2');
define('SECURE_AUTH_KEY',  'isxfif388bpdxj7fayyjondixs4omvszafqvb46znlbmsifty4aanbxdmetaejvw');
define('LOGGED_IN_KEY',    'n0vztpajmpg7qm4oygupc5do8of8zaegnuc8gzfkyd9z8kwl8lushmktywli94ic');
define('NONCE_KEY',        'vxlgyhipiwfzmpkafbaqbfpwuc3zz6na4ec7bqoxmamkckjhnwgn8xkax1bhere8');
define('AUTH_SALT',        'u5styojocdm6uvrmkntt5itijnw07czan3vyh9uyr9wjcsftnqktzdpho2vckhxv');
define('SECURE_AUTH_SALT', '5jwohacuyzzqbm8zvq1polz54rfg5euep8hrh79mqmzqifeug1gsyrek3ncs51pw');
define('LOGGED_IN_SALT',   'v7nfegprnxfxhdzhxesbmnpawznqyyggcyyl5oesq9vxpiggnihx09fdiuimgm8y');
define('NONCE_SALT',       'ita3te15upfzb2k2rmzge3ckndz1mymmqdhxdd455arn8bmtca7aw6bkagok3tkp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpbg_';

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
