<?php

namespace Controllers;

use \Core\Controller;
use Models\Atendimento;
use Models\Nota;
use Models\Notificacao;
use Models\Prestador;

class AtendimentoController extends Controller
{
  public function criarSolicitacao()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new Atendimento();
    $atendimentoModel->cadastrarSolicitacao($dados);
    $this->returnJson(['mensagem' => 'Solicitação Cadastrada com sucesso'], 200);
  }

  public function buscarDemandasPrestador()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new Atendimento();
    $prestadorModel = new Prestador();
    $dadosPrestador = $prestadorModel->buscarPrestadorPorCodUsuario($dados['codUsuario']);

    if (!$dadosPrestador) return $this->returnJson(['mensagem' => 'Prestador não encontrado'], 404);
    $demandas = $atendimentoModel->buscarDemandas($dadosPrestador);

    $notaModel = new Nota();

    $demandasDTO = [];
    foreach ($demandas as $demanda) {
      $avaliacao = $notaModel->usuarioAvaliadoPorCodAtendimento($demanda['codAtendimento']);
      if($avaliacao) $demanda['avaliado'] = true;
      else $demanda['avaliado'] = false;
      
      $demandasDTO[] = $demanda;
    }

    $this->returnJson(['payload' => $demandasDTO, 'mensagem' => 'Demandas listadas com sucesso!'], 200);
  }

  public function buscarSolicitacoesUsuario()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new Atendimento();
    $solicitacoes = $atendimentoModel->buscarSolicitacoes($dados);

    $notaModel = new Nota();

    $solicitacoesDTO = [];
    foreach ($solicitacoes as $solicitacao) {
      $avaliacao = $notaModel->prestadorAvaliadoPorCodAtendimento($solicitacao['codAtendimento']);
      if($avaliacao) $solicitacao['avaliado'] = true;
      else $solicitacao['avaliado'] = false;
      
      $solicitacoesDTO[] = $solicitacao;
    }

    $this->returnJson(['payload' => $solicitacoesDTO, 'mensagem' => 'Solicitações listadas com sucesso!'], 200);
  }


  public function atualizarStatusAtendimento()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new Atendimento();

    $solicitacoes = $atendimentoModel->atualizarAtendimento($dados);

    $notificacaoModel = new Notificacao();
    $codAtendimento = $dados['codAtendimento'];

    $mensagem = '';

    switch ($dados['codStatus']) {
      case '2':
        $mensagem = 'foi aceita pelo prestador!';
        break;
      case '3':
        $mensagem = 'foi recusada pelo prestador!';
        break;
      case '4':
        $mensagem = 'foi cancelada pelo prestador!';
        break;
      case '5':
        $mensagem = 'foi cancelada pelo requisitante!';
        break;
      case '6':
        $mensagem = 'foi finalizada pelo prestador!';
        break;
    }

    $notificacao = [
      'texto' => 'Solicitação de código ' . $codAtendimento . ' ' . $mensagem,
      'codAtendimento' => $codAtendimento
    ];
    $notificacaoModel->criarNotificacao($notificacao);

    $this->returnJson(['mensagem' => 'Atendimento atualizado com sucesso!']);
  }

  public function avaliarUsuario()
  {
    $dados = $this->getRequestData();
    $notaModel = new Nota();

    if ($notaModel->buscarNotaAtendimentoUsuario($dados)) {
      $this->returnJson(['mensagem' => 'Você já avaliou este usuário neste atendimento'], 400);
    }

    $idNota = $notaModel->criarNota($dados);

    $notaModel->adicionarNotaUsuario([
      'codNota' => $idNota,
      'codUsuario' => $dados['codUsuario']
    ]);

    $notaModel->adicionarAvaliacaoUsuario($dados);

    $this->returnJson(['mensagem' => 'Avaliação realizada com sucesso!']);
  }

  public function avaliarPrestador()
  {
    $dados = $this->getRequestData();
    $notaModel = new Nota();

    if ($notaModel->buscarNotaAtendimentoPrestador($dados)) {
      $this->returnJson(['mensagem' => 'Você já avaliou este prestador neste atendimento'], 400);
    }

    $idNota = $notaModel->criarNota($dados);

    $notaModel->adicionarNotaPrestador([
      'codNota' => $idNota,
      'codPrestador' => $dados['codPrestador']
    ]);

    $notaModel->adicionarAvaliacaoPrestador($dados);

    $this->returnJson(['mensagem' => 'Avaliação realizada com sucesso!']);
  }
}
