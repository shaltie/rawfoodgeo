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
define('DB_NAME', 'geofood');

/** MySQL database username */
define('DB_USER', 'geofood');

/** MySQL database password */
define('DB_PASSWORD', 'GeoFood1');

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
define('AUTH_KEY',         'J-kkrhFA0p3]*7hd*(B^TGz;~v7B0d[QFIf6?!DbWI+:!|ye<Q+uH:*AO0HQ.A*3');
define('SECURE_AUTH_KEY',  '>%^|O*4`-4 a1ftrZaC/6p(NkYv[1)~A:d6,@;=;$Xnm8DVP}Ac1l</:gQ!zUDc{');
define('LOGGED_IN_KEY',    '~f&6z%6,]>r>k}u3&3ck^J@b=IiW<WL4XEGOl9Y,G>,.&Pv1[&Bw{x(PlMBWQ!(g');
define('NONCE_KEY',        '^L p/pH_NY;r>YueX8FES4mFn-&$6Pl`+}Pix8/:u:4RxQMQJV=iruB35%*gzhY;');
define('AUTH_SALT',        '9>AA@2`7do3HR|,<ZidZTdep4a[0&NbRs<Gm~c|3P@].3K@wFOTWgB5>@f9nopE?');
define('SECURE_AUTH_SALT', '*-&.qQXE)`Lh/EY$.lhqjEHew?iGg%6N]?;L~+8kCi:O:1>gQ_v{c9yXLHug>Ier');
define('LOGGED_IN_SALT',   '`Tp&seyM1D6+au0>IKx3rZ06Bn(90_AEsyu.AL`J.JJO6V@7Bgoy5LJ<aVKyuW4D');
define('NONCE_SALT',       'V9al8UzdT(d86tNhzs1QJCL)3-IJ4?y~cT{L]?nLtWhF5rY7_>_?I~%_t*s@lEQ5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'meow';

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
