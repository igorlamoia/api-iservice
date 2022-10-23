<?php

namespace Models;

use \Core\Model;

class Pessoa extends Model
{

    public function selecionar($data)
    {

        try {
            $sql = "SELECT * FROM pessoas WHERE cpfcnpj = :cpf";


            $sql = $this->db->prepare($sql);
            $sql->bindValue(':cpf', $data['cpf']);

            $sql->execute();

            if ($sql->rowCount() > 0) {
                return $sql->fetch(\PDO::FETCH_ASSOC);
            }

            return false;
        } catch (\Throwable $th) {
        }
    }


    public function atualizarPreCadastro($data)
    {
        try {

            $sql = "";

            $sql = $this->db->prepare($sql);

            $sql->bindValue(':cpf', $data['cpf']);
            $sql->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
