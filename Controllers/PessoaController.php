<?php
namespace Controllers;

use \Core\Controller;
use \Models\Pessoa;

    class PessoaController extends Controller {
        public function index(){}

        public function nivelOcupacao(){

            $array = array('payload' => '');
            $method = $this->getMethod();
            $data = $this->getRequestData();

            $pessoa = new Pessoa();
            $array['payload']['pessoa'] = $pessoa->selecionar($data);
            $this->returnJson($array);
        }


    }
