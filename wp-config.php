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
define('DB_NAME', 'robbiedi_wp');

/** MySQL database username */
define('DB_USER', 'robbiedi_wpusr');

/** MySQL database password */
define('DB_PASSWORD', 'X=B?.o=8?7*r');

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
define('AUTH_KEY',         '|;5=Jv(t*rq-G&u-Bi<>!g14qh{(`tB),C/z}9HT7>+FUC~;Te@!_q>E#uXO)}LP');
define('SECURE_AUTH_KEY',  '3:IqkAf6C(bgJ/4(tF,-q%gR ts9*;?sm>;^>BLYf9wE]DZU#:{w7v>t/5we`I%s');
define('LOGGED_IN_KEY',    '4,EUfqx0/o5~`mRy2CD1gnr@r8.bK(sSXQJ.-ptAKEFn_N/|3cBJeM[]1T~i<~^`');
define('NONCE_KEY',        'n$WcKKjigQ?3Nj%v`_,0ES78B,+=RF}X Fioom~o:gDvW_KdrH_Af0A]1HMa+ee:');
define('AUTH_SALT',        'ewAw+=O}@c H1[MDi(F?kTB7S!D2?7B-~_ ~46G_uiriipFY!bn3VrVL(OVh#X%.');
define('SECURE_AUTH_SALT', 'zN[-?]9@ii~+aN)p]EQSzP-1&T4RYmICNy<[)N^^.)nvj@xZ)ff?<tA5}:]nVhs!');
define('LOGGED_IN_SALT',   'KeP%R`{lo((@}`NN^GL}-`B,DWZz%f+]3)-b&99aAt/4r<O? e*=)x=J^0}nekt!');
define('NONCE_SALT',       '[8*@Azm@E;Hq_L~T=St5&.$H7c+K]2&lnGrZWQ.o+~U3:.:h^G(Cs?E=;5iX)<*u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'roce25_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');