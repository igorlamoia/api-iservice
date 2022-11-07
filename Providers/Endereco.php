<?php

namespace Providers;

use \Models\Endereco as EnderecoModel;

class Endereco
{
  public static function buscarOuCadastrarCodEndereco($data)
  {
    $endereco = new EnderecoModel();
    $codEnd = $endereco->buscarCodEndereco($data);
    if (!$codEnd) $codEnd = $endereco->cadastrar($data);

    return $codEnd;
  }
  public static function buscarEnderecosUsuario($codRequisitante)
  {
    $endereco = new EnderecoModel();
    return $endereco->buscarEnderecosUsuario($codRequisitante);
  }

  public static function buscarOuCadastrarCidade($codPrestador, $data)
  {
    $endereco = new EnderecoModel();
    $codCidade = $endereco->buscarCodCidade($data);
    if (!$codCidade) {
      $codCidade = $endereco->cadastrarCidade($data);
    }

    $prestadorCidadeCadastrada = $endereco->buscarPrestadorCidadeCadastrado($codPrestador, $codCidade);
    if (!$prestadorCidadeCadastrada) return $endereco->cadastrarPrestadorCidade($codPrestador, $codCidade);
  }
}
