<?php

//import System.Collections.Vector;

class TUserDataGithubRecord
{
    public $CreateTime;
    public $Email;
    public $ExternalId;
    public $Identifier;
    public $ProfilePicture;
    public $Username;

    public function __construct( $databaseHandle, $query = "" ) {
        $this->DB = $databaseHandle;

        if ( $query ) {
            $this->loadByQuery( $query );
        }
    }

    public function __destruct() {
        // nothing to do here
    }

    public function insert() {
        $query = "INSERT INTO user_data_github ( `create_time`, `email`, `external_id`, `identifier`, `profile_picture`, `username` ) VALUES ( NULLIF('" . $this->CreateTime . "', ''), '" . $this->Email . "', '" . $this->ExternalId . "', '" . $this->Identifier . "', '" . $this->ProfilePicture . "', '" . $this->Username . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }
    }

    public function insertIgnore() {
        $query = "INSERT IGNORE INTO user_data_github ( `create_time`, `email`, `external_id`, `identifier`, `profile_picture`, `username` ) VALUES ( NULLIF('" . $this->CreateTime . "', ''), '" . $this->Email . "', '" . $this->ExternalId . "', '" . $this->Identifier . "', '" . $this->ProfilePicture . "', '" . $this->Username . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }
    }


    public function insertOrUpdate() {
        $query = "INSERT INTO user_data_github ( `create_time`, `email`, `external_id`, `identifier`, `profile_picture`, `username` ) VALUES ( NULLIF('" . $this->CreateTime . "', ''), '" . $this->Email . "', '" . $this->ExternalId . "', '" . $this->Identifier . "', '" . $this->ProfilePicture . "', '" . $this->Username . "' ) ON DUPLICATE KEY UPDATE `create_time` = NULLIF('" . $this->CreateTime . "', ''), `email` = '" . $this->Email . "', `external_id` = '" . $this->ExternalId . "', `identifier` = '" . $this->Identifier . "', `profile_picture` = '" . $this->ProfilePicture . "', `username` = '" . $this->Username . "'";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }
    }

    public function loadByQuery( $query ) {
        $result = mysqli_query( $this->DB, $query );

        if ( !($row = $result->fetch_assoc()) ) {
            throw new Exception( "no result found" );
        }

        $this->CreateTime = $row["create_time"];
        $this->Email = $row["email"];
        $this->ExternalId = $row["external_id"];
        $this->Identifier = $row["identifier"];
        $this->ProfilePicture = $row["profile_picture"];
        $this->Username = $row["username"];
    }

    public function loadByResult( $result )  {
        $row = $result->fetch_assoc();

        $this->CreateTime = $row["create_time"];
        $this->Email = $row["email"];
        $this->ExternalId = $row["external_id"];
        $this->Identifier = $row["identifier"];
        $this->ProfilePicture = $row["profile_picture"];
        $this->Username = $row["username"];
    }

    public function toString() {
        print_r( get_object_vars( $this ) );
    }

    private $DB;
}

?>
