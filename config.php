
<?php
require 'environment.php';

global $config;
$config = array();

if(ENVIRONMENT == 'development') {
	$config['dbname'] = 'iservice';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
}

if(ENVIRONMENT == 'production') {
	$config['dbname'] = 'proje500_engcomp_servicos20221';
	$config['host'] = '108.179.253.195';
	$config['dbuser'] = 'proje500_fsiquei';
	$config['dbpass'] = 'P}uixQ1,VLco';
}

global $db;
try {

	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->exec('SET NAMES utf8');

} catch(PDOException $e) {
	$array = array();
  $array['mensagem'] = "Falha na requisicao no BD.";
	http_response_code(400);
	echo json_encode($array);
	exit;
}
