<?php
    header("Access-Controll-Allow-Origin: *");
    header("Access-Controll-Allow-Headers: *");
    header("Access-Controll-Allow-Methods: GET, POST, PUT, DELETE");
    header("Content-Type: application/json");

    require_once("./controller/ContactController.php");
    require_once("./config/standarts.php");

    class Router {
        private $method;
        private $reqData;
        private $contactController;
        private $errMessage;
        private $statusCode;

        function __construct() {
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->reqData = json_decode(file_get_contents("php://input"), true);
            $this->contactController = new ContactController();
            $this->errMessage = getErrorMessage(); 
            $this->statusCode = getStatusCode(); 
        }

        function ContactRouter () {
            switch ($this->method) {
                case "GET": {
                    if (empty($_GET["id"])) {
                        return $this->contactController->getAll();
                    }
                    return $this->contactController->getById($_GET["id"]);
                }
                break;

                case "POST": {
                    if (empty($this->reqData)) {
                        header($this->statusCode["400"]);
                        return ["data" => $this->errMessage["missing-data"]];
                    }
                    return $this->contactController->createNew($this->reqData);
                }
                break;

                case "PUT": {
                    if (empty($_GET["id"])) {
                        header($this->statusCode["400"]);
                        return ["data" => $this->errMessage["missing-id"]];
                    }
                    if (empty($this->reqData)) {
                        header($this->statusCode["400"]);
                        return ["data" => $this->errMessage["missing-data"]];
                    }
                    return $this->contactController->editExisting($_GET["id"], $this->reqData);
                }
                break;

                case "DELETE": {
                    if (empty($_GET["id"])) {
                        header($this->statusCode["400"]);
                        return ["data" => $this->errMessage["missing-id"]];
                    }
                    return $this->contactController->deleteById($_GET["id"]);
                }
                break;
            }
        }
    }

    $server = new Router();
    $data = $server->ContactRouter();
    if ($data) {
        echo json_encode($data);
    }
?>