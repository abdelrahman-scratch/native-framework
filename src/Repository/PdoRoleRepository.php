<?php

namespace App\Repository;


use App\Contract\RoleRepositoryInterface;

class PdoRoleRepository extends AbstractPdoRepository implements RoleRepositoryInterface
{
    protected $tableName = "roles";

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        $result = $this->findOneByAttribute("name", $name);

        return $result ? $result : null;
    }
}