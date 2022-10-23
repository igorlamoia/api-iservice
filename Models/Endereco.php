<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Endereco extends Model
{

  public function buscarCodEndereco($data)
  {

    try {
      $sql = "SELECT codEnd FROM endereco
              WHERE rua = :rua AND bairro = :bairro AND cep = :cep AND cidade = :cidade AND estado = :estado";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':rua', $data['rua']);
      $sql->bindValue(':bairro', $data['bairro']);
      $sql->bindValue(':cep', $data['cep']);
      $sql->bindValue(':cidade', $data['cidade']);
      $sql->bindValue(':estado', $data['estado']);


      $sql->execute();

      return $sql->fetch(\PDO::FETCH_ASSOC)['codEnd'];
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao listar requisitante!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }


  public function cadastrar($data)
  {
    try {

      $sql = "INSERT INTO endereco (rua, bairro, cep, cidade, estado) VALUES (:rua, :bairro, :cep, :cidade, :estado)";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':rua', $data['rua']);
      $sql->bindValue(':bairro', $data['bairro']);
      $sql->bindValue(':cep', $data['cep']);
      $sql->bindValue(':cidade', $data['cidade']);
      $sql->bindValue(':estado', $data['estado']);
      $sql->execute();

      return $this->db->lastInsertId();
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar endereço!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }

  public function cadastrarEnderecoRequisitante($data)
  {
    try {

      $sql = "INSERT INTO requisitante_possui_endereco
        (fk_Endereco_codEnd, fk_Requisitante_codRequisitante)
        VALUES (:fk_Endereco_codEnd, :fk_Requisitante_codRequisitante)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':fk_Endereco_codEnd', $data['codEnd']);
      $sql->bindValue(':fk_Requisitante_codRequisitante', $data['codRequisitante']);
      return $sql->execute();

    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar endereço!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }

  public function buscarEnderecosRequisitante($codRequisitante) {
    try {
      $sql = "SELECT * FROM endereco
              INNER JOIN requisitante_possui_endereco
              ON requisitante_possui_endereco.fk_Endereco_codEnd = endereco.codEnd
              WHERE requisitante_possui_endereco.fk_Requisitante_codRequisitante = :codRequisitante";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codRequisitante', $codRequisitante);
      $sql->execute();

      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao listar requisitante!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

}
