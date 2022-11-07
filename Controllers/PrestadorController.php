<?php

namespace Controllers;

use Core\Controller;
use Models\Endereco;
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
    $prestadores = $prestadorModel->informacoesPrestadores();
    $enderecoModel = new Endereco();
    $especialidadeModel = new Especialidade();
    $payload['payload']['prestadores'] = [];
    foreach ($prestadores as $prestador) {
      $prestadorDados = [
        'codPrestador' => $prestador['codPrestador'],
        'descricaoProfissional' => $prestador['descricaoProfissional'],
        'horarioAtendimentoInicio' => $prestador['horarioAtendimentoInicio'],
        'horarioAtendimentoFim' => $prestador['horarioAtendimentoFim'],
        'nome' => $prestador['nome'],
        'cpf' => $prestador['cpf'],
        'numTelefone' => $prestador['numTelefone'],
        'email' => $prestador['email'],
        'codUsuario' => $prestador['codUsuario'],
        'linkFoto' => $prestador['linkFoto'],
        'idFirebase' => $prestador['idFirebase'],
        'dataNascimento' => $prestador['dataNascimento'],
      ];
      $cidades = $enderecoModel->buscarTodasCidadesPorCodPrestador($prestador['codPrestador']);
      if($cidades) {
        $prestadorDados['cidadesAtendimento'] = $cidades;
      } else {
        $prestadorDados['cidadesAtendimento'] = [];
      }
      $especialidades = $especialidadeModel->buscarEspecialidadesPorCodPrestador($prestador['codPrestador']);
      if($especialidades) {
        $prestadorDados['especialidades'] = $especialidades;
      } else {
        $prestadorDados['especialidades'] = [];
      }
      $payload['payload']['prestadores'][] = $prestadorDados;
    }
    // $especialidade = new Especialidade();
    // $especialidades = $especialidade->buscarEspecialidadesPrestadpr();
    if($prestadores) {
      $payload['mensagem'] = 'Prestadores listados com sucesso!';
      $this->returnJson($payload, 200);
    } else {
      $this->returnJson(['mensagem' => 'Nenhum prestador encontrado!'], 404);
    }
  }


}