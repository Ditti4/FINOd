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

class usercommands
{
	public $ucommands, $messsages, $commands;
	function __construct()
	{
		$file = "commands.xml";
		$this->ucommands = simplexml_load_file($file);
	}

	function handler($msg)
	{
		$this->messages = new messages($msg);
		$this->commands = new commands;
		for($i = 0; $i<count($this->ucommands); $i++)
		{
            if($this->messages->getCommand() == $this->ucommands->item[$i]->command)
            {
                $this->commands->send($this->replace($this->ucommands->item[$i]->trigger));
				break;
            }
		}
	}
	
	function replace($msg)
	{
		$msg = str_replace('{$sender}', $this->messages->getSender(), $msg);
		$msg = str_replace('{$args}', $this->messages->getArgs(), $msg);
		return $msg;
	}
}
?>
