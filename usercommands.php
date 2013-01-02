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
	public $ucommands, $messsages, $commands, $bot;
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
			if(strtoupper($this->messages->getCommand()) == strtoupper($this->ucommands->item[$i]->command))
			{
				if(isset($this->ucommands->item[$i]->perm))
				{
					if($this->ucommands->item[$i]->perm == $this->messages->getSender())
					{
						$this->commands->send($this->replace($this->ucommands->item[$i]->trigger));
					}
				}
				else
				{
					 $this->commands->send($this->replace($this->ucommands->item[$i]->trigger));
				}
				break;
			}
		}
}

	function replace($msg)
	{
		$msg = str_replace('{$sender}', trim($this->messages->getSender()), $msg);
		$msg = str_replace('{$args}', trim($this->messages->getArgs()), $msg);
		$msg = str_replace('{$cmd}', trim($this->messages->getCommand()), $msg);
		$msg = str_replace('{$channel}', trim($this->messages->getChannel()), $msg);
		$msg = str_replace('{$time}', trim($this->messages->getTime()), $msg);
		
		//$msg = preg_replace('/\{\$arg(\d{1,})\}/', trim($this->messages->getArg('$2')), $msg);
		//$msg = preg_replace('/\{\$arg(\d{1,})\}/', '$2', $msg);
		preg_match_all('/\{\$arg(\d{1,})\}/', $msg, $matches);
		if(!empty($matches))
		{
			foreach($matches[1] as $arg)
			{
				$msg = str_replace('{$arg'.$arg.'}', trim($this->messages->getArg($arg)), $msg);
			}
		}
		
		$msg = str_replace('{$soh}', chr(01), $msg);
		return $msg;
	}
}
?>
