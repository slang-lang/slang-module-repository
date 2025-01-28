<?php

require( "authentication.php" );

//print_r( $_SERVER );
//print_r( $_FILES );
//print_r( $_REQUEST );
//print_r( $_POST );

//foreach ( getallheaders() as $key => $value ) {
//	echo "HEADER $key: $value\n";
//}

// verify the user
authenticate();

// retreive content type
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

// verify HTTP method and process file upload
if ( ( $_SERVER[ "REQUEST_METHOD" ] == "POST" || $_SERVER[ "REQUEST_METHOD" ] == "PUT" ) && isset( $_FILES[ "file" ] ) ) {

	//$uploadDir = "";
	//$uploadFile = $uploadDir . basename( $_FILES[ "file" ][ "name" ] );

	// Create the uploads directory if it doesn't exist
	//if ( !is_dir( $uploadDir ) ) {
	//    mkdir( $uploadDir, 0777, true );
	//}

	$uploadFile = basename( $_FILES[ "file" ][ "name" ] );

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

?>

