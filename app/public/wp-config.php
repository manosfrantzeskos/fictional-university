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

if (file_exists(dirname(__FILE__) . '/local.php')) {
	// Local database settings
	define( 'DB_NAME', 'local' );
	define( 'DB_USER', 'root' );
	define( 'DB_PASSWORD', 'root' );
	define( 'DB_HOST', 'localhost' );
}
else {
	// Live database settings
	define( 'DB_NAME', 't120636emf_universityDB' );
	define( 'DB_USER', 't120636emf_universityUS' );
	define( 'DB_PASSWORD', '$ws9i3L6' );
	define( 'DB_HOST', 'localhost:3306' );
}

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'QhFRFN7kr40d>@WW.mYYy3o.k,;*//9|>:a<NUuw m@^r|H~@Nh>~$x7+,pVzcY_');
define('SECURE_AUTH_KEY',  'nS-;AZ~AQ8)|SjXp$?tCh{@ivqOt6I:-qxyrCUJ:$oR /@AUf6DDIj,]N{DB iQV');
define('LOGGED_IN_KEY',    '1Z^SNO.Oe=tV%@Ag%@NcsJ{7cL6AH=h>0EN|A@x$ <Z*S79b>716}Fu|_)X*dTy%');
define('NONCE_KEY',        'q-tlv6QYN;wjeaI$ISpc}W|JGW$mTK<|xc${QNh~1Wk5@O~r]>cEKp`jogdS*Ot_');
define('AUTH_SALT',        'xEXEN;&I&IO].ukDv[g{{I%XM1NdCm7Z?E03-f -~Q[)O1(j-OE;-ZFjB!sU}DcJ');
define('SECURE_AUTH_SALT', 'm,2D@fBskCwARK19AL&o(;k*?z.=jEz8%_#V@K#eK|Qv63<(uLN(#0D`doe9!Jj5');
define('LOGGED_IN_SALT',   'X#gs8l*.TL-eTO[WExCDLBnAlTMG?M{*(+}<Mk.t=Uw+r:Y+d>UpDV2Uk!Dz @=l');
define('NONCE_SALT',       'A2x0ug=7N*HCHr3gxsAO3t7+&5*B,+9;&sBenTrj,?q-LfIOn5uA&+AUmO1|3y%*');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
