<?php


namespace Recruitment\Dbal;


class Connection extends \PDO
{
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->exec('SET NAMES utf8');
        $this->exec('SET time_zone = \'Europe/Warsaw\'');
    }


    public function importData(iterable $data)
    {
        $sql = 'INSERT INTO `mockaroo` (id, first_name, last_name, email, gender, ip_address, country)  VALUES (:id, :first_name,:last_name, :email,:gender,:ip_address,:country)';
        $statement = $this->prepare($sql);
        foreach ($data as $rowData) {

            $statement->bindValue(':id', (int)$rowData['id']);
            $statement->bindValue(':first_name', $rowData['first_name']);
            $statement->bindValue(':last_name', $rowData['last_name']);
            $statement->bindValue(':email', $rowData['email']);
            $statement->bindValue(':gender', $rowData['gender']);
            $statement->bindValue(':ip_address', $rowData['ip_address']);
            $statement->bindValue(':country', $rowData['country']);
            $statement->execute();
            $statement->closeCursor();
        }

    }

    public function getCountryCount()
    {
        $sql = 'SELECT m.country, COUNT(1) as count FROM mockaroo m GROUP BY m.country';
        $statement = $this->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
//        \var_dump($data);

        return $data;
    }
}