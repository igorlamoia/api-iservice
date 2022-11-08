<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Usuario extends Model
{
    public function cadastrar($data)
    {

        try {
            $sql = "INSERT INTO Usuario
                (nome, cpf, email, numTelefone, idFirebase, dataNascimento, linkFoto)
            VALUES (:nome, :cpf, :email, :numTelefone, :idFirebase, :dataNascimento, :linkFoto)";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':nome', $data['nome']);
            $sql->bindValue(':cpf', $data['cpf']);
            $sql->bindValue(':email', $data['email']);
            $sql->bindValue(':numTelefone', $data['numTelefone']);
            $sql->bindValue(':idFirebase', $data['idFirebase']);
            $sql->bindValue(':dataNascimento', $data['dataNascimento']);
            $sql->bindValue(':linkFoto', isset($data['linkFoto']) ? $data['linkFoto'] : null);

            $sql->execute();
            return $this->db->lastInsertId();
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao cadastrar usuario :(', 'erro' => $th->errorInfo[2]], 500);
            return false;
        }
    }

    public function verificaUsuarioPrestador($data)
    {

        try {
            $sql = "SELECT u.* FROM Usuario u inner join Prestador p on p.fk_Usuario_codUsuario = u.codUsuario WHERE u.idFirebase = :idFirebase ";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':idFirebase', $data['idFirebase']);

            $sql->execute();

            return $sql->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao verificar usuario!', 'erro' => $th->errorInfo[2]], 500);
            return false;
        }
    }
    public function dadosUsuario($data)
    {

        try {
            $sql = "SELECT u.* FROM Usuario u WHERE idFirebase = :idFirebase";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':idFirebase', $data['idFirebase']);

            $sql->execute();

            return $sql->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao listar usuario!', 'erro' => $th->errorInfo[2]], 500);
            return false;
        }
    }

    public function verificaUsuarioExistente($data)
    {
        try {
            $sql = "SELECT * FROM Usuario WHERE cpf = :cpf OR email = :email";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':cpf', $data['cpf']);
            $sql->bindValue(':email', $data['email']);

            $sql->execute();

            return $sql->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao listar usuario!', 'erro' => $th->errorInfo[2]], 500);
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
