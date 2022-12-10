<?php

namespace Controllers;

use \Core\Controller;

class AtendimentoController extends Controller
{
  public function criarSolicitacao()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new \Models\Atendimento();
    $atendimentoModel->cadastrarSolicitacao($dados);
    $this->returnJson(['mensagem' => 'Solicitação Cadastrada com sucesso'], 200);
  }

  public function buscarDemandasPrestador()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new \Models\Atendimento();
    $prestadorModel = new \Models\Prestador();
    $dadosPrestador = $prestadorModel->buscarPrestadorPorCodUsuario($dados['codUsuario']);

    if (!$dadosPrestador) return $this->returnJson(['mensagem' => 'Prestador não encontrado'], 404);
    $demandas = $atendimentoModel->buscarDemandas($dadosPrestador);
   
    $this->returnJson(['payload' => $demandas, 'mensagem' => 'Demandas listadas com sucesso!'], 200);
  }
  public function buscarSolicitacoesUsuario()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new \Models\Atendimento();
    $solicitacoes = $atendimentoModel->buscarSolicitacoes($dados);
    
    $this->returnJson(['payload' => $solicitacoes, 'mensagem' => 'Solicitações listadas com sucesso!'], 200);
  }

}
