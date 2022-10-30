<?php
global $routes;
$routes = array();
// Url criada = Controller chamado/funcaoCriada
$routes['/cadastrar/usuario'] = '/Usuario/cadastrar';
$routes['/listar/dados-usuario'] = '/Usuario/buscardadosUsuario';


$routes['/cadastrar/prestador'] = '/Prestador/cadastrarPrestador';
$routes['/listar/servicos'] = '/Servico/listarServicos';

// Exemplos didáticos pra galera:
$routes['/buscar-informacoes/prestador'] = '/Prestador/buscarInformacoesPrestador';
$routes['/buscar-todos/prestadores'] = '/Prestador/buscarTodosOsPrestadores';