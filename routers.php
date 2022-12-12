<?php
global $routes;
$routes = array();
// Url criada = Controller chamado/funcaoCriada
$routes['/cadastrar/usuario'] = '/Usuario/cadastrar';
$routes['/listar/dados-usuario'] = '/Usuario/buscardadosUsuario';


$routes['/cadastrar/prestador'] = '/Prestador/cadastrarPrestador';
$routes['/listar/todos-prestadores'] = '/Prestador/buscarTodosOsPrestadores';
$routes['/filtros/listar-prestador'] = '/Prestador/filtrosPrestador';


$routes['/listar/servicos'] = '/Servico/listarServicos';
$routes['/listar/todas-categorias'] = '/Servico/listarTodasCategorias';
$routes['/listar/todas-profissoes'] = '/Servico/listarTodasProfissoes';
$routes['/listar/todas-especialidades'] = '/Servico/listarTodasEspecialidades';

// Exemplos didáticos pra galera:
$routes['/buscar-informacoes/prestador'] = '/Prestador/buscarInformacoesPrestador';

$routes['/buscar-todas-cidades/prestadores'] = '/Servico/buscarTodasCidadesPrestadores';


$routes['/cadastrar/solicitacao'] = '/Atendimento/criarSolicitacao';
$routes['/listar/demandas-prestador'] = '/Atendimento/buscarDemandasPrestador';
$routes['/listar/solicitacoes-usuario'] = '/Atendimento/buscarSolicitacoesUsuario';

$routes['/atualizar/status-atendimento'] = '/Atendimento/atualizarStatusAtendimento';

$routes['/notificacao/visualizar'] = '/Notificacao/Visualizar';
$routes['/notificacao/listar'] = '/Notificacao/buscarNotificacoes';

$routes['/avaliar/usuario'] = '/Atendimento/avaliarUsuario';
$routes['/avaliar/prestador'] = '/Atendimento/avaliarPrestador';
