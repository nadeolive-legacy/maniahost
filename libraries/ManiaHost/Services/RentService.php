<?php
/**
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaHost\Services;

class RentService extends AbstractService
{

	/**
	 * @param string $login
	 * @param int $offset
	 * @param int $length
	 * @return Rent[]
	 * @throws \InvalidArgumentException
	 */
	function getCurrents($login, $offset = null, $length = null)
	{
		if(!preg_match('/^[a-zA-Z0-9-_\.]{1,25}$/', $login))
		{
			throw new \InvalidArgumentException();
		}

		$quotedLogin = $this->db()->quote($login);
		$result = $this->db()->execute('SELECT R.*, S.login FROM Rents R '.
				'LEFT JOIN Servers S ON R.id = S.idRent '.
				'WHERE playerLogin = %s '.
				'AND rentDate < NOW() '.
				'AND DATE_ADD(rentDate, INTERVAL duration HOUR) > NOW() '.
				'ORDER BY DATE_ADD(rentDate, INTERVAL duration HOUR) DESC %s', $quotedLogin,
				\ManiaLib\Database\Tools::getLimitString($offset, $length));

		return Rent::arrayFromRecordSet($result);
	}

	/**
	 * @param int $id
	 * @return Rent
	 */
	function get($id)
	{
		$result = $this->db()->execute(
				'SELECT R.*, S.login FROM Rents R '.
				'LEFT JOIN Servers S ON R.id = S.idRent '.
				'WHERE R.id = %d', $id
		);
		return Rent::fromRecordSet($result);
	}

	function register(Rent $rent)
	{
		if(!(int) $rent->duration)
		{
			throw new \InvalidArgumentException();
		}

		if(!preg_match('/^[a-z0-9-_\.]{1,25}$/iu', $rent->playerLogin))
		{
			throw new \InvalidArgumentException();
		}

		if(!is_array($rent->serverOptions))
		{
			throw new \InvalidArgumentException();
		}

		if(!($rent->gameInfos instanceof \ManiaLive\DedicatedApi\Structures\GameInfos))
		{
			throw new \InvalidArgumentException();
		}

		if(!is_array($rent->maps) || !count($rent->maps))
		{
			throw new \InvalidArgumentException();
		}

		$quotedLogin = $this->db()->quote($rent->playerLogin);
		$quotedServerOptions = $this->db()->quote(serialize($rent->serverOptions));
		$quotedGameInfos = $this->db()->quote(serialize($rent->gameInfos));
		$quotedMaps = $this->db()->quote(serialize($rent->maps));

		$this->db()->execute(
				'INSERT INTO Rents (playerLogin, duration, serverOptions, gameInfos, maps) '.
				'VALUES (%s, %d, %s, %s, %s)', $quotedLogin, $rent->duration,
				$quotedServerOptions, $quotedGameInfos, $quotedMaps
		);
	}

	function updateRent(Rent $rent)
	{
		if(!(int) $rent->duration)
		{
			throw new \InvalidArgumentException();
		}

		if(!(int) $rent->id)
		{
			throw new \InvalidArgumentException();
		}

		$this->db()->execute('UPDATE Rents SET duration = %d WHERE id = %d',
				$rent->duration, $rent->id);
	}

}

?>