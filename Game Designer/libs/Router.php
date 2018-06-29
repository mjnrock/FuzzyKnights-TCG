<?php
	require_once "{$_SERVER["DOCUMENT_ROOT"]}/libs/Request.php";

	abstract class Router {
		public static $Server;

		public static function SetServer($server) {
			Router::$Server = $server;
		}

		public static function GetVerb() {
			return Router::$Server["REQUEST_METHOD"];
		}

		public static function GetPath() {
			return explode("/", substr(Router::$Server["PATH_INFO"], 1));	// Removes the preceding "/" via substr()
		}

		public static function GetQuery() {
			$temps = explode("&", Router::$Server["QUERY_STRING"]);
			$queries = [];
			foreach($temps as $temp) {
				$t = explode("=", $temp);
				$queries[$t[0]] = $t[1];
			}

			return $queries;
		}

		public static function CheckRoute($request, $route) {
			if($route[0] === "/") {
				$route = substr($route, 1);
			}
			$route = explode("/", $route);

			foreach($route as $i => $r) {
				echo "<p>{$r} | {$request->Path}</p>";
				if(substr($r, 0, 1) === ":") {
					
				} else {
					if($request->Path[$i] !== $r) {
						return false;
					}
				}
			}

			return true;
		}

		public static function Route($verbs, $route, $fn) {
			// if(in_array(Router::GetVerb(), explode("|", strtoupper($verbs)))) {
			// 	if(TRUE) {
			// 	// if($route) {
			// 		$fn();
			// 	}
			// }

			$Request = new Request(Router::GetVerb(), Router::GetPath(), Router::GetQuery());
			print_r($Request);
			if(Router::CheckRoute($Request, $route)) {
				$fn();
			}
		}

		public static function Get($route, $fn) {
			Router::Route("GET", $route, $fn);
		}
		public static function QuickGet($route, $URI) {
			Router::Route("GET", $route, (function() use ($URI) {
				require_once "{$_SERVER["DOCUMENT_ROOT"]}/router/{$URI}.php";
			}));
		}

		public static function SimpleRoute($paths, $invoke) {
			$Route = new Route(Router::GetVerb(), Router::GetPath(), Router::GetQuery());
			
			$queries = [];

			if($paths[0] === "/") {
				$paths = substr($paths, 1);
			}
			$paths = explode("/", $paths);

			if(sizeof($path) !== sizeof($GetPath)) {
				return false;
			}
			
			foreach($paths as $i => $path) {
				if(substr($path, 0, 1) === ":") {
					// Query Variable
					$queries[substr($path, 1)] = $GetPath[$i];
				}
			}

			echo "<pre>";
			print_r($route);
			echo "<br />";
			print_r(Router::GetVerb());
			echo "<br />";
			print_r(Router::GetPath());
			echo "<br />";
			print_r(Router::GetQuery());
			echo "</pre>";
		}
	}
?>