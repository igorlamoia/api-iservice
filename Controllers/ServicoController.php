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
  public function listarTodasCategorias() {
    $especialidade = new Especialidade();
    if($categorias = $especialidade->listarTodasCategorias()) return $this->returnJson(['payload' => $categorias], 200);

    $this->returnJson(['mensagem' => 'Falha ao listar categorias!'], 500);
  }
  public function listarTodasProfissoes() {
    $especialidade = new Especialidade();
    if($categorias = $especialidade->listarTodasProfissoes()) return $this->returnJson(['payload' => $categorias], 200);

    $this->returnJson(['mensagem' => 'Falha ao listar profissões!'], 500);
  }
  public function listarTodasEspecialidades() {
    $especialidade = new Especialidade();
    if($categorias = $especialidade->listarTodasEspecialidades()) return $this->returnJson(['payload' => $categorias], 200);

    $this->returnJson(['mensagem' => 'Falha ao listar especialidades!'], 500);
  }

}