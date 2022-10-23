
<?php
require 'environment.php';

global $config;
$config = array();

if(ENVIRONMENT == 'development') {

	$config['dbname'] = 'localhost';
	$config['host'] = 'ip';
	$config['dbuser'] = 'user';
	$config['dbpass'] = 'password';

	// $config['jwt_secret_key'] = "abC123!";

}

global $db;
try {

	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES utf8');

} catch(PDOException $e) {

	$array = array();

	header("HTTP/1.0 400");
	$array['codigo'] = '85';
  $array['mensagem'] = "Falha na requisicao no BD.";
	echo json_encode($array);

	//echo "ERRO: ".$e->getMessage();
	exit;
}
