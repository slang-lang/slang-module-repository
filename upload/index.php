<?php

//print_r( $_SERVER );
//print_r( $_FILES );
//print_r( $_REQUEST );
//print_r( $_POST );

//foreach ( getallheaders() as $key => $value ) {
//	echo "HEADER $key: $value\n";
//}


require_once( "libs/Database/Tables/Modules.php" );
require_once( "authentication.php" );


$VERSION_SEPERATOR = "_";

// open database connection
ConnectDatabase( true );

// Verify received file data
if ( !isset( $_FILES[ "file" ] ) ) {
    // If no file is provided, return a 405 Invalid operation
    header('HTTP/1.1 405 Invalid operation');
    echo json_encode(['error' => 'Missing file.']);

    exit;
}

$uploadFile = basename( $_FILES[ "file" ][ "name" ] );
if ( !$uploadFile ) {
    // If no file is provided, return a 405 Invalid operation
    header('HTTP/1.1 405 Invalid operation');
    echo json_encode(['error' => 'Missing file.']);

    exit;
}

// retrieve content type
$receivedContentType = $_FILES[ "file" ][ "type" ];
if ( !$receivedContentType ) {
    $receivedContentType = $_SERVER[ "CONTENT_TYPE" ];
}

// verify content type
$allowedTypes = [ "application/json", "application/tar+gzip" ];

if ( !in_array( $receivedContentType, $allowedTypes ) ) {
    echo json_encode( [ "success" => false, "message" => "Unsupported file type." ] );
    exit;
}


$moduleName    = substr( $uploadFile, 0, strpos( $uploadFile, $VERSION_SEPERATOR ) );
$endPos = strpos( $uploadFile, ".json" ) - strlen( $moduleName ) - 1;
if ( !$endPos ) {
    $endPos = strpos( $uploadFile, ".tar.gz" ) - strlen( $moduleName ) - 1;
}
$moduleVersion = substr( $uploadFile, strlen( $moduleName ) + 1, $endPos );

// verify the user
authenticateBearer( $moduleName );

// verify HTTP method and process file upload
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" || $_SERVER[ "REQUEST_METHOD" ] == "PUT" ) {
    //$uploadDir = "";
    //$uploadFile = $uploadDir . basename( $_FILES[ "file" ][ "name" ] );

    // Create the uploads directory if it doesn't exist
    //if ( !is_dir( $uploadDir ) ) {
    //    mkdir( $uploadDir, 0777, true );
    //}

    if ( move_uploaded_file( $_FILES[ "file" ][ "tmp_name" ], $uploadFile ) ) {
        //echo "File is valid, and was successfully uploaded.\n";
    }
    else {
        echo "Possible file upload attack!\n";
    }
}
else {
    echo "No file uploaded.\n";
}

DisconnectDatabase();

?>

