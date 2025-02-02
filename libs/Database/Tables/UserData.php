<?php

//import System.Collections.Vector;

class TUserDataRecord
{
    public $ApiKey;
    public $Email;
    public $Id;
    public $Identifier;
    public $Language;
    public $SendLoginNotifications;
    public $SendMailNotifications;

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
        $query = "INSERT INTO user_data ( `api_key`, `email`, `id`, `identifier`, `language`, `send_login_notifications`, `send_mail_notifications` ) VALUES ( '" . $this->ApiKey . "', '" . $this->Email . "', '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Language . "', '" . $this->SendLoginNotifications . "', '" . $this->SendMailNotifications . "' )";

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
        $query = "INSERT IGNORE INTO user_data ( `api_key`, `email`, `id`, `identifier`, `language`, `send_login_notifications`, `send_mail_notifications` ) VALUES ( '" . $this->ApiKey . "', '" . $this->Email . "', '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Language . "', '" . $this->SendLoginNotifications . "', '" . $this->SendMailNotifications . "' )";

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
        $query = "INSERT INTO user_data ( `api_key`, `email`, `id`, `identifier`, `language`, `send_login_notifications`, `send_mail_notifications` ) VALUES ( '" . $this->ApiKey . "', '" . $this->Email . "', '" . $this->Id . "', '" . $this->Identifier . "', '" . $this->Language . "', '" . $this->SendLoginNotifications . "', '" . $this->SendMailNotifications . "' ) ON DUPLICATE KEY UPDATE `api_key` = '" . $this->ApiKey . "', `email` = '" . $this->Email . "', `identifier` = '" . $this->Identifier . "', `language` = '" . $this->Language . "', `send_login_notifications` = '" . $this->SendLoginNotifications . "', `send_mail_notifications` = '" . $this->SendMailNotifications . "'";

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

        $this->ApiKey = $row["api_key"];
        $this->Email = $row["email"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Language = $row["language"];
        $this->SendLoginNotifications = $row["send_login_notifications"];
        $this->SendMailNotifications = $row["send_mail_notifications"];
    }

    public function loadByPrimaryKey( $id ) {
        $query = "SELECT * FROM user_data WHERE id = '" . $id . "'";

        $result = mysqli_query( $this->DB, $query );

        if ( !($row = $result->fetch_assoc()) ) {
            throw new Exception( "no result found" );
        }

        $this->ApiKey = $row["api_key"];
        $this->Email = $row["email"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Language = $row["language"];
        $this->SendLoginNotifications = $row["send_login_notifications"];
        $this->SendMailNotifications = $row["send_mail_notifications"];
    }

    public function loadByResult( $result )  {
        $row = $result->fetch_assoc();

        $this->ApiKey = $row["api_key"];
        $this->Email = $row["email"];
        $this->Id = $row["id"];
        $this->Identifier = $row["identifier"];
        $this->Language = $row["language"];
        $this->SendLoginNotifications = $row["send_login_notifications"];
        $this->SendMailNotifications = $row["send_mail_notifications"];
    }

    public function toString() {
        print_r( get_object_vars( $this ) );
    }

    public function update( $reloadAfterUpdate = false ) {
        $query = "UPDATE user_data SET `api_key` = '" . $this->ApiKey . "', `email` = '" . $this->Email . "', `identifier` = '" . $this->Identifier . "', `language` = '" . $this->Language . "', `send_login_notifications` = '" . $this->SendLoginNotifications . "', `send_mail_notifications` = '" . $this->SendMailNotifications . "' WHERE id = '" + $Id + "'";

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
