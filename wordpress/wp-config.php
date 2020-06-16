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
define( 'DB_NAME', 'greenknollorchards' );

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

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'E[8*J7E(0L}F1,BNZP2<z~;&$YED1|mFQO95r!xPO)KBC&];YNs>.+U|a]1X} YZ' );
define( 'SECURE_AUTH_KEY',  'ny}Mub|guU[<s`6W>k$`dx~gI3c[F%^.o#f<V!^R49=L}J+f![I]Sz!RUN2`8lYM' );
define( 'LOGGED_IN_KEY',    'f%S&(t.4+)ps_IdUAg,eCy);ZxO^X|0;0dy@rglZsOSWhH!cYak#Nc0)?;(OEiA5' );
define( 'NONCE_KEY',        'J35Y+?L*pvRLD?jz-jG}`S/rOM+-.oZmXxZ5q;HMoA@RB:usxR9nkp/>3?M=L@xh' );
define( 'AUTH_SALT',        '+e>{YTA*Bm <w7i;P|e0f&}Fr$m-6RW/%JV_7FOyu)<L)/41BaE]zm?yqR5hnr7l' );
define( 'SECURE_AUTH_SALT', ';27P?n:V|hvFMtl^$[r^gK:_D`3G(z]B91H#c*C]eU:52n8(I}W&Xx<czztpHm,K' );
define( 'LOGGED_IN_SALT',   'T6o=6j$D1_,S$=X5ui(h>]>~[,Ls),zsaj!8Zgq-:`K}2au%1,m}AR2SqY[9X] ~' );
define( 'NONCE_SALT',       '6z2vrmByi8:+0CfoB@h2Iv#sb=3Er@Rf+|K2?RTU1l*^fc2ep?NQT*4a?Zwws=k>' );

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
