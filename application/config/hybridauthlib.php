<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$config =
	array(
		// set on "base_url" the relative url that point to HybridAuth Endpoint
		'base_url' => '/hauth/endpoint',

		"providers" => array (
			// openid providers
			"OpenID" => array (
				"enabled" => true
			),

			//"Yahoo" => array (
			//	"enabled" => true,
			//	"keys"    => array ( "key" => "dj0yJmk9MnNIY3daTHZKVmR2JmQ9WVdrOVowRnNTMGxVTkRnbWNHbzlNVFU1T0RjNU5UZzJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hZg--", "secret" => "fdefd17f2d75605e555b05ebb4df74b14ad824b7" ),
			//),
			"Yahoo" => array (
				"enabled" => true,
				"keys"    => array ( "key" => YAHOO_KEY, "secret" => YAHOO_SECRET ),
			),

			"AOL"  => array (
				"enabled" => true
			),

			"Google" => array (
				"enabled" => true,
				"keys"    => array ( "id" => GOOGLE_ID, "secret" => GOOGLE_SECRET ),
			),

			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => FB_ID, "secret" => FB_SECRET ),
			),

			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			// windows live
			"Live" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"MySpace" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"LinkedIn" => array (
				"enabled" => true,
				"keys"    => array ( "key" => LinkedIn_KEY, "secret" => LinkedIn_SECRET )
			),

			"Foursquare" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => (ENVIRONMENT == 'development'),

		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);


/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */