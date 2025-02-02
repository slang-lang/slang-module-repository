<?php

//import System.Collections.Vector;

class TUsersRecord
{
    public $Created;
    public $Deleted;
    public $Id;
    public $Identifier;
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

    public function insert( $reloadAfterInsert = false ) {
        $query = "INSERT INTO users ( `created`, `deleted`, `id`, `identifier`, `username` ) VALUES ( NULLIF('" . $this->Created . "', ''), NULLIF('" . $this->Deleted . "', ''), '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Username . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        if ( $reloadAfterInsert ) {
            if ( !$this->Id ) {
                $this->Id = $this->getLastInsertId();
            }

            $this->loadByPrimaryKey( $this->Id );
        }
    }

    public function insertIgnore( $reloadAfterInsert = false ) {
        $query = "INSERT IGNORE INTO users ( `created`, `deleted`, `id`, `identifier`, `username` ) VALUES ( NULLIF('" . $this->Created . "', ''), NULLIF('" . $this->Deleted . "', ''), '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Username . "' )";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        if ( $reloadAfterInsert ) {
            if ( !$this->Id ) {
                $this->Id = $this->getLastInsertId();
            }

            $this->loadByPrimaryKey( $this->Id );
        }
    }


    public function insertOrUpdate( $reloadAfterInsert = false ) {
        $query = "INSERT INTO users ( `created`, `deleted`, `id`, `identifier`, `username` ) VALUES ( NULLIF('" . $this->Created . "', ''), NULLIF('" . $this->Deleted . "', ''), '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Username . "' ) ON DUPLICATE KEY UPDATE `created` = NULLIF('" . $this->Created . "', ''), `deleted` = NULLIF('" . $this->Deleted . "', ''), `identifier` = '" . $this->Identifier . "', `username` = '" . $this->Username . "'";

        $result = mysqli_query( $this->DB, $query );

        if ( mysqli_error( $this->DB ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        if ( $reloadAfterInsert ) {
            if ( !$this->Id ) {
                $this->Id = $this->getLastInsertId();
            }

            $this->loadByPrimaryKey( $this->Id );
        }
    }

    public function loadByQuery( $query ) {
        $result = mysqli_query( $this->DB, $query );
        if ( !($row = $result->fetch_assoc()) ) {
            throw new Exception( "no result found" );
        }

        $this->Created = $row["created"];
        $this->Deleted = $row["deleted"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Username = $row["username"];
    }

    public function loadByPrimaryKey( $id ) {
        $query = "SELECT * FROM users WHERE id = '" . $id . "'";

        $result = mysqli_query( $this->DB, $query );

        if ( !($row = $result->fetch_assoc()) ) {
            throw new Exception( "no result found" );
        }

        $this->Created = $row["created"];
        $this->Deleted = $row["deleted"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Username = $row["username"];
    }

    public function loadByResult( $result )  {
        $row = $result->fetch_assoc();

        $this->Created = $row["created"];
        $this->Deleted = $row["deleted"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Username = $row["username"];
    }

    public function toString() {
        print_r( get_object_vars( $this ) );
    }

    public function update( $reloadAfterUpdate = false ) {
        $query = "UPDATE users SET `created` = NULLIF('" . $this->Created . "', ''), `deleted` = NULLIF('" . $this->Deleted . "', ''), `identifier` = '" . $this->Identifier . "', `username` = '" . $this->Username . "' WHERE id = '" + $Id + "'";

        $error = mysql_query( $this->DB, $query );
        if ( $error ) {
            throw mysql_error( $this->DB );
        }

        if ( $reloadAfterUpdate ) {
            $this->loadByPrimaryKey( $Id );
        }
    }

    private function getLastInsertId() {
        $query = "SELECT LAST_INSERT_ID() AS id;";

        $error = mysqli_query( $this->DB, $query );
        if ( error ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        $result = mysql_store_result( $this->DB );
        if ( !result ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        if ( !mysql_fetch_row( $result ) ) {
            throw new Exception( mysqli_error( $this->DB ) );
        }

        return mysqli_get_field_value( $result, "id" );
    }

    private $DB;
}

?>
