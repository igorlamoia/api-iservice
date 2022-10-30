<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Especialidade extends Model
{

  public function cadastrar($data)
  {
    try {

      $sql = "INSERT INTO especialidade (nome, descricao, fk_Categoria_codCategoria) VALUES (:nome, :descricao, :fk_Categoria_codCategoria)";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':nome', $data['nome']);
      $sql->bindValue(':descricao', $data['descricao']);
      $sql->bindValue(':fk_Categoria_codCategoria', $data['codCategoria']);
      $sql->execute();

      return $this->db->lastInsertId();
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson([
        'mensagem' => 'Erro ao cadastrar endereço!',
        'erro' => $e->errorInfo[2],
        'local' => 'Models/Endereco/cadastrar'
      ], 500);
      return false;
    }
  }
  public function buscarCodEspecialidade($data)
  {
    try {

      $sql = "SELECT codEspecialidade from especialidade WHERE nome = :nome AND descricao  = :descricao AND fk_Categoria_codCategoria = :fk_Categoria_codCategoria";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':nome', $data['nome']);
      $sql->bindValue(':descricao', $data['descricao']);
      $sql->bindValue(':fk_Categoria_codCategoria', $data['codCategoria']);
      $sql->execute();

      if ($sql->rowCount() > 0) {
        return $sql->fetch(\PDO::FETCH_ASSOC)['codEspecialidade'];
      } else {
        return false;
      }
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson([
        'mensagem' => 'Erro ao cadastrar endereço!',
        'erro' => $e->errorInfo[2],
        'local' => 'Models/Endereco/cadastrar'
      ], 500);
      return false;
    }
  }


  public function cadastrarPrestadorEspecialidade($codPrestador, $codEspecialidade)
  {
    try {
      $sql = "INSERT INTO prestadorespecialidade (fk_Especialidade_codEspecialidade, fk_Prestador_codPrestador) VALUES (:fk_Especialidade_codEspecialidade, :fk_Prestador_codPrestador)";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':fk_Prestador_codPrestador',  $codPrestador);
      $sql->bindValue(':fk_Especialidade_codEspecialidade', $codEspecialidade);
      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar usuario :(', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }

  public function buscarPrestadorEspecialidade($codPrestador, $codEspecialidade)
  {
    try {
      $sql = "SELECT * FROM prestadorespecialidade WHERE fk_Especialidade_codEspecialidade = :fk_Especialidade_codEspecialidade AND fk_Prestador_codPrestador = :fk_Prestador_codPrestador";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':fk_Especialidade_codEspecialidade', $codEspecialidade);
      $sql->bindValue(':fk_Prestador_codPrestador',  $codPrestador);
      $sql->execute();

      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar usuario :(', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }


  public function listarEspecialidadesPorParametro($servico)
  {
    try {
      $sql = "SELECT e.codEspecialidade, e.nome as 'nomeEspecialidade', e.descricao, c.codCategoria, c.nome as 'nomeCategoria'
        from especialidade e INNER JOIN categoria c ON c.codCategoria = e.fk_Categoria_codCategoria
        WHERE e.nome like CONCAT('%',:servico,'%') OR e.descricao like CONCAT('%',:servico,'%')";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':servico', $servico);
      $sql->execute();
      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao cadastrar prestadorcidade!', 'erro' => $th->errorInfo[2]], 500);
      return false;
    }
  }
}
