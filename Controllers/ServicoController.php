<?php

namespace Controllers;

use Core\Controller;
use Models\Especialidade;
use Models\Prestador;
use Providers\Endereco as EnderecoProvider;

// Quero buscar informações do usuário no banco pelo cpf
class ServicoController extends Controller {
  public function listarServicos() {
    $requisicao = $this->getRequestData();
    $especialidade = new Especialidade();
    $arrayServicos = $especialidade->listarEspecialidadesPorParametro($requisicao['search']);
    $arrayResposta = ['payload' => []];
    // sleep(2);
    foreach ($arrayServicos as $servico) {
      $arrayResposta['payload'][] = [
        'codEspecialidade' => $servico['codEspecialidade'],
        'nomeEspecialidade' => $servico['nomeEspecialidade'],
        'descricao' => $servico['descricao'],
        'codCategoria' => $servico['codCategoria'],
        'nomeCategoria' => $servico['nomeCategoria'],
      ];
    }
    $this->returnJson($arrayResposta, 200);
  }

}