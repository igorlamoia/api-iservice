<?php

namespace Core;

class Controller
{

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}


	public function getRequestData()
	{
		switch ($this->getMethod()) {
			case 'GET':
				return $_GET;
				break;

			case 'PUT':

				$data = json_decode(file_get_contents('php://input'), 1);
				if (is_null($data)) {
					$data = $_POST;
				}

				return (array) $data;
				break;

			case 'DELETE':
				parse_str(file_get_contents('php://input'), $data);
				return (array) $data;
				break;
			case 'POST':

				$data = json_decode(file_get_contents('php://input'), true);
				if (is_null($data)) {
					$data = $_POST;
				}

				return (array) $data;
				break;
		}
	}

	public static function isSetThanReturnToQuery($data, $key)
	{
		if (isset($data[$key])) {
			return $data[$key];
		}
		return null;
	}

	public function returnJson($array, $code = 200)
	{
		http_response_code($code);
		header('Content-Type: application/json');
		echo json_encode($array);
		exit;
	}
}
