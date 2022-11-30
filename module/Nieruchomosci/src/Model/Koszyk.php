<?php

namespace Nieruchomosci\Model;

use Laminas\Db\Adapter as DbAdapter;
use Laminas\Db\Sql\Sql;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

class Koszyk implements DbAdapter\AdapterAwareInterface
{
	use DbAdapter\AdapterAwareTrait;
	
	protected Container $sesja;
	
	public function __construct()
	{
		$this->sesja = new Container('koszyk');
		$this->sesja->liczba_ofert = $this->sesja->liczba_ofert ?: 0;
	}

    /**
     * Dodaje ofertdo koszyka.
     *
     * @param int $idOferty
     * @return int|null
     */
	public function dodaj(int $idOferty): ?int
	{
		$dbAdapter = $this->adapter;
		$session = new SessionManager();
		
		$sql = new Sql($dbAdapter);

		$select = $sql->select('koszyk')->where(['id_oferty' => $idOferty]);
		
		$selectString = $sql->buildSqlString($select);
		$wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);

		$liczba = 0;

		foreach ($wynik as $row) {
			$liczba++;
		}

		if($liczba != 0) {
			return null;
		}

		$insert = $sql->insert('koszyk');
		$insert->values([
			'id_oferty' => $idOferty,
			'id_sesji' => $session->getId()
        ]);
		
		$selectString = $sql->buildSqlString($insert);
		$wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);
		
		try {
			return $wynik->getGeneratedValue();
		} catch(\Exception $e) {
			return null;
		}
	}

	public function wyswietlZawartosc()
	{
		$dbAdapter = $this->adapter;
		$session = new SessionManager();
		
		$sql = new Sql($dbAdapter);
		$select = $sql->select('koszyk');

		$select = $sql->select();
        $select->from(['k' => 'koszyk']);
        $select->join(['o' => 'oferty'], 'o.id = k.id_oferty', ['id','typ_oferty', 'typ_nieruchomosci', 'numer', 'powierzchnia', 'cena']);
        $select->order('o.id');
		
		$selectString = $sql->buildSqlString($select);
		$wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);

		return $wynik;
	}

    /**
     * Zwraca liczbe ofert w koszyku.
     *
     * @return int
     */
	public function liczbaOfert(): int
	{
		$dbAdapter = $this->adapter;
		$session = new SessionManager();
		
		$sql = new Sql($dbAdapter);
		$select = $sql->select('koszyk')->where(['id_sesji' => $session->getId()]);
		
		$selectString = $sql->buildSqlString($select);
		$wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);
		
		$liczba = 0;

		foreach ($wynik as $row) {
			$liczba++;
		}
		return $liczba;
	}
}