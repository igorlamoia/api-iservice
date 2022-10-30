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

  public function buscarEnderecosUsuario($codUsuario) {
    try {
      $sql = "SELECT * FROM endereco
              INNER JOIN usuarioendereco
              ON usuarioendereco.fk_Endereco_codEnd = endereco.codEnd
              WHERE usuarioendereco.fk_Usuario_codUsuario = :codUsuario";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codUsuario', $codUsuario);
      $sql->execute();

      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao listar requisitante!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

  public function buscarCodCidade ($data) {
    try {
      $sql = "SELECT codCidade FROM cidade c INNER JOIN estado e ON c.fk_Estado_codEstado = e.codEstado
        WHERE c.nome = :nomeCidade AND c.fk_Estado_codEstado = :codEstado";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':nomeCidade', $data['nomeCidade']);
      $sql->bindValue(':codEstado', $data['codEstado']);
      $sql->execute();
      if($sql->rowCount() > 0) {
        return $sql->fetch(\PDO::FETCH_ASSOC)['codCidade'];
      }
      return false;
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao listar requisitante!', 'erro' => $th->errorInfo], 500);
      return false;
    }
  }

  public function buscarCidade ($data) {
    try {
      $sql = "SELECT codCidade, codEstado, c.nome as 'nomeCidade', e.nome as 'UF'
        FROM cidade c INNER JOIN estado e ON c.fk_Estado_codEstado = e.codEstado
        WHERE c.nome = :nomeCidade AND c.fk_Estado_codEstado = :codEstado";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':nomeCidade', $data['nomeCidade']);
      $sql->bindValue(':nomeCidade', $data['codEstado']);
      $sql->execute();
      // if($sql->rowCount() > 0) {
      //   return $sql->fetch(\PDO::FETCH_ASSOC);
      // }
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar codCidade!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

  public function cadastrarCidade ($data) {
    try {
      $sql = "INSERT INTO cidade (nome, fk_Estado_codEstado) VALUES (:nomeCidade, :codEstado)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':nomeCidade', $data['nomeCidade']);
      $sql->bindValue(':codEstado', $data['codEstado']);
      $sql->execute();

      return $this->db->lastInsertId();
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar cidade!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

  public function buscarPrestadorCidadeCadastrado ($codPrestador, $codCidade) {
    try {
      $sql = "SELECT * FROM prestadorcidade WHERE fk_Prestador_codPrestador = :codPrestador AND fk_Cidade_codCidade = :codCidade";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codPrestador', $codPrestador);
      $sql->bindValue(':codCidade', $codCidade);
      $sql->execute();

      return $sql->rowCount() > 0;
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar cidade!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

  public function cadastrarPrestadorCidade($codPrestador, $codCidade) {
    try {
      $sql = "INSERT INTO prestadorcidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) VALUES (:codPrestador, :codCidade)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codPrestador', $codPrestador);
      $sql->bindValue(':codCidade', $codCidade);
      return $sql->execute();
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar prestadorcidade!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

}
