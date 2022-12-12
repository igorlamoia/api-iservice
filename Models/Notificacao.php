<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Notificacao extends Model
{
    public function criarNotificacao($data)
    {

        try {
            $sql = "INSERT INTO Notificacao (texto, fk_Atendimento_codAtendimento)
                    VALUES (:texto, :codAtendimento);";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':codAtendimento', $data['codAtendimento']);
            $sql->bindValue(':texto', $data['texto']);

            $sql->execute();
            return $this->db->lastInsertId();
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao cadastrar solicitacao :(', 'erro' => $th], 500);
            return false;
        }
    }

    public function visualizarNotificacao($data)
    {
        try {
            $sql = "UPDATE Notificacao n SET n.visualizada = 1
                    WHERE n.idNotificacao = :idNotificacao";

            $sql = $this->db->prepare($sql);
            $sql->bindValue(':idNotificacao', $data['idNotificacao']);

            return $sql->execute();
        } catch (\PDOException $th) {
            $controller = new Controller();
            $controller->returnJson(['mensagem' => 'Erro ao visualizar notificação :(', 'erro' => $th], 500);
            return false;
        }
        
    }

    public function buscarNotificacoes($data)
    {
        try {
            $sql = "SELECT n.* from Atendimento a, Notificacao n
                    where
                        a.fk_DemandaEscolher_codUsuario = :codUsuario
                        and n.fk_Atendimento_codAtendimento = a.codAtendimento
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


}
