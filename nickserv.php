<?php
/**
 * NickServ class for the NickServ auth. in many IRC networks
 *
 * PHP version 5
 *
 * @category  Authentication
 * @package   NickServ
 * @author    Rico Dittrich <ricod1996@gmail.com>
 * @copyright 2012 by the authors
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL License 3
 * @version   GIT: 
 * @link      https://github.com/Ditti4/FINOd
**/

class NickServ
{
    public $commands, $user, $mail, $pass, $bot;
    public static $instance = null;

    function __construct($user, $mail, $pass)
    {
        $this->commands = new commands;
        $this->bot = bot::getInstance("", "", "", "", "", "", "");
        $this->user = $user;
        $this->mail = $mail;
        $this->pass = $pass;
    }

    static function getInstance($user, $mail, $pass)
    {
        if (self::$instance == null) {
            self::$instance = new self($user, $mail, $pass);
        }
        return self::$instance;
    }

    function register()
    {
        $this->commands->privmsg(
            'NickServ', 'register ' . $this->pass . ' ' . $this->mail
        );
    }

    function login()
    {
        $this->commands->privmsg('NickServ', 'identify ' . $this->pass);
    }
}
