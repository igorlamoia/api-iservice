<?php

namespace Controllers;

use Core\Controller;
use Models\Especialidade;
use Models\Prestador;

// Quero buscar informações do usuário no banco pelo cpf
class PrestadorController extends Controller {
  public function buscarInformacoesPrestador() {
    $array = $this->getRequestData();
    $cpf = $array['cpf'];
    $prestadorModel = new Prestador();

    $respostaDoBanco = $prestadorModel->buscarInformacoesPrestadorNoBancoDeDados($cpf);

    if($respostaDoBanco) {
      $this->returnJson([
        'mensagem' => 'Informações do prestador encontradas com sucesso!',
        'informacoes' => $respostaDoBanco
      ], 200);
    } else {
      $this->returnJson(['mensagem' => 'Prestador não encontrado!'], 404);
    }

  }

  public function cadastrarPrestador() {
    $requisicao = $this->getRequestData();

    $prestadorModel = new Prestador();
    $codPrestador = $prestadorModel->cadastrarPrestador($requisicao);
    if(!$codPrestador) $this->returnJson(['mensagem' => 'Erro ao cadastrar prestador!'], 500);

    $especialidadeModel = new Especialidade();
    foreach($requisicao['especialidades'] as $especialidade) {
      $codEspecialidade = $especialidadeModel->verificaSeExiste($especialidade);

      if(!$codEspecialidade) {
        $codEspecialidade = $especialidadeModel->cadastrar($especialidade);
        if(!$codEspecialidade) $this->returnJson(['mensagem' => 'Erro ao cadastrar especialidade!'], 500);
      }

      $especialidadeModel->cadastrarPrestadorEspecialidade($codPrestador, $codEspecialidade);
    }


    $this->returnJson([
      'mensagem' => 'Prestador cadastrado com sucesso!'
    ], 201);
  }

  public function buscarTodosOsPrestadores () {
    $prestadorModel = new Prestador();
    $prestadores = $prestadorModel->buscarTudo();

    if($prestadores) {
      $this->returnJson([
        'mensagem' => 'Prestadores encontrados com sucesso!',
        'prestadores' => $prestadores
      ], 200);
    } else {
      $this->returnJson(['mensagem' => 'Nenhum prestador encontrado!'], 404);
    }
  }


}