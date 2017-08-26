<?php

class BlackSession{
	//function BlackSession($app = '', $id = '', $path = '') {    //  PHP 5.*
	function __construct($app = '', $id = '', $path = '') {     // PHP 7.*
		$this->session = array();
		$this->app = $app;
		$this->id = $id;
		$this->path = $path;
		
		if(!file_exists($this->path.$this->app.'_'.$this->id)) return false;
		$array = file($this->path.$this->app.'_'.$this->id);
		for($i = 0; $i < count($array); $i += 2) {
			if(isset($array[$i+1])) {
				$key = str_replace("\n", '', $array[$i]);
				$value = str_replace("\n", '', $array[$i+1]);
				$this->session[$key] = $value;
			}
		}
	}
	function Set($key, $value) {
		$key = str_replace("\n", '', $key);
		$value = str_replace("\n", '', $value);
		$this->session[$key] = $value;
	}
	function Apply() {
		if($fp = fopen($this->path.$this->app.'_'.$this->id, 'w')) {
			foreach($this->session as $key=>$value) fwrite($fp, str_replace("\n", '', $key)."\n".str_replace("\n", '', $value)."\n");
			fclose($fp);
		}
	}
	function Get($key) {
		$key = str_replace("\n", '', $key);
		if(isset($this->session[$key])) return $this->session[$key];
	}
}

?>
