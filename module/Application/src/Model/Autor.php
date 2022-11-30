<?php

namespace Application\Model;

use Laminas\Db\Adapter as DbAdapter;
use Laminas\Db\Sql\Sql;

class Autor implements DbAdapter\AdapterAwareInterface
{
    use DbAdapter\AdapterAwareTrait;

    public function pobierzSlownik(): array
    {
        $dbAdapter = $this->adapter;

        $sql = new Sql($dbAdapter);
        $select = $sql->select('autorzy');
        $select->order('nazwisko');

        $selectString = $sql->buildSqlString($select);
        $wyniki = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);

        $temp = [];
        foreach ($wyniki as $rek) {
            $temp[$rek->id] = $rek->imie . ' ' . $rek->nazwisko;
        }

        return $temp;
    }
}