<?php

namespace Controllers;

use Core\Controller;
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