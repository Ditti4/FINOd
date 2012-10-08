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

class commands
{
	public static $bot, $socket;

	function __construct()
	{
		self::$bot = bot::getInstance("", "", "", "");
		self::$socket = self::$bot->socket;
	}

	function send($command)
	{
		fwrite(self::$socket, $command."\n\r");
	}

	function pong($ping)
	{
		$this->send(trim(str_replace('PING', 'PONG', $ping)).' FINOd (https://github.com/Ditti4/FINOd)');
	}

	function privmsg($channel, $msg)
	{
		$this->send("PRIVMSG $channel :$msg");
		$this->bot->log('msg', '->'.$channel.': '.$msg);
	}

	function join($channel)
	{
		$this->send("JOIN $channel");
		$this->bot->log('join', '>>> '.$channel);
	}

	function umode($mode)
	{
		$this->send('MODE '.$this->bot->getUser().' '.$mode);
		$this->bot->log('mode', $this->bot->getUser().' -> '.$mode);
	}
}
