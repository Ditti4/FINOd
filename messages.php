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

class messages
{
	public $message, $sender, $channel, $time, $spaceexploded, $colonexploded, $exexploded, $command;

	function __construct($message)
	{
		$this->message = $message;
		$this->spaceexploded = explode(' ', $message);
		$this->colonexploded = @explode(':', $message);
		$this->exexploded = @explode('!', $message);
		$this->argexploded = @explode(' ', $this->exexploded[2]);
		
		$this->time = date('H').':'.date('i').':'.date('s');
	}

	function getSender()
	{
		if (empty($this->sender))
		{
			$this->sender = substr($this->message, 1, (strpos($this->message, '!')-1));
		}
		return $this->sender;
	}

	function getChannel()
	{
		if (empty($this->channel))
		{
			$this->channel = $this->spaceexploded[2];
		}
		return $this->channel;
	}

	function getTime()
	{
		return $this->time;
	}
	
	function getCommandPrefix()
	{
		return substr($this->colonexploded[2], 0, 1);
	}
	
	function getCommand()
	{
		return $this->argexploded[0];
	}
	
	function getArg($arg)
	{
		return $this->argexploded[$arg];
	}
	
	function getArgs()
	{
		$return = '';
		for($i = 1; $i<sizeof($this->argexploded); $i++)
		{
			$return .= $this->argexploded[$i].' ';
		}
		return $return;
	}
	
	function getType()
	{
		return $this->spaceexploded[1];
	}

}
