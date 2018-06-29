<?php
	class Request {
		public $URI;
		public $Verb;
		public $Path;
		public $Queries;

		function __constructor($verb, $path, $queries) {
			print_r($verb);
			$this->URI = $uri;
			$this->Verb = $verb;
			$this->Path = $path;
			$this->Queries = $queries;
		}

		function GetResult() {
			return [
				"Path" => $this->Path,
				"Queries" => $this->queries
			];
		}
	}
?>