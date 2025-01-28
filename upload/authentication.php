<?php

require( "config.php" );

global $valid_username;
global $valid_password;
global $valid_token;


// Function to extract the bearer token from the Authorization header
function getBearerToken() {
    $headers = null;

    // Check if the Authorization header is set
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
    }
    elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        // For certain server configurations like Apache
        $headers = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    }

    // If the Authorization header exists, extract the Bearer token
    if ($headers && preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        return $matches[1]; // Return the token
    }

    return null; // Return null if no token found
}

// Validate the Bearer token
function validateBearerToken($token) {
    global $valid_token;

    return $token === $valid_token; // Return true if the token matches
}

function authenticate() {

    global $valid_username;
    global $valid_password;
    global $valid_token;

    //echo "$valid_username:$valid_password:$valid_token\n";

    // Basic authentication
    if ( isset( $_SERVER[ 'PHP_AUTH_USER' ] ) ) {
	// Validate the provided username and password

	if ( $_SERVER[ 'PHP_AUTH_USER' ] !== $valid_username || $_SERVER[ 'PHP_AUTH_PW' ] !== $valid_password ) {
            // Send authentication headers if credentials are invalid
            header( 'WWW-Authenticate: Basic realm="Restricted Area"' );
            header( 'HTTP/1.0 401 Unauthorized' );

            echo "You are not authorized to access this resource.\n";
            //return false;
            exit;
        }
    }
    // Bearer authentication
    else {
        $token = getBearerToken();

        if (!$token) {
            // If no token is provided, return a 401 Unauthorized response
            header('HTTP/1.1 401 Unauthorized');
	    echo json_encode(['error' => 'Token not provided.']);

            //return false;
            exit;
        }

        if (!validateBearerToken($token)) {
            // If the token is invalid, return a 403 Forbidden response
            header('HTTP/1.1 403 Forbidden');
	    echo json_encode(['error' => 'Invalid token.']);

            //return false;
            exit;
        }
    }

    // user has been authentication successfully
    return true;
}

?>
