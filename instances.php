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

class instances
{
	private $bot, $nickserv, $socket;

	function getBot($host, $port, $user, $channel)
	{
		if (!is_object($this->bot))
		{
			$this->bot = new bot($host, $port, $user, $channel);
		}
		return $this->bot;
	}

	function getSocket()
	{
		if (!is_object($this->socket))
		{
			$this->socket = $this->getBot()->socket;
		}
		return $this->socket;
	}

	function getNickServ()
	{
		if (!is_object($this->nickserv))
		{
			$this->nickserv = new nickserv();
		}
		return $this->nickserv;
	}
}
