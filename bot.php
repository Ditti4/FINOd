<?php
/*
## This file is part of FINOd.
##
## FINOd is free software: you can redistribute it and/or modify
## it under the terms of the GNU General Public License as published by
## the Free Software Foundation, either version 3 of the License, or
## (at your option) any later version.
##
## FINOd is distributed in the hope that it will be useful,
## but WITHOUT ANY WARRANTY; without even the implied warranty of
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
## GNU General Public License for more details.
##
## You should have received a copy of the GNU General Public License
## along with FINOd.
## If not, see <http://www.gnu.org/licenses/>.
*/

set_time_limit(0);
date_default_timezone_set("Europe/Berlin");

function cin()
{
	$fopen = fopen('php://stdin', 'r');
	$input = fgets($fopen, 1024);
	$input = trim($input);
	fclose($fopen);
	return $input;
}


class bot
{
	public $host, $port, $channel, $user, $mail, $pass, $socket, $commands;
	public static $instance = NULL;

	function __construct($host, $port, $user, $channel)
	{
		$this->host = $host;
		$this->port = $port;
		$this->channel = $channel;
		$this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 2);
		if ($this->socket)
		{
			self::log('info', 'CONNECTED!');
			fwrite($this->socket, "PASS NOPASS\n\r");
			self::log('send', "PASS NOPASS");
			fwrite($this->socket, "NICK $user\n\r");
			self::log('send', "NICK $user");
			fwrite($this->socket, "USER $user * * :Bot using FINOd\n\r");
			self::log('send', "USER $user * * :Bot using FINOd");
		}
		else
		{
			self::log('error', "Couldn't connect to server. Please doublecheck everything.");
			die();
		}
	}
	
	static function getInstance($host, $port, $user, $channel)
	{
		if (self::$instance == NULL)
		{
			self::$instance = new self($host, $port, $user, $channel);
		}
		return self::$instance;
	}

	static function log($type, $msg)
	{
		echo "[".strtoupper($type)." ".date('H').":".date('i').":".date('s')."] $msg\n";
	}

	function getUser()
	{
		return $this->user;
	}

	function getHost()
	{
		return $this->host;
	}

	function get()
	{
		$input = trim(fgets($this->socket, 1024));
		if (!empty($input))
		{
			$this->log('get', $input);
			return $input;
		}
	}

	function handler($msg)
	{
		$this->commands = new commands();
		if (substr(1, 4, $msg) == 'PING')
		{
			$this->commands->pong($msg);
		}
		elseif(strpos($msg, $server['USER']." :End of /MOTD command."))
		{
			$this->commands->join($this->channel);
			$this->commands->umode("+B");
		}
	}
}
?>
