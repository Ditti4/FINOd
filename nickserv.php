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

class NickServ
{
	public $bot, $user, $mail, $login;
	private $pass;

	class __construct($server, $nickserv)
	{
		$this->login = FALSE;
		$this->bot = instances::getBot();
		$this->user = $server['USER'];
		$this->mail = $nickserv['MAIL'];
		$this->pass = $nickserv['PASS'];
	}

	class register()
	{
		$this->bot->send("PRIVMSG NickServ register $this->pass $this->mail");
	}

	class login()
	{
		if (!$this->login)
		{
			$this->bot->send("PRIVMSG NickServ identify $this->pass");
			if (strpos($this->bot->get(), 'Password accepted - you are now recognized.'))
			{
				$this->login = TRUE;
				$bot->log('info', 'Identified with NickServ successfully!');
			}
		}
		elseif ($this->login)
		{
			$this->log('warning', 'Already logged in!');
		}
	}
}
