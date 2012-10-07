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

require_once(instances.php);
require_once(bot.php);
require_once(commands.php);
require_once(mesages.php);
require_once(nickserv.php);

class run
{
	public $instances, $bot;

	function __construct()
	{
		self::$instances = new instances();
		self::$bot = self::$instances->getBot();
	}

	function run()
	{
		while (true)
		{
			$this->bot->handler($this->bot->get);
		}
	}
}
