<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Atendimento extends Model
{
    public function cadastrarSolicitacao($data)
    {

        try {
            $sql = "INSERT INTO Atendimento
                (descricao, FK_DemandaEscolher_codUsuario, FK_DemandaEscolher_codPrestador)
            VALUES (:descricao, :codUsuario, :codPrestador)";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':descricao', $data['descricao']);
            $sql->bindValue(':codUsuario', $data['codUsuario']);
            $sql->bindValue(':codPrestador', $data['codPrestador']);

            $sql->execute();
            return $this->db->lastInsertId();
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao cadastrar solicitacao :(', 'erro' => $th], 500);
            return false;
        }
    }

    public function buscarDemandas($data)
    {
        try {
            $sql = "SELECT * from Atendimento a, Usuario u where a.fk_DemandaEscolher_codPrestador = :codPrestador and a.fk_DemandaEscolher_codUsuario = u.codUsuario";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':codPrestador', $data['codPrestador']);

            $sql->execute();
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao buscar demandas :(', 'erro' => $th], 500);
            return false;
        }
    }

    public function buscarSolicitacoes($data)
    {
        try {
            $sql = "SELECT a.*, u.*
                from Atendimento a, Usuario u, Prestador p
                where
                    a.fk_DemandaEscolher_codUsuario = :codUsuario
                    and p.codPrestador = a.fk_DemandaEscolher_codPrestador
                    and u.codUsuario = p.fk_Usuario_codUsuario";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':codUsuario', $data['codUsuario']);

            $sql->execute();
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao buscar demandas :(', 'erro' => $th], 500);
            return false;
        }
    }

}
