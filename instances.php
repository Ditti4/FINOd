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

	static function getBot()
	{
		if (!is_object(self::$bot))
		{
			self::$bot = new bot();
		}
		return self::$bot;
	}

	static function getSocket()
	{
		if (!is_object(self::$socket))
		{
			self::$socket = self::getBot()->$socket;
		}
		return self::$socket;
	}

	static function getNickServ($server, $nickserv)
	{
		if (!is_object(self::$nickserv))
		{
			self::$nickserv = new nickserv($server, $nickserv);
		}
		return self::$nickserv;
	}
}
