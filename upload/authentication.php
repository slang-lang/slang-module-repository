<?php

require_once( "libs/Database/Database.php" );
require_once( "libs/Database/Tables/Modules.php" );
require_once( "libs/Database/Tables/Users.php" );


// Function to extract the bearer token from the Authorization header
function getBearerToken()
{
    $headers = null;

    // Check if the Authorization header is set
    if ( isset( $_SERVER[ 'HTTP_AUTHORIZATION' ] ) ) {
        $headers = trim( $_SERVER[ 'HTTP_AUTHORIZATION' ] );
    }
    elseif ( isset( $_SERVER[ 'REDIRECT_HTTP_AUTHORIZATION' ] ) ) {
        // For certain server configurations like Apache
        $headers = trim( $_SERVER[ 'REDIRECT_HTTP_AUTHORIZATION' ] );
    }

    // If the Authorization header exists, extract the Bearer token
    if ( $headers && preg_match( '/Bearer\s(\S+)/', $headers, $matches ) ) {
        return $matches[1]; // Return the token
    }

    return null; // Return null if no token found
}

// Validate the Bearer token
function validateBearerToken( $token, $moduleName )
{
    global $valid_token;

    try {
        global $conn;

        $query = "SELECT *
                    FROM users u
                    JOIN user_data ud ON (u.identifier = ud.identifier)
                    JOIN modules m ON (u.identifier = m.owner)
                   WHERE ud.api_key = '" . $token . "'
                     AND m.name = '" . $moduleName . "'";
        //echo "Query: $query\n";

        $module = new TModulesRecord( $conn, $query );
        $user   = new TUsersRecord( $conn, $query );

        return $module->Owner == $user->Identifier;
    }
    catch ( Exception $e ) {
        echo "Error: " . $e->getMessage();
    }

    return false;
}

function authenticateBasic( $moduleName )
{
    // Basic authentication
    global $valid_username;
    global $valid_password;

    if ( $_SERVER[ 'PHP_AUTH_USER' ] !== $valid_username || $_SERVER[ 'PHP_AUTH_PW' ] !== $valid_password ) {
        // Send authentication headers if credentials are invalid
        header( 'WWW-Authenticate: Basic realm="Restricted Area"' );
        header( 'HTTP/1.0 401 Unauthorized' );

        echo "You are not authorized to access this resource.\n";
        exit;
    }

    // user has been authentication successfully
    return $token;
}

function authenticateBearer( $moduleName )
{
    // Bearer authentication
    $token = getBearerToken();

    if ( !$token ) {
        // If no token is provided, return a 401 Unauthorized response
        header( 'HTTP/1.1 401 Unauthorized' );
        echo json_encode( ['error' => 'Token not provided.'] );

        exit;
    }

    if ( !validateBearerToken( $token, $moduleName ) ) {
        // If the token is invalid, return a 403 Forbidden response
        header( 'HTTP/1.1 403 Forbidden' );
        echo json_encode( ['error' => 'Invalid token.'] );

        exit;
    }

    // user has been authentication successfully
}

?>
