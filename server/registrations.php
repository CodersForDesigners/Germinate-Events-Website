<?php

/*
 *
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
 * SCRIPT SETUP
 * /-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 *
 */
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

// Set the timezone
date_default_timezone_set( 'Asia/Kolkata' );

// Do not let this script timeout
set_time_limit( 0 );

// Continue processing this script even if the user closes the tab, or
//  	hits the ESC key
ignore_user_abort( true );

// Allow this script to triggered from another origin
// header( 'Access-Control-Allow-Origin: *' );

// Remove / modify certain headers of the response
header_remove( 'X-Powered-By' );
header( 'Content-Type: application/json' );	// JSON format

$input = &$_POST;





/*
 *
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
 * SCRIPT DEPENDENCIES
 * /-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 *
 */
require __DIR__ . '/../inc/google-forms.php';





/*
 *
 * Preliminary input sanitization
 *
 */
foreach ( $input as $key => &$value ) {
	$value = trim( $value );
}

/*
 *
 * Check if the required inputs are **present**
 *
 */
if ( empty( $input[ 'name' ] ) ) {
	$response[ 'statusCode' ] = 4001;
	$response[ 'message' ] = 'Please provide a name.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}
if ( empty( $input[ 'phoneNumber' ] ) ) {
	$response[ 'statusCode' ] = 4002;
	$response[ 'message' ] = 'Please provide a phone number.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}
if ( empty( $input[ 'emailAddress' ] ) ) {
	$response[ 'statusCode' ] = 4003;
	$response[ 'message' ] = 'Please provide an email address.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}
if ( empty( $input[ 'persons' ] ) ) {
	$response[ 'statusCode' ] = 4004;
	$response[ 'message' ] = 'Please provide the number of people attending.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}





/*
 *
 * Check if the input field values are **valid**
 *
 */
// Phone number
if ( ! preg_match( '/^\+?\d+$/', $input[ 'phoneNumber' ] ) ) {
	$response[ 'statusCode' ] = 4005;
	$response[ 'message' ] = 'Please provide a valid phone number.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}

// Email address
if ( ! empty( $input[ 'emailAddress' ] ) ) {
	if ( strpos( $input[ 'emailAddress' ], '@' ) !== false )
		$customer[ 'emailAddress' ] = $input[ 'emailAddress' ];
	else {
		$response[ 'statusCode' ] = 4006;
		$response[ 'message' ] = 'Please provide a valid email address.';
		http_response_code( 400 );
		die( json_encode( $response ) );
	}
}



/*
 *
 * Prepare the mail
 *
 */
$formData = [
	'name' => $input[ 'name' ],
	'phoneNumber' => $input[ 'phoneNumber' ],
	'emailAddress' => $input[ 'emailAddress' ],
	'persons' => $input[ 'persons' ]
];



/*
 *
 * Send the mail
 *
 */
try {
	$status = GoogleForms\submit( $formData );
	$response[ 'statusCode' ] = 0;
	$response[ 'message' ] = 'Enquiry made.';
}
catch ( \Exception $e ) {

	// Respond with an error
	if ( $e->getCode() > 5000 )
		$response[ 'statusCode' ] = $e->getCode();
	else
		$response[ 'statusCode' ] = -1;

	$response[ 'message' ] = $e->getMessage();
	http_response_code( 500 );

}
// Finally, respond back to the client
die( json_encode( $response ) );
