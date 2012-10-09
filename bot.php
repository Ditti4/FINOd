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
	public $host, $port, $channel, $user, $mail, $pass, $socket, $commands, $nickserv;
	public static $instance = NULL;

	function __construct($host, $port, $user, $channel, $mail, $pass)
	{
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->channel = $channel;
		$this->mail = $mail;
		$this->pass = $pass;
		$this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 2);
		if ($this->socket)
		{
			$this->log('info', 'CONNECTED!');
			fwrite($this->socket, "PASS NOPASS\n\r");
			$this->log('send', "PASS NOPASS");
			fwrite($this->socket, "NICK $user\n\r");
			$this->log('send', "NICK $user");
			fwrite($this->socket, "USER $user * * :$user is a Bot using FINOd\n\r");
			$this->log('send', "USER $user * * :Bot using FINOd");
		}
		else
		{
			$this->log('error', "Couldn't connect to server. Please doublecheck everything.");
			die();
		}
	}

	static function getInstance($host, $port, $user, $channel, $mail, $pass)
	{
		if (self::$instance == NULL)
		{
			self::$instance = new self($host, $port, $user, $channel, $mail, $pass);
		}
		return self::$instance;
	}

	static function log($type, $msg)
	{
		echo "[".strtoupper($type)." ".date('H').":".date('i').":".date('s')."] $msg\n";
	}

	function get()
	{
		$input = (fgets($this->socket, 1024));
		if (trim($input) != "")
		{
			$this->log('get', $input);
			return $input;
		}
	}

	function handler($msg)
	{
		$this->commands = new commands();
		$messages = new messages($msg);
		if (substr($msg, 0, 4) == 'PING')
		{
			$this->commands->pong($msg);
		}
		elseif(strpos($msg, $this->user." :End of /MOTD command."))
		{
			$this->commands->join($this->channel);
			$this->commands->umode("+B");
		}
		elseif (strpos($msg, "NOTICE ".$this->user." :Your nick isn't registered") and strtolower($messages->getSender()) == 'nickserv')
		{
			$this->nickserv = nickserv::getInstance();
			$this->nickserv->register();
		}
		elseif (strpos($msg, 'NOTICE '.$this->user.' :This nickname is registered and protected. If it is your') and strtolower($messages->getSender()) == 'nickserv')
		{
			$this->nickserv = nickserv::getInstance();
			$this->nickserv->login();
		}
	}
}
?>
