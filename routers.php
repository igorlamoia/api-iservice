<?php
global $routes;
$routes = array();
// Url criada = Controller chamado/funcaoCriada
$routes['/cadastrar/usuario'] = '/Usuario/cadastrar';
$routes['/listar/dados-usuario'] = '/Usuario/buscardadosUsuario';


$routes['/cadastrar/prestador'] = '/Prestador/cadastrarPrestador';
$routes['/listar/todos-prestadores'] = '/Prestador/buscarTodosOsPrestadores';


$routes['/listar/servicos'] = '/Servico/listarServicos';
$routes['/listar/todas-categorias'] = '/Servico/listarTodasCategorias';
$routes['/listar/todas-profissoes'] = '/Servico/listarTodasProfissoes';
$routes['/listar/todas-especialidades'] = '/Servico/listarTodasEspecialidades';

// Exemplos didáticos pra galera:
$routes['/buscar-informacoes/prestador'] = '/Prestador/buscarInformacoesPrestador';