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
	public $message, $sender, $channel, $time, $spaceexploded, $colonexploded, $command;

	function __construct($message)
	{
		$this->message = $message;
		$this->spaceexploded = explode(' ', $message);
		$this->colonexploded = explode(':', $message);
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

}
