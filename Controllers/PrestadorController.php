<?php

namespace Controllers;

use Core\Controller;
use Models\Especialidade;
use Models\Prestador;
use Providers\Endereco as EnderecoProvider;

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
    $prestadorCadastrado = $prestadorModel->buscarPrestadorPorCodUsuario($requisicao['codUsuario']);
    if($prestadorCadastrado) return $this->returnJson(['mensagem' => 'Prestador já cadastrado!'], 400);

    $codPrestador = $prestadorModel->cadastrarPrestador($requisicao);
    if(!$codPrestador) $this->returnJson(['mensagem' => 'Erro ao cadastrar prestador!'], 500);

    $especialidadeModel = new Especialidade();
    foreach($requisicao['especialidades'] as $especialidade) {
      $codEspecialidade = $especialidadeModel->buscarCodEspecialidade($especialidade);

      if(!$codEspecialidade) {
        $codEspecialidade = $especialidadeModel->cadastrar($especialidade);
        if(!$codEspecialidade) $this->returnJson(['mensagem' => 'Erro ao cadastrar especialidade!'], 500);
      }
      $EspecialidadeCadastrada = $especialidadeModel->buscarPrestadorEspecialidade($codPrestador, $codEspecialidade);
      if(!$EspecialidadeCadastrada) {
        $especialidadeModel->cadastrarPrestadorEspecialidade($codPrestador, $codEspecialidade);
      }
    }

    foreach ($requisicao['cidadesAtendimento'] as $cidade) {
      EnderecoProvider::buscarOuCadastrarCidade($codPrestador, $cidade);
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