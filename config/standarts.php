<?php
    function getErrorMessage () {
        return [
            "not-found" => "Não foram encontrados registros no Banco de Dados",
            "missing-id" => "Para esta requisição é necessario o ID",
            "missing-data" => "Para esta requisição é necessário um BODY em application/json",
            "missing-fields" => "Existe(m) campo(s) obrigatório(s) faltando",
            "not-valid-email" => "O email informado não é valido",
            "internal-error" => "Não foi possível realizar a operação com o Banco de Dados"
        ];
    }
    function getSuccessMessage () {
        return [
            "item-created" => "Item criado com sucesso no Banco de Dados",
            "item-updated" => "Item editado com sucesso no Banco de Dados",
            "item-deleted" => "Item deletado com sucesso no Banco de Dados",
        ];
    }
    function getStatusCode () {
        return [
            "200" => "HTTP/1.0 200 OK",
            "201" => "HTTP/1.0 201 Created",
            "400" => "HTTP/1.0 400 Bad Request",
            "404" => "HTTP/1.0 404 Not Found",
            "500" => "HTTP/1.0 404 Internal Server Error",
        ];
    }
?>