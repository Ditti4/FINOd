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

	function __construct($user, $mail, $pass)
	{
		$this->login = FALSE;
		$this->commands = new commands;
		$this->bot = bot::getInstance("", "", "", "", "", "", "");
		$this->user = $user;
		$this->mail = $mail;
		$this->pass = $pass;
	}

	static function getInstance($user, $mail, $pass)
	{
		if (self::$instance == NULL)
		{
			self::$instance = new self($user, $mail, $pass);
		}
		return self::$instance;
	}

	function register()
	{
		$this->commands->privmsg('NickServ', 'register '.$this->pass.' '.$this->mail);
	}

	function login()
	{
		if (!$this->login)
		{
			var_dump($this->pass);
			$this->commands->privmsg('NickServ', 'identify '.$this->pass);
			if (strpos($this->bot->get(), 'Password accepted - you are now recognized.'))
			{
				$this->login = TRUE;
				$this->bot->log('info', 'Successfully identified with NickServ!');
			}
		}
		elseif ($this->login)
		{
			$this->bot->log('warning', 'Already logged in!');
		}
	}
}
