<?php 

/**
 *
 * IP Validation
 *
 * 1:Checks as to whether or not the connecting IP address is valid
 * 2:Checks the connecting IP address against a list of DNSBL (DNSL Blacklist) databases to see if it's listed or not
 *
 * Since ?
 * @my_optional_modules
 *
 */

/**
 *
 * Don't call this file directly
 *
 */
if( !defined ( 'MyOptionalModules' ) ) {

	die ();

}

/**
 *
 * Validate the IP address
 * "This function converts a human readable IPv4 or IPv6 address
 * (if PHP was built with IPv6 support enabled) into an address 
 * family appropriate 32bit or 128bit binary structure."
 * Read more at: //php.net/manual/en/function.inet-pton.php
 *
 */
if( inet_pton( $_SERVER['REMOTE_ADDR'] ) === false ) {

	$ipaddress = false;
	
	/**
	 *
	 * If the IP address can't validate, treat it like it's hostile, and flag it 
	 * as being DNSBL listed (regardless of whether it actually is or isn't)
	 *
	 */
	$DNSBL = true;

} else {

	/**
	 *
	 * If the IP address DOES validate, pass it along for further analysis
	 *
	 */
	$ipaddress = esc_attr( $_SERVER[ 'REMOTE_ADDR' ] );

}

if( !function_exists ( 'myoptionalmodules_checkdnsbl' ) ) {

	/**
	 *
	 * Check the IP address (if it was validated) against the DNSBL
	 *
	 */
	function myoptionalmodules_checkdnsbl($ipaddress){
	
		/**
		 *
		 * Blacklists to check
		 * Extensive list found here: //dnsbl.info/dnsbl-list.php
		 *
		 */
		$dnsbl_lookup=array(
			'dnsbl-1.uceprotect.net',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net',
			'dnsbl.sorbs.net',
			'zen.spamhaus.org',
			'dnsbl-2.uceprotect.net',
			'dnsbl-3.uceprotect.net'
		);

		if( $ipaddress ) {

			$reverse_ip=implode(".",array_reverse(explode(".",$ipaddress)));

			foreach($dnsbl_lookup as $host){

				if(checkdnsrr($reverse_ip.".".$host.".","A")){

					$listed.=$reverse_ip.'.'.$host;

				}

			}

		}

		if( $listed ) {

			/**
			 *
			 * If the IP is listed on one of the blacklists, treat it as a hostile
			 *
			 */
			$DNSBL === true;

		} else {

			/**
			 *
			 * If the IP was NOT listed on one of the blacklists, treat it as a friendly
			 *
			 */
			$DNSBL === false;

		}

	}

} else {

	/**
	 *
	 * If a function already exists called myoptionalmodules_checkdnsbl (it shouldn't),
	 * we want a fallback to whitelist IPs (because they won't be getting checked if 
	 * the function is being overridden).
	 * This keeps our plugin functions that rely on the DNSBL check from breaking (completely)
	 *
	 */
	$DNSBL === false;

}