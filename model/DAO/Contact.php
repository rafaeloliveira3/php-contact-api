<?php

    require_once("./Connection.php");

    class Contact {
        private $connection;
        private $query;

        function __construct() {
            $this->connection = (new Connection())->dbConnection();
        }

        function getAllContacts() {
            $this->query = "SELECT * FROM tbl_contacts";
            try {
                $statement = $this->connection->prepare($this->query);
                $statement->execute();
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (empty($data)) {
                    return false;
                }
                return $data;
            } catch (Exception) {
                return false;
            }
        }

        function getContactById(int $id) {
            $this->query = "SELECT * FROM tbl_contacts WHERE id = $id";
            try {
                $statement = $this->connection->prepare($this->query);
                $statement->execute();
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                if (empty($data)) {
                    return false;
                }
                return $data;
            } catch (Exception) {
                return false;
            }
        }

        function deleteContactById(int $id) {
            $this->query = "DELETE FROM tbl_contacts WHERE id = $id";
            try {
                $statement = $this->connection->prepare($this->query);
                $statement->execute();
                $data = $statement->rowCount();
                if (empty($data)) {
                    return false;
                }
                return $data;
            } catch (Exception) {
                return false;
            }
        }

        function createNewContact(array $data) {
            $fields = [
                'name',
                'birth_date',
                'email',
                'profession',
                'phone',
                'cellphone',
                'has_whatsapp',
                'email_notifications',
                'sms_notifications'
            ];

            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $this->query = "INSERT INTO tbl_contacts (" . implode(', ', $fields) . ") VALUES ({$placeholders})";

            try {
                $statement = $this->connection->prepare($this->query);
                $statement->execute(array_values($data));
                $data = $statement->rowCount();
                if (empty($data)) {
                    return false;
                }
                return $data;
            } catch (Exception) {
                return false;
            }
        }

        function editExistingContact (int $id, array $data) {
            $fields = [
                'name',
                'birth_date',
                'email',
                'profession',
                'phone',
                'cellphone',
                'has_whatsapp',
                'email_notifications',
                'sms_notifications'
            ];
            $placeholders = implode(', ', array_map(function ($item) { return "$item = ?"; }, $fields));
            $this->query = "UPDATE tbl_contacts SET {$placeholders} WHERE id = $id";

            try {
                $statement = $this->connection->prepare($this->query);
                $statement->execute(array_values($data));
                $data = $statement->rowCount();
                if (empty($data)) {
                    return false;
                }
                return $data;
            } catch (Exception) {
                return false;
            }
        }
    }
?>