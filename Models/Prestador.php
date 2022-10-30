<?php

namespace Models;

use Core\Controller;
use \Core\Model;


class Prestador extends Model
{

  public function buscarInformacoesPrestadorNoBancoDeDados($cpf)
  {

    try {

      $sql = "SELECT * FROM prestador WHERE cpf = :cpf";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':cpf', $cpf);
      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar informações do prestador!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }


  public function cadastrarPrestador($data) {
    try {
      $sql = "INSERT INTO prestador
          (descricaoProfissional, horarioAtendimentoInicio, horarioAtendimentoFim, fk_Usuario_codUsuario)
      VALUES (:descricaoProfissional, :horarioAtendimentoInicio, :horarioAtendimentoFim, :fk_Usuario_codUsuario)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':descricaoProfissional', $data['descricaoProfissional']);
      $sql->bindValue(':horarioAtendimentoInicio', $data['horarioAtendimentoInicio']);
      $sql->bindValue(':horarioAtendimentoFim', $data['horarioAtendimentoFim']);
      $sql->bindValue(':fk_Usuario_codUsuario', $data['codUsuario']);

      $sql->execute();
      return $this->db->lastInsertId();
  } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar usuario :(', 'erro' => $th->errorInfo[2]], 500);
      return false;
  }
  }

  public function buscarPrestadorPorCodUsuario($codUsuario)
  {
    try {
      $sql = "SELECT codPrestador FROM prestador WHERE fk_Usuario_codUsuario = :codUsuario";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codUsuario', $codUsuario);
      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar prestadores!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }
  public function buscarTudo()
  {
    try {
      $sql = "SELECT * FROM prestador";
      $sql = $this->db->prepare($sql);
      $sql->execute();
      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar prestadores!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }
}
