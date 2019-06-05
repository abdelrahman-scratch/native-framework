<?php

namespace App\Repository;

use App\Constant\DatabaseConstant;
use PDO;

abstract class AbstractPdoRepository
{
    protected $tableName;
    /**
     * @var PDO
     */
    protected $pdo;
    /**
     * @var string
     */
    protected $joinsQuery;

    /**
     * AbstractBasePdoRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->joinsQuery = "";
    }

    public function getAll(array $pagination = [], $attributes = ['*']): array
    {

        $query = "SELECT " . implode(",", $attributes) . " FROM {$this->tableName} " .
            $this->joinsQuery . " ORDER BY {$this->tableName}.created_at DESC";
        if (!empty($pagination)) {
            $query = $query . " LIMIT :fromRecordNum , :recordsPerPage ";


            $recordsPerPage = $pagination["recordsPerPage"] ?? DatabaseConstant::PAGINATION_PER_PAGE;
            $page = $pagination["pageNumber"];
            $fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(':fromRecordNum', $fromRecordNum, PDO::PARAM_INT);
            $stm->bindValue(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
        } else {
            $stm = $this->pdo->prepare($query);
        }
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_OBJ);

    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->tableName}";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchColumn();
    }


    /**
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function create(array $data)
    {
        $query = $this->getInsertQuery($data);
        $stm = $this->pdo->prepare($query);

        foreach ($data as $name => $value) {
            $stm->bindValue(":{$name}", $value);

        }

        $stm->execute();

        return $this->pdo->lastInsertId($this->tableName);
    }


    private function getUpdateQuery($data)
    {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = "{$key} = :{$key}";
        }
        $sets = implode(',', $sets);

        return "UPDATE {$this->tableName}  SET {$sets}  WHERE ";
    }

    public function findOneByAttribute(string $attribute, $value)
    {
        $query = "SELECT * FROM {$this->tableName} WHERE {$attribute} = :{$attribute} LIMIT 1";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":{$attribute}", $value);
        $stm->execute();

        return $stm->fetch(PDO::FETCH_OBJ);
    }

    public function update(int $id, array $data)
    {
        $query = $this->getUpdateQuery($data);
        $query = $query . "id = :id";
        $stm = $this->pdo->prepare($query);

        foreach ($data as $name => $value) {
            $stm->bindValue(":{$name}", $value);
        }
        $stm->bindValue(":id", $id, PDO::PARAM_INT);

        return $stm->execute();
    }

    private function getInsertQuery(array $data)
    {
        $fields = $this->getQueryFields($data);
        $values = $this->getQueryValues($data);
        return "INSERT INTO {$this->tableName} ({$fields}) VALUES ({$values})";
    }

    private function getQueryFields($data)
    {
        if (!empty($data)) {
            $fields = array_keys($data);
            return implode(',', $fields);
        }
        return '*';
    }

    private function getQueryValues(array $data)
    {
        foreach ($data as $key => $value) {
            $values[] = ":{$key}";
        }
        return implode(',', $values);
    }


}