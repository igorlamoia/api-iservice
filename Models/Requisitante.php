<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Requisitante extends Model
{
    public function cadastrar($data)
    {

        try {
            $sql = "INSERT INTO requisitante
                (nome, cpf, email, numTelefone, endNumero, endComplemento, idFirebase)
            VALUES (:nome, :cpf, :email, :numTelefone, :endNumero, :endComplemento, :idFirebase)";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':nome', $data['nome']);
            $sql->bindValue(':cpf', $data['cpf']);
            $sql->bindValue(':email', $data['email']);
            $sql->bindValue(':numTelefone', $data['numTelefone']);
            $sql->bindValue(':endNumero', $data['endNumero']);
            $sql->bindValue(':endComplemento', $data['endComplemento']);
            $sql->bindValue(':idFirebase', $data['idFirebase']);

            $sql->execute();
            return true;
            // return $this->db->lastInsertId(); TODO ajustar o banco
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao cadastrar requisitante :(', 'erro' => $th->errorInfo[2]], 500);
            return false;
        }
    }

    public function dadosRequisitante($data)
    {

        try {
            $sql = "SELECT * FROM requisitante WHERE idFirebase = :idFirebase";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':idFirebase', $data['idFirebase']);

            $sql->execute();

            return $sql->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao listar requisitante!', 'erro' => $th->errorInfo[2]], 500);
            return false;
        }
    }


    public function atualizarPreCadastro($data)
    {
        try {

            $sql = "";

            $sql = $this->db->prepare($sql);

            $sql->bindValue(':cpf', $data['cpf']);
            $sql->execute();

            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
