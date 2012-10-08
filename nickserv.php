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
	public static $instance = NULL;
	private $pass;

	function __construct()
	{
		$this->login = FALSE;
		$this->bot = bot::getInstance("", "", "", "");
		$this->user = $this->bot->user;
		$this->mail = $this->bot->mail;
		$this->pass = $this->bot->pass;
	}

	static function getInstance()
	{
		if (self::$instance == NULL)
		{
			self::$instance = new self($host, $port, $user, $channel);
		}
		return self::$instance;
	}

	function register()
	{
		if ($this->pass != "" and $this->mail != "")
		{
			$this->bot->send('PRIVMSG NickServ register '.$this->pass.' '.$this->mail);
		}
	}

	function login()
	{
		if (!$this->login)
		{
			if ($this->pass != "")
			{
				$this->bot->send('PRIVMSG NickServ identify '.$this->pass);
				if (strpos($this->bot->get(), 'Password accepted - you are now recognized.'))
				{
					$this->login = TRUE;
					$bot->log('info', 'Identified with NickServ successfully!');
				}
			}
		}
		elseif ($this->login)
		{
			$this->log('warning', 'Already logged in!');
		}
	}
}
