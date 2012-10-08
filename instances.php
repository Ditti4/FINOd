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
	private $bot, $nickserv;

	function getBot()
	{
		if ($this->bot == NULL)
		{
			$this->bot = new bot(run::$host, run::$port, run::$user, run::$channel);
		}
		return $this->bot;
	}

	function getNickServ()
	{
		if ($this->nickserv == NULL)
		{
			$this->nickserv = new nickserv();
		}
		return $this->nickserv;
	}
}
