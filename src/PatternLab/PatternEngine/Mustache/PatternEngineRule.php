<?php

/*!
 * Mustache Pattern Engine Rule Class
 *
 * Copyright (c) 2014 Dave Olsen, http://dmolsen.com
 * Licensed under the MIT license
 *
 * If the test matches "mustache" it will return various instances of the Mustache pattern engine
 *
 */

namespace PatternLab\PatternEngine\Mustache;

use \PatternLab\Config;
use \PatternLab\Dispatcher;
use \PatternLab\PatternEngine\Mustache\PatternLoader;
use \PatternLab\PatternEngine\Mustache\Helper;
use \PatternLab\PatternEngine\Rule;

class PatternEngineRule extends Rule {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->engineProp = "mustache";
		
	}
	
	/**
	* Load a new Mustache instance that uses the Pattern Loader
	*
	* @return {Object}       an instance of the Mustache engine
	*/	
	public function getPatternLoader($options = array()) {
		
		Dispatcher::$instance->dispatch("mustacheRule.gatherHelpers");
		
		$mustacheOptions                   = array();
		$mustacheOptions["loader"]         = new PatternLoader(Config::$options["patternSourceDir"],array("patternPaths" => $options["patternPaths"]));
		$mustacheOptions["partials_loader"] = new PatternLoader(Config::$options["patternSourceDir"],array("patternPaths" => $options["patternPaths"]));
		$mustacheOptions["helpers"]        = Helper::get();
		
		return new \Mustache_Engine($mustacheOptions);
		
	}
	
	/**
	* Load a new Mustache instance that uses the File System Loader
	*
	* @return {Object}       an instance of the Mustache engine
	*/
	public function getFileSystemLoader($options = array()) {
		
		$mustacheOptions                   = array();
		$mustacheOptions["loader"]         = new \Mustache_Loader_FilesystemLoader($options["templatePath"]);
		$mustacheOptions["partials_loader"] = new \Mustache_Loader_FilesystemLoader($partialsDir);
		
		return new \Mustache_Engine($mustacheOptions);
		
	}
	
	/**
	* Load a new Mustache instance that is just a vanilla Mustache rendering engine
	*
	* @return {Object}       an instance of the Mustache engine
	*/
	public function getVanillaLoader($options = array()) {
		
		return new \Mustache_Engine;
		
	}
	
}
