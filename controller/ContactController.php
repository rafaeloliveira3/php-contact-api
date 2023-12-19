<?php
    
    require_once("./model/DAO/Contact.php");
    require_once("./config/standarts.php");

    function response($statusCode, $data) {
        header($statusCode);
        return ["data" => $data];
    }

    class ContactController {
        private $contact;
        private $errMessage;
        private $successMessage;
        private $statusCode;

        function __construct() {
            $this->contact = new Contact();
            $this->errMessage = getErrorMessage();
            $this->successMessage = getSuccessMessage();
            $this->statusCode = getStatusCode();
        }

        function getAll () {
            $data = $this->contact->getAllContacts();
            if ($data)
                return response($this->statusCode["200"], $data);

            return response($this->statusCode["404"], $this->errMessage["not-found"]);
        }

        function getById (int $id) {
            $data = $this->contact->getContactById($id);
            if ($data) 
                return response($this->statusCode["200"], $data);

            return response($this->statusCode["404"], $this->errMessage["not-found"]);
        }

        function deleteById (int $id) {
            $data = $this->contact->deleteContactById($id);
            if ($data) 
                return response($this->statusCode["200"], $this->successMessage["item-deleted"]);

            return response($this->statusCode["404"], $this->errMessage["not-found"]);
        }

        function createNew (array $data) {
            $requiredFields = ["name", "birth_date", "email", "profession", "cellphone"];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return response($this->statusCode["400"], $this->errMessage["missing-fields"]);
                }
            }
            if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                return response($this->statusCode["400"], $this->errMessage["not-valid-email"]);
            }
            
            $result = $this->contact->createNewContact($data);
            if ($result) 
                return response($this->statusCode["201"], $this->successMessage["item-created"]);
            else 
                return response($this->statusCode["500"], $this->errMessage["internal-error"]);
        }

        function editExisting (int $id, array $data) {
            $requiredFields = ["name", "birth_date", "email", "profession", "cellphone"];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return response($this->statusCode["400"], $this->errMessage["missing-fields"]);
                }
            }
            if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                return response($this->statusCode["400"], $this->errMessage["not-valid-email"]);
            }
            
            $result = $this->contact->editExistingContact($id, $data);
            if ($result) 
                return response($this->statusCode["200"], $this->successMessage["item-updated"]);
            else 
                return response($this->statusCode["500"], $this->errMessage["internal-error"]);
        }
    }
?>