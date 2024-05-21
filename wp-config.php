<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'login-registration' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '9CD g#+5|[[XIJY[w&kk;H!>9j,7n5/cbN4vg#=6BW(cmNOjV3L.4Oq/dR=8|g;l' );
define( 'SECURE_AUTH_KEY',  '|LCIaRU7J@B56zia$97{$ieN?Pu_m],Cf1qa711@2#JB}><f:E|_aP&A7!_(jH`B' );
define( 'LOGGED_IN_KEY',    '_`gWx/@u4.T[;A(S]PWdx@%gSXMvs/FQSnwR;F!F6Fd`1B/{l`{ZmW!G_j y(q|%' );
define( 'NONCE_KEY',        'sEG,M6?sMCj[~Dv;g6;F!&SL:[XbA,f[SwL)T>%@iXaA$K|U;+a>88m+L{wBuD8>' );
define( 'AUTH_SALT',        ']<]ck7Rz-aUK9^^G19>8-fgDzXD{H+vz^5|4;8|aA1F%{#%Gfr]B,}adv},&p?C3' );
define( 'SECURE_AUTH_SALT', ']q=yu4/YqLLdnhTa.>* k;1&Q8PLE8G@R;kF^W&IIb/+xR2_&0=-jM:>H=Szc79]' );
define( 'LOGGED_IN_SALT',   '*6U?jglUSyK]BT$*&q{iDQ_n&TC-~@)aQ <;i|c4]JUN5eQ,L%]|@V<Tjn;(4>p.' );
define( 'NONCE_SALT',       '3uRr~vHO$S+.U7b6Y0=$g]jr9|qnpT4o 2Yh!}?0pSp,RAfR[|*M1?o+W2(nC@wL' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
