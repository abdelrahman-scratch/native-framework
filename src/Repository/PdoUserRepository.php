<?php

namespace App\Repository;

use App\Constant\DatabaseConstant;
use App\Contract\UserRepositoryInterface;

class PdoUserRepository extends AbstractPdoRepository implements UserRepositoryInterface
{
    protected $tableName = DatabaseConstant::USERS_TABLE;
    protected $rolesTable = DatabaseConstant::ROLES_TABLE;

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return $this->findOneByAttribute("email", $email);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmailWithRole(string $email)
    {
        $query = "SELECT {$this->tableName}.id,{$this->tableName}.password, {$this->rolesTable}.name as role_name  FROM {$this->tableName} LEFT JOIN {$this->rolesTable}" .
            " ON {$this->tableName}.role_id = {$this->rolesTable}.id WHERE email = :email LIMIT 1";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":email", $email);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_OBJ);
    }

}