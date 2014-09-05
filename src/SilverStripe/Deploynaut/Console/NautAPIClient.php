<?php

namespace SilverStripe\Deploynaut\Console;

use Curl\Curl;

class NautAPIClient {

	public static $default_config_file = "~/.naut";
	
	protected $auth = null;

	protected $baseURL = null;

	/**
	 * Construct a new clinert 
	 */
	function __construct($options) {

		// Process default config filename: "~" isn't recognised by PHP
		$configPath = self::$default_config_file;
		if(isset($_SERVER['HOME'])) {
			$configPath = preg_replace('#^~#', $_SERVER['HOME'], $configPath);
		} 

		// Get config data from config file, if applicable
		$configData = null;
		if($options['conf']) {
			if(!file_exists($options['conf'])) {	
				throw new \LogicException("Can't find configuration file '{$options['conf']}'");
			}
			$configData = parse_ini_file($options['conf']);
		
		// If a config file not specified, look for default one
		} else if(file_exists($configPath)) {
			$configData = parse_ini_file($configPath);
		}

		// If data given in a config file, use it: directly-passed options take precedence
		if($configData) {
			foreach($options as $k => $v) {
				if(!isset($configData[$k]) || $v) $configData[$k] = $v;
			}
			$options = $configData;
		}

		// Process "server" option
		if($options['server']) {
			$server = $options['server'];
			if(!preg_match('#^[a-z+]://#', $server)) $server = "http://$server";
			if(substr($server,-1) != '/') $server .= "/";
			$this->baseURL = $server . 'naut/api/';
		}

		// Process "auth" option
		if($options['auth']) {
			$this->auth = $options['auth'];
		}

		// Validate resulting config
		if(!$this->baseURL) throw new \LogicException("Please specify a server");
	}

	/**
	 * Return an appropriately configured CURL object
	 */
	protected function curl() {
		$curl = new Curl;
		if($this->auth) {
			list($username, $password) = explode(':', $this->auth, 2);
			$curl->setHeader('Accept', 'application/json');
			$curl->setBasicAuthentication($username, $password);
		}
		return $curl;
	}

	/**
	 * Get request to a JSON endpoint
	 */
	function getJSON($subURL) {
		$url = $this->baseURL . $subURL;

		$curl = $this->curl();
		$curl->get($url);
		if ($curl->error) {
			if($curl->error == '401') {
				throw new \LogicException("Can't log-in - please check your authentication credentials");


			} else {
				throw new \LogicException("HTTP error $curl->error_code accessing $url");
			}
		}

		return json_decode($curl->response, true);
	}

	/**
	 * Get request to a JSON endpoint
	 */
	function postJSON($subURL, $data) {
		$sendJSON = json_encode($data);
		$url = $this->baseURL . $subURL;

		$curl = $this->curl();

		// Post request with JOSN data
		$curl->setopt(CURLOPT_URL, $url);
		$curl->setopt(CURLOPT_CUSTOMREQUEST, "POST");
		$data = http_build_query($data);
		$curl->setopt(CURLOPT_POSTFIELDS, $sendJSON);
		$curl->setHeader("Content-type", "application/json");
		$curl->_exec();

		if ($curl->error) {
			if($curl->error == '401') {
				throw new \LogicException("Can't log-in - please check your authentication credentials");


			} else {
				throw new \LogicException("HTTP error $curl->error_code accessing $url");
			}
		}

		return json_decode($curl->response, true);
	}
	/** 
	 * Return a list of projects
	 */
	function projects() {
		$json = $this->getJSON("");

		$result = array();
		foreach($json['projects'] as $row) {
			$result[] = $row['name'];
		}
		return $result;
	}

	/** 
	 * Return a list of environments in a project
	 */
	function environments($project) {
		$json = $this->getJSON("$project");

		$result = array();
		foreach($json['environments'] as $row) {
			$result[] = $row['name'];
		}
		return $result;
	}

	/** 
	 * Deploy the given SHA to the given environment in the given project
	 */
	function deploy($project, $environment, $sha) {
		$json = $this->postJSON("$project/$environment/deploy", array(
			"release" => $sha,
		));

		$subURL = str_replace($this->baseURL,"",$json["href"]);

		return new NautAPIJob($this, $subURL);

		$result = array();
		foreach($json['environments'] as $row) {
			$result[] = $row['name'];
		}
		return $result;
	}

}