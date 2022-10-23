<?php

namespace Providers;
use \Models\Endereco as EnderecoModel;

class EnderecoProvider
{
    static function buscarOuCadastrarCodEndereco($data)
    {
        $endereco = new EnderecoModel();
        $codEnd = $endereco->buscarCodEndereco($data);
        if (!$codEnd) {
          $codEnd = $endereco->cadastrar($data);
        }
        return $codEnd;

    }
    static function buscarEnderecosRequisitante($codRequisitante) {
        $endereco = new EnderecoModel();
        return $endereco->buscarEnderecosRequisitante($codRequisitante);
    }
}
