<?php

namespace App\Models;

use Core\DataBase;

class User
{

    private $table = "user";

    public function getAll()
    {

        $db = DataBase::getInstance();

        return $db->getList($this->table, "*");
    }
    public function record($data = null)
    {
        $db = DataBase::getInstance();
        if ($db->getList($this->table, '*', ['email' => $data['email']])) {
            echo 'Cuidado!! email já existe';
            return false;
        }
        if ($data != null && !empty($data)) {

            if (
                isset($data['nome']) &&
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                isset($data['senha'])
            ) {
                $data = [
                    'nome' => $data['nome'],
                    'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
                    'telefone' => $data['telefone'] ? $data['telefone'] : null,
                    'senha' => password_hash($data['senha'], PASSWORD_BCRYPT, ["cost" => 10]),
                ];


                return $db->insert($this->table, $data);
            }
        }

        return false;
    }
}
