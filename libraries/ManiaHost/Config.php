<?php
/**
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */
namespace ManiaHost;

class Config extends \ManiaLib\Utils\Singleton
{
    public $hourlyCost;
    public $appName;
	public $adminLogins = array();
    public $transactionLogin;
    public $transactionPassword;
    public $transactionSecurityKey;
	public $maxPlayerPerServer ;
	public $background = 'http://files.maniaplanet.com/manialinks/background.jpg';
}

?>