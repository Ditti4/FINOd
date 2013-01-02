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

require_once('bot.php');
require_once('commands.php');
require_once('messages.php');
require_once('nickserv.php');
require_once('usercommands.php');
date_default_timezone_set("Europe/Berlin");

class run
{
	public $bot;
	function __construct($host, $port, $user, $channel, $nickserv, $mail, $pass)
	{
		$this->bot = bot::getInstance($host, $port, $user, $channel, $nickserv, $mail, $pass);
	}

	function run()
	{
		while (true)
		{
			$this->bot->handler($this->bot->get());
		}
	}
}

if(file_exists("config.xml"))
{
	$config = simplexml_load_file("config.xml");
	$host = $config->host;
	$port = (int)$config->port;
	$user = $config->user;
	//$channel = array();
	//for($i = 0; $i<count($config->channels); $i++)
		$channel = $config->channels;
	$nickserv = $config->nickserv->enable;
	if($nickserv == 'y')
	{
		$pass = $config->nickserv->pass;
		$mail = $config->nickserv->mail;
	}
	else
	{
		$pass = '';
		$mail = '';
	}
}
else{
	echo 'Server: ';
	$host = cin();
	echo 'Port: ';
	$port = cin();
	echo 'User: ';
	$user = cin();
	echo 'Channel: ';
	$channel = cin();
	echo 'Use NickServ? (default: n) ';
	$nickserv = cin();
	if ($nickserv == 'y')
	{
		echo 'Already registered? (default: n) ';
		if (cin() != 'y')
		{
			echo 'Mail: ';
			$mail = cin();
		}
		else
		{
			$mail = "";
		}
		echo 'Password (be sure that nobody is behind you): ';
			$pass = cin();
	}
	else
	{
		$mail = "";
		$pass = "";
	}
}

$run = new run($host, $port, $user, $channel, $nickserv, $mail, $pass);
$run->run();

?>
