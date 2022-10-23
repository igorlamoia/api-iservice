<?php
namespace Controllers;

use \Core\Controller;

    class NotfoundController extends Controller {
        public function index(){
          $this->returnJson(['mensagem' => 'Endpoint não encontrado!'], 404);
        }
    }
