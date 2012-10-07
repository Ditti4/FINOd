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

set_time_limit(0);
date_default_timezone_set("Europe/Berlin");

function cin()
{
	$fopen = fopen('php://stdin', 'r');
	$input = fgets($fopen, 1024);
	$input = trim($input);
	fclose($fopen);
	return $input;
}


class bot
{
	public $host, $port, $channel, $user, $mail, $pass, $socket, $instances, $commands;

	function __construct($host, $port, $user, $channel)
	{
		$this->host = $host;
		$this->port = $port;
		$this->channel = $channel;
		$this->socket = fsockopen($this->host, $this->port, $errno, $errstr, 2);
		if ($this->socket)
		{
			self::log('info', 'CONNECTED!');
			fwrite($this->socket, "PASS NOPASS\n\r");
			self::log('send', "PASS NOPASS");
			fwrite($this->socket, "NICK $user\n\r");
			self::log('send', "NICK $user");
			fwrite($this->socket, "USER $user * * :Bot using FINOd\n\r");
			self::log('send', "USER $user * * :Bot using FINOd");
		}
		else
		{
			self::log('error', "Couldn't connect to server. Please doublecheck everything.")
		}
	}

	static function log($type, $msg)
	{
		strtoupper($type);
		echo "[$type ".date('H').":".date('i').":".date('s')."] $msg\n";
	}

	function getUser()
	{
		return $this->user;
	}

	function getHost()
	{
		return $this->host;
	}

	function get()
	{
		$input = trim(fgets($this->socket, 1024));
		if (!empty($input))
		{
			$this->log('get', $input);
			return $input;
		}
	}

	function handler($msg)
	{
		$this->instances = new instances();
		$this->commands = new commands();
		if (substr(1, 4, $msg) == 'PING')
		{
			$this->commands->pong($msg);
		}
		elseif(strpos($msg, $server['USER']." :End of /MOTD command."))
		{
			$this->commands->join($this->channel);
			$this->commands->umode("+B");
		}
	}
}

function no($sender)
{
	sendCmd("PRIVMSG $sender http://i3.kym-cdn.com/entries/icons/original/000/007/423/untitle.JPG");
}

function commandHandler($input)
{
	global $server;
	$input = trim($input);
	if (substr($input, 0, 4) == 'PING')
	{
		$cmd = str_replace('PING', 'PONG', $input)." :FINOd@riditt.de";
		sendCmd($cmd);
	}
	elseif (strpos($input, $server['USER']." :End of /MOTD command."))
	{
		sendCmd("JOIN ".$server['CHANNEL']);
		sendCmd("MODE ".$server['USER']." +B");
	}
	elseif (strpos($input, "PRIVMSG ".$server['USER']." :") and getSender($input) != "SpamScanner")
	{
		$sender = getSender($input);
		$msg = substr($input, strpos($input, "PRIVMSG ".$server['USER']." :"), strlen($input));
		$cmd = substr($msg, (strpos($msg, ':')+1), strlen($msg));
		$param = explode(' ', $cmd);
		switch ($param[0])
		{
			case 'stop':
				if ($sender == $server['ADMIN'])
				{
					sendCmd("PRIVMSG ".$server['CHANNEL']." :$sender told me to quit. Bye!");
					die("[QUIT ".date(H).":".date(i).":".date(s)."] $sender told me to quit!\n");
				}
				else
				{
					no($sender);
				}
				break;
		}
	}
	elseif (strpos($input, "PRIVMSG ".$server['CHANNEL']." :!"))
	{
		$msg = substr($input, strpos($input, "PRIVMSG ".$server['CHANNEL']." :!"), strlen($input));
		$cmd = substr($msg, (strpos($msg, ':!')+2), strlen($msg));
		$param = explode(' ', $cmd);
		switch ($param[0])
		{
			case 'wiki':
				$query = "";
				for ($i = 1; $i <= (count($param)-1); $i++)
				{
					$query .= $param[$i];
					if ($i < (count($param)-1))
					{
						$query .= '_';
					}
				}
				sendCmd("PRIVMSG ".$server['CHANNEL']." :http://de.wikipedia.org/wiki/$query");
				break;
			case 'google':
				$query = "";
				for ($i = 1; $i <= (count($param)-1); $i++)
				{
					$query .= $param[$i];
					if ($i < (count($param)-1))
					{
						$query .= '+';
					}
				}
				sendCmd("PRIVMSG ".$server['CHANNEL']." :http://google.com?q=$query");
				break;
		}
	}
}

$server = array();
$nickserv = array();

echo 'Enter server: ';
$server['HOST'] = cin();
echo 'Enter the server port: ';
$server['PORT'] = cin();
echo 'Enter the username for the bot: ';
$server['USER'] = cin();
echo 'Now I need your nickname (for sending admin commands to the bot): ';
$server['ADMIN'] = cin();
echo 'And now enter the channel: ';
$server['CHANNEL'] = cin();

echo 'What\'s your timezone? (default: Europe/Berlin) ';
$timzone = cin();
if (!empty($timezone))
{
date_default_timezone_set($timezone);
}

echo 'Do you want '.$server['USER'].' to register and identify on startup? (default: n) ';
if (cin() == 'y')
{
	echo 'Is your bot already registered? (default: n) ';
	if (cin() == 'y')
	{
		echo 'Okay, then please give me the login password: ';
		$nickserv['PASS'] = cin();
	}
	else
	{
		echo 'Okay, I\'ll try to do it. BUT I\'ll need a password for the registration: ';
		$nickserv['PASS'] = cin();
		echo 'And you really need to trust me that I will not use the mail address (which you\'ll enter now) to send spam! ';
		$nickserv['MAIL'] = cin();
	}
}


echo "[INFO ".date(H).":".date(i).":".date(s)."] Okay, got all information needed. Will hand them over to ".$server['USER']."...\n\n";

$server['SOCKET'] = @fsockopen($server['HOST'], $server['PORT'], $errno, $errstr, 2);

if ($server['SOCKET'])
{
	echo "[INFO ".date(H).":".date(i).":".date(s)."] CONNECTED!\n\n";
	sendCmd("PASS NOPASS");
	sendCmd("NICK ".$server['USER']);
	sendCmd("USER ".$server['USER']." * * :Bot using FINOd");
	while (true)
	{
		commandHandler(getMsg());
	}
}
else
{
	echo "[ERROR ".date(H).":".date(i).":".date(s)."] Error while connecting to the server. Please doublecheck your input.\n";
}
?>
