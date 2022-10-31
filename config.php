
<?php
require 'environment.php';

global $config;
$config = array();

$config['dbname'] = 'iservice';
$config['host'] = 'localhost';
$config['dbuser'] = 'root';
$config['dbpass'] = '';
if(ENVIRONMENT == 'development') {

	$config['dbname'] = 'iservice';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';

	// $config['jwt_secret_key'] = "abC123!";

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

	//echo "ERRO: ".$e->getMessage();
	exit;
}
