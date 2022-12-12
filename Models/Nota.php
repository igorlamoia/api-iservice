<?php

namespace Models;

use Core\Controller;
use \Core\Model;

class Nota extends Model
{
  public function criarNota($data)
  {
    try {
      $sql = "INSERT into Nota (fk_Atendimento_codAtendimento, nota)
                  VALUES (:codAtendimento, :avaliacao)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codAtendimento', $data['codAtendimento']);
      $sql->bindValue(':avaliacao', $data['avaliacao']);

      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao criar nota :(', 'erro' => $th], 500);
      return false;
    }
  }

  public function adicionarNotaUsuario($data)
  {
    try {
      $sql = "INSERT into UsuarioNota (fk_Nota_codNota, fk_Usuario_codUsuario)
                  VALUES (:codNota, :codUsuario)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codNota', $data['codNota']);
      $sql->bindValue(':codUsuario', $data['codUsuario']);

      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao criar nota :(', 'erro' => $th], 500);
      return false;
    }
  }
  public function adicionarNotaPrestador($data)
  {
    try {
      $sql = "INSERT into PrestadorNota (fk_Nota_codNota, fk_Prestador_codPrestador)
                  VALUES (:codNota, :codPrestador)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codNota', $data['codNota']);
      $sql->bindValue(':codPrestador', $data['codPrestador']);

      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao criar nota :(', 'erro' => $th], 500);
      return false;
    }
  }

  public function adicionarAvaliacaoUsuario($data)
  {
    try {
      $sql = "INSERT into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, texto)
                  VALUES (:codUsuario, :codAtendimento, :texto)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codUsuario', $data['codUsuario']);
      $sql->bindValue(':codAtendimento', $data['codAtendimento']);
      $sql->bindValue(':texto', $data['texto']);

      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao criar nota :(', 'erro' => $th], 500);
      return false;
    }
  }
  public function adicionarAvaliacaoPrestador($data)
  {
    try {
      $sql = "INSERT into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, texto)
                  VALUES (:codPrestador, :codAtendimento, :texto)";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codPrestador', $data['codPrestador']);
      $sql->bindValue(':codAtendimento', $data['codAtendimento']);
      $sql->bindValue(':texto', $data['texto']);

      $sql->execute();
      return $this->db->lastInsertId();
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao criar nota :(', 'erro' => $th], 500);
      return false;
    }
  }

  public function buscarNotaAtendimentoUsuario($data)
  {
    try {
      $sql = "SELECT * from Nota n, UsuarioAvaliaAtendimento uaa 
              where n.fk_Atendimento_codAtendimento = :codAtendimento 
              and  uaa.fk_Atendimento_codAtendimento = :codAtendimento";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codAtendimento', $data['codAtendimento']);

      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar nota :(', 'erro' => $th], 500);
      return false;
    }
  }
  public function buscarNotaAtendimentoPrestador($data)
  {
    try {
      $sql = "SELECT * from Nota n, PrestadorAvaliaAtendimento paa 
              where n.fk_Atendimento_codAtendimento = :codAtendimento 
              and  paa.fk_Atendimento_codAtendimento = :codAtendimento";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codAtendimento', $data['codAtendimento']);

      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar nota :(', 'erro' => $th], 500);
      return false;
    }
  }
  public function buscarTodasNotasEAvaliacoesDoPrestador($codPrestador)
  {
    try {
      $sql = "SELECT * from Nota n, PrestadorNota pn, PrestadorAvaliaAtendimento pa
              WHERE
                pn.fk_Prestador_codPrestador = :codPrestador
                and n.codNota = pn.fk_Nota_codNota
                and pn.fk_Prestador_codPrestador = pa.fk_Prestador_codPrestador
                and n.fk_Atendimento_codAtendimento = pa.fk_Atendimento_codAtendimento";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codPrestador', $codPrestador);

      $sql->execute();
      return $sql->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar nota :(', 'erro' => $th], 500);
      return false;
    }
  }

  public function usuarioAvaliadoPorCodAtendimento($codAtendimento)
  {
    try {
      $sql = "SELECT * from UsuarioAvaliaAtendimento where fk_Atendimento_codAtendimento = :codAtendimento";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codAtendimento', $codAtendimento);

      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar avaliação usuário :(', 'erro' => $th], 500);
      return false;
    }
  }

  public function prestadorAvaliadoPorCodAtendimento($codAtendimento)
  {
    try {
      $sql = "SELECT * from PrestadorAvaliaAtendimento where fk_Atendimento_codAtendimento = :codAtendimento";

      $sql = $this->db->prepare($sql);
      $sql->bindValue(':codAtendimento', $codAtendimento);

      $sql->execute();
      return $sql->fetch(\PDO::FETCH_ASSOC);
    } catch (\PDOException $th) {
      $controller = new Controller();
      $controller->returnJson(['mensagem' => 'Erro ao buscar avaliação prestador :(', 'erro' => $th], 500);
      return false;
    }
  }
}
