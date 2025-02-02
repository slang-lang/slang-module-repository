<?php

//import System.Collections.Vector;

class VModulesRecord
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
