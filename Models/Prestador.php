<?php

namespace Models;

use Core\Controller;
use \Core\Model;


class Prestador extends Model
{

  public function buscarInformacoesPrestadorNoBancoDeDados($cpf)
  {

    try {

      $sql = "SELECT * FROM Prestador WHERE cpf = :cpf";
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


  public function cadastrarPrestador($data)
  {
    try {
      $sql = "INSERT INTO Prestador
          (descricaoProfissional, horarioAtendimentoInicio, horarioAtendimentoFim, fk_Usuario_codUsuario, diasAtendimento)
      VALUES (:descricaoProfissional, :horarioAtendimentoInicio, :horarioAtendimentoFim, :fk_Usuario_codUsuario, :diasAtendimento)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':descricaoProfissional', $data['descricaoProfissional']);
      $sql->bindValue(':horarioAtendimentoInicio', $data['horarioAtendimentoInicio']);
      $sql->bindValue(':horarioAtendimentoFim', $data['horarioAtendimentoFim']);
      $sql->bindValue(':fk_Usuario_codUsuario', $data['codUsuario']);
      $sql->bindValue(':diasAtendimento', $data['diasAtendimento']);

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
      $sql = "SELECT codPrestador FROM Prestador WHERE fk_Usuario_codUsuario = :codUsuario";
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
  public function informacoesPrestadores()
  {
    try {
      $sql = "SELECT * FROM Prestador p
      INNER JOIN Usuario u ON u.codUsuario = p.fk_Usuario_codUsuario
      ORDER BY p.codPrestador DESC LIMIT 5";
      $sql = $this->db->prepare($sql);
      $sql->execute();
      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar prestadores!', 'erro' => $e->errorInfo[2]], 500);
      return false;
    }
  }

  public function buscarPrestadorPorFiltros($filtros)
  {
    try {
      $dias = $filtros['diasAtendimento'];
      $sql = "SELECT
      DISTINCT u.*,
      p.* FROM Usuario u,
      Prestador p,
      PrestadorCidade pc,
      Cidade c,
      Estado e,
      PrestadorEspecialidade pe,
      Especialidade esp,
      Categoria cat
    WHERE
      u.codUsuario = p.fk_Usuario_codUsuario
      AND p.codPrestador = pc.fk_Prestador_codPrestador
      AND pc.fk_Cidade_codCidade = c.codCidade
      AND p.codPrestador = pc.fk_Prestador_codPrestador
      AND pc.fk_Cidade_codCidade = c.codCidade
      AND p.codPrestador = pe.fk_Prestador_codPrestador
      AND pe.fk_Especialidade_codEspecialidade = esp.codEspecialidade
      AND esp.fk_Categoria_codCategoria = cat.codCategoria
      AND (
        
        (false OR  p.horarioAtendimentoInicio = :horarioAtendimentoInicio)
        $dias
        AND (false OR p.horarioAtendimentoFim = :horarioAtendimentoFim)
        AND (false OR c.codCidade = :codCidade)
        AND (false OR esp.codEspecialidade = :codEspecialidade)
        AND (false OR esp.descricao = :descricao)
        AND (false OR cat.codCategoria = :codCategoria)
        
    )
    ";
      $sql = $this->db->prepare($sql);
     // $sql->bindValue(':nome', $filtros['nome']);
      $sql->bindValue(':horarioAtendimentoInicio', $filtros['horarioAtendimentoInicio']);
      $sql->bindValue(':horarioAtendimentoFim', $filtros['horarioAtendimentoFim']);
      $sql->bindValue(':codCidade', $filtros['codCidade']);
      //$sql->bindValue(':diasAtendimento', $filtros['diasAtendimento']);
      $sql->bindValue(':codEspecialidade', $filtros['codEspecialidade']);
      $sql->bindValue(':descricao', $filtros['descricao']);
      $sql->bindValue(':codCategoria', $filtros['codCategoria']);
      
      $sql->execute();
      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar prestadores!', 'erro' => $e], 500);
      return false;
    }
  }
}
//
//(false OR (lower(u.nome) LIKE lower('%:nome%')))