<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Endereco extends Model
{

  public function buscarCodEndereco($data)
  {

    try {
      $sql = "SELECT codEnd FROM endereco WHERE cep = :cep;";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':cep', $data['cep']);
      $sql->execute();
      $resultado = $sql->fetch(\PDO::FETCH_ASSOC);

      if($resultado) return $resultado['codEnd'];

      return false;
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
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar endereço!',
      'erro' => $e->errorInfo[2],
      'local' => 'Models/Endereco/cadastrar'], 500);
      return false;
    }
  }

  public function cadastrarEnderecoUsuario($data)
  {
    try {

      $sql = "INSERT INTO usuarioendereco
      (fk_Endereco_codEnd, fk_Usuario_codUsuario, endNumero, endComplemento)
        VALUES (:fk_Endereco_codEnd, :fk_Usuario_codUsuario, :endNumero, :endComplemento)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':fk_Endereco_codEnd', $data['codEndereco']);
      $sql->bindValue(':fk_Usuario_codUsuario', $data['codUsuario']);
      $sql->bindValue(':endNumero', $data['endNumero']);
      $sql->bindValue(':endComplemento', $data['endComplemento']);

      return $sql->execute();

    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar endereço!', 'erro' => $e, 'local' => 'Models/Endereco/cadastrarEnderecoUsuario'], 500);
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
