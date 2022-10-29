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
