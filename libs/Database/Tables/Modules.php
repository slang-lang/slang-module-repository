<?php

//import System.Collections.Vector;

class TModulesRecord
{
    public $Added;
    public $Architecture;
    public $Downloads;
    public $Keywords;
    public $LastUpdate;
    public $Name;
    public $Owner;
    public $Repository;
    public $Version;

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
        $query = "INSERT INTO modules ( `added`, `architecture`, `downloads`, `keywords`, `last_update`, `name`, `owner`, `repository`, `version` ) VALUES ( NULLIF('" . $this->Added . "', ''), '" . $this->Architecture . "', '" . $this->Downloads . "', '" . $this->Keywords . "', NULLIF('" . $this->LastUpdate . "', ''), '" . $this->Name . "', '" . $this->Owner . "', '" . $this->Repository . "', '" . $this->Version . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }
    }

    public function insertIgnore() {
        $query = "INSERT IGNORE INTO modules ( `added`, `architecture`, `downloads`, `keywords`, `last_update`, `name`, `owner`, `repository`, `version` ) VALUES ( NULLIF('" . $this->Added . "', ''), '" . $this->Architecture . "', '" . $this->Downloads . "', '" . $this->Keywords . "', NULLIF('" . $this->LastUpdate . "', ''), '" . $this->Name . "', '" . $this->Owner . "', '" . $this->Repository . "', '" . $this->Version . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }
    }


    public function insertOrUpdate() {
        $query = "INSERT INTO modules ( `added`, `architecture`, `downloads`, `keywords`, `last_update`, `name`, `owner`, `repository`, `version` ) VALUES ( NULLIF('" . $this->Added . "', ''), '" . $this->Architecture . "', '" . $this->Downloads . "', '" . $this->Keywords . "', NULLIF('" . $this->LastUpdate . "', ''), '" . $this->Name . "', '" . $this->Owner . "', '" . $this->Repository . "', '" . $this->Version . "' ) ON DUPLICATE KEY UPDATE `added` = NULLIF('" . $this->Added . "', ''), `architecture` = '" . $this->Architecture . "', `downloads` = '" . $this->Downloads . "', `keywords` = '" . $this->Keywords . "', `last_update` = NULLIF('" . $this->LastUpdate . "', ''), `name` = '" . $this->Name . "', `owner` = '" . $this->Owner . "', `repository` = '" . $this->Repository . "', `version` = '" . $this->Version . "'";

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

        $this->Added = $row["added"];
        $this->Architecture = $row["architecture"];
        $this->Downloads = $row["downloads"];
        $this->Keywords = $row["keywords"];
        $this->LastUpdate = $row["last_update"];
        $this->Name = $row["name"];
        $this->Owner = $row["owner"];
        $this->Repository = $row["repository"];
        $this->Version = $row["version"];
    }

    public function loadByResult( $result )  {
        $row = $result->fetch_assoc();

        $this->Added = $row["added"];
        $this->Architecture = $row["architecture"];
        $this->Downloads = $row["downloads"];
        $this->Keywords = $row["keywords"];
        $this->LastUpdate = $row["last_update"];
        $this->Name = $row["name"];
        $this->Owner = $row["owner"];
        $this->Repository = $row["repository"];
        $this->Version = $row["version"];
    }

    public function toString() {
        print_r( get_object_vars( $this ) );
    }

    private $DB;
}

?>
