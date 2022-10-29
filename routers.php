<?php
global $routes;
$routes = array();
// Url criada = Controller chamado/funcaoCriada
$routes['/cadastrar/requisitante'] = '/Usuario/cadastrar';
$routes['/listar/requisitante'] = '/Usuario/buscardadosUsuario';


$routes['/buscar-informacoes/prestador'] = '/Prestador/buscarInformacoesPrestador';

$routes['/buscar-todos/prestadores'] = '/Prestador/buscarTodosOsPrestadores';