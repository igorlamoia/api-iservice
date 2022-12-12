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
            $sql = "SELECT * from Atendimento a, Usuario u 
                    where a.fk_DemandaEscolher_codPrestador = :codPrestador and a.fk_DemandaEscolher_codUsuario = u.codUsuario
                    ORDER BY a.dataStatus DESC";

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
                    and u.codUsuario = p.fk_Usuario_codUsuario
                ORDER BY a.dataStatus DESC";

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

    public function atualizarAtendimento($data)
    {
        try {
            $sql = "UPDATE Atendimento a SET a.codStatus = :codStatus, a.dataStatus = CURRENT_TIMESTAMP 
                    WHERE a.codAtendimento = :codAtendimento";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':codAtendimento', $data['codAtendimento']);
            $sql->bindValue(':codStatus', $data['codStatus']);

            return $sql->execute();
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao Atualizar atendimento :(', 'erro' => $th], 500);
            return false;
        }
    }



}
