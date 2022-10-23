<?php

namespace Providers;
use \Models\Endereco as EnderecoModel;

class Endereco
{
    public static function buscarOuCadastrarCodEndereco($data)
    {
        $endereco = new EnderecoModel();
        $codEnd = $endereco->buscarCodEndereco($data);
        if (!$codEnd) {
          $codEnd = $endereco->cadastrar($data);
        }
        return $codEnd;

    }
    public static function buscarEnderecosRequisitante($codRequisitante) {
        $endereco = new EnderecoModel();
        return $endereco->buscarEnderecosRequisitante($codRequisitante);
    }
}
