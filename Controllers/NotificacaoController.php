<?php

namespace Controllers;

use \Core\Controller;
use Models\Notificacao;

class NotificacaoController extends Controller
{
  public function Visualizar()
  {
    $dados = $this->getRequestData();
    $notificacaoModel = new Notificacao();
    $notificacaoModel->visualizarNotificacao($dados);
    $this->returnJson(['mensagem' => 'Notificação visualizada com sucesso!']);
  }

  public function buscarNotificacoes()
  {
    $dados = $this->getRequestData();
    $atendimentoModel = new Notificacao();
    $solicitacoes = $atendimentoModel->buscarNotificacoes($dados);

    $this->returnJson(['payload' => $solicitacoes, 'mensagem' => 'Solicitações listadas com sucesso!'], 200);
  }

}
