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

require_once('instances.php');
require_once('bot.php');
require_once('commands.php');
require_once('messages.php');
require_once('nickserv.php');
date_default_timezone_set("Europe/Berlin");

class run
{
	public $instances, $bot;

	function __construct($host, $port, $user, $channel)
	{
		self::$instances = new instances;
		self::$bot = self::$instances->getBot($host, $port, $user, $channel);
	}

	function run()
	{
		while (true)
		{
			$this->bot->handler($this->bot->get);
		}
	}
}

echo 'Server: ';
$host = cin();
echo 'Port: ';
$port = cin();
echo 'User: ';
$user = cin();
echo 'Channel: ';
$channel = cin();

$run = new run($host, $port, $user, $channel);
