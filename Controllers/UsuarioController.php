<?php

namespace Controllers;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");


use \Core\Controller;
use Models\Endereco;
use \Models\Usuario;
use \Providers\Endereco as EnderecoProvider;

class UsuarioController extends Controller
{
    public function index()
    {
    }

    public function cadastrar()
    {
        $method = $this->getMethod();
        $requisicao = $this->getRequestData();
        if ($method != 'POST') return $this->returnJson(['mensagem' => 'Método inválido!'], 405);

        $usuarioModel = new Usuario();

        $usuarioExistente = $usuarioModel->verificaUsuarioExistente($requisicao);
        if ($usuarioExistente) return $this->returnJson(['mensagem' => 'Usuário já cadastrado!'], 400);

        $codUsuario = $usuarioModel->cadastrar($requisicao);
        if (!$codUsuario) return $this->returnJson(['mensagem' => 'Erro ao cadastrar requisitante!'], 500);

        if ($codUsuario) {
            $enderoProvider = new EnderecoProvider();
            $codEndereco = $enderoProvider->buscarOuCadastrarCodEndereco($requisicao);
        }


        // Depois de ter o código do endereço, tem que cadastrar na tabela requisitante_possui_endereco
        $endereco = new Endereco();
        $dados = [
            'codUsuario' => $codUsuario,
            'codEndereco' => $codEndereco,
            'endNumero' => $requisicao['endNumero'],
            'endComplemento' => $requisicao['endComplemento']
        ];

        if (!$endereco->cadastrarEnderecoUsuario($dados)) return $this->returnJson(['mensagem' => 'Erro ao cadastrar endereço!'], 500);

        $array['mensagem'] = 'Usuario cadastrado com sucesso!';
        return $this->returnJson($array, 201);
    }

    public function buscardadosUsuario()
    {
        $method = $this->getMethod();
        $requisicao = $this->getRequestData();
        if ($method != 'GET') return $this->returnJson(['mensagem' => 'Método inválido!'], 405);
        $usuarioModel = new Usuario();

        if (!isset($requisicao['idFirebase'])) {
            $array['payload'] = 'Dados inválidos! idFirebase não pode ser nulo!';
            return $this->returnJson($array, 500);
        }

        $requisitante = $usuarioModel->dadosUsuario($requisicao);


        if ($requisitante) {
            $array['mensagem'] = 'Dados do requisitante listados com sucesso!';
            $array['payload'] = $requisitante;
            return $this->returnJson($array, 200);
        }
        $array['payload'] = 'Usuario não encontrado!';
        return $this->returnJson($array, 404);
    }
}
