<?php

namespace Controllers;

use \Core\Controller;
use Models\Endereco;
use \Models\Requisitante;
use \Providers\Endereco as EnderecoProvider;

class RequisitanteController extends Controller
{
    public function index()
    {
    }

    public function cadastrar()
    {
        $method = $this->getMethod();
        $data = $this->getRequestData();
        if ($method != 'POST') return $this->returnJson(['mensagem' => 'Método inválido!'], 405);
        $requisitanteModel = new Requisitante();


        $codRequisitante = $requisitanteModel->cadastrar($data);
        // var_dump($codRequisitante);
        if (!$codRequisitante) return $this->returnJson(['mensagem' => 'Erro ao cadastrar requisitante!'], 500);

        $codEndereco = EnderecoProvider::buscarOuCadastrarCodEndereco($data);
        // Depois de ter o código do endereço, tem que cadastrar na tabela requisitante_possui_endereco
        $endereco = new Endereco();
        $dados = [
            'codEnd' => $codEndereco,
            'codReq' => $codRequisitante
        ];

        if(!$endereco->cadastrarEnderecoRequisitante($dados)) return $this->returnJson(['mensagem' => 'Erro ao cadastrar endereço!'], 500);

        $array['payload'] = 'Requisitante cadastrado com sucesso!';
        return $this->returnJson($array, 201);
    }

    public function buscarDadosRequisitante()
    {
        $method = $this->getMethod();
        $data = $this->getRequestData();
        if ($method != 'GET') return $this->returnJson(['mensagem' => 'Método inválido!'], 405);
        $requisitanteModel = new Requisitante();

        if (!isset($data['idFirebase'])) {
            $array['payload'] = 'Dados inválidos! idFirebase não pode ser nulo!';
            return $this->returnJson($array, 500);
        }

        $requisitante = $requisitanteModel->dadosRequisitante($data);


        if ($requisitante) {
            $array['mensagem'] = 'Dados do requisitante listados com sucesso!';
            $array['payload'] = $requisitante;
            return $this->returnJson($array, 200);
        }
        $array['payload'] = 'Requisitante não encontrado!';
        return $this->returnJson($array, 404);
    }
}
