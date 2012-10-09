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
	public $commands, $user, $mail, $login, $pass, $bot;
	public static $instance = NULL;

	function __construct()
	{
		$this->login = FALSE;
		$this->commands = new commands;
		$this->bot = bot::getInstance("", "", "", "", "", "");
		$this->user = $this->bot->user;
		$this->mail = $this->bot->mail;
		$this->pass = $this->bot->pass;
	}

	static function getInstance()
	{
		if (self::$instance == NULL)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	function register()
	{
		if ($this->pass != "" and $this->mail != "")
		{
			$this->commands->privmsg('NickServ', 'register '.$this->pass.' '.$this->mail);
		}
	}

	function login()
	{
		if (!$this->login)
		{
			if ($this->pass != "")
			{
				$this->commands->privmsg('NickServ', 'identify '.$this->pass);
				if (strpos($this->bot->get(), 'Password accepted - you are now recognized.'))
				{
					$this->login = TRUE;
					$bot->log('info', 'Successfully identified with NickServ!');
				}
			}
		}
		elseif ($this->login)
		{
			$this->log('warning', 'Already logged in!');
		}
	}
}
