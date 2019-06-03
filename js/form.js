
/*
 * -----
 * On submitting the Customer form, create a customer
 * -----
 */
$( document ).on( "submit", ".js_registration_form", async function ( event ) {

	/* -----
	 * Prevent the default form submission behaviour
	 * 	which triggers the loading of a new page
	 ----- */
	event.preventDefault();

	var $form = $( event.target );
	var domForm = $form.get( 0 );
	var $formFieldsAndElements = $form.find( "input, textarea, select, button" );
	var $feedbackMessage = $form.find( ".js_feedback_message" );

	/* -----
	 * Disable the form
	 ----- */
	$formFieldsAndElements.prop( "disabled", true );
	$feedbackMessage.text( "" );

	/* -----
	 * Pull the data from the form
	 ----- */
		// Name
	var $name = $form.find( "[ name = 'name' ]" );
		// Phone number
	var $phoneNumber = $form.find( "[ name = 'phoneNumber' ]" );
		// Email address
	var $emailAddress = $form.find( "[ name = 'emailAddress' ]" );

	/* -----
	 * Sanitize the data
	 ----- */
	// Name
	$name.val( $name.val().trim() );
	// Phone number
	$phoneNumber.val( $phoneNumber.val().replace( /[^\d\s()-+]/g, "" ) );
	// Email address
	$emailAddress.val( $emailAddress.val().trim() );


	/* -----
	 * Validate the data
	 ----- */
	// Clear all error messages / indicators from the last submission
	//  	( if there was one )
	$form.find( ".form-error" ).removeClass( "form-error" );

	// Name
	if ( ! $name.val() )
		$name.addClass( "form-error" );
	// Phone number
	if ( ! $phoneNumber.val().replace( /\D/g, "" ) )
		$phoneNumber.addClass( "form-error" );
	// Email address
	if ( ! $emailAddress.val() || ( ! $emailAddress.val().includes( "@" ) ) )
		$emailAddress.addClass( "form-error" );

	// If the form has even one validation issue
	// do not proceed
	if ( $form.find( ".form-error" ).length ) {
		$formFieldsAndElements.prop( "disabled", false );
		$feedbackMessage.html( `
			Please fill in the fields marked <span style="color: rgba( 255, 42, 46, 0.75 ); font-weight: 900">red</span>.
		` );
		return;
	}
	$feedbackMessage.text( "Registering you....." );

	/* -----
	 * Assemble the data
	 ----- */
	var information = { };
	information.name = $name.val();
	information.phoneNumber = $phoneNumber.val();
	information.emailAddress = $emailAddress.val();

	/* -----
	 * Make the enquiry
	 ----- */
	 addRegistration( information )
	 	.then( function () {
	 		$feedbackMessage.text( "You're registration has been accepted! We’ll get back to you with the details." );
	 		trackPageVisit( "form-fill" );
	 	} )
	 	.catch( function () {
	 		$feedbackMessage.text( "Something went wrong. Please try again later." );
	 	} )

} );



/*
 *
 * Handle error / exception response helper
 *
 */
function getErrorResponse ( jqXHR, textStatus, e ) {
	var statusCode = -1;
	var message;
	if ( jqXHR.responseJSON ) {
		code = jqXHR.responseJSON.statusCode;
		message = jqXHR.responseJSON.message;
	}
	else if ( typeof e == "object" ) {
		message = e.stack;
	}
	else {
		message = jqXHR.responseText;
	}
	return {
		code,
		message
	};
}



/*
 *
 * Register a person
 *
 */
function addRegistration ( information ) {

	// Build the payload
	var requestPayload = information;

	var url = location.origin + "/server/registrations.php";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "POST",
		data: requestPayload,
		dataType: "json",
	} );

	return new Promise( function ( resolve, reject ) {
		ajaxRequest.done( function ( response ) {
			resolve( response );
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}
