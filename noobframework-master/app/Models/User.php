<?php

namespace App\Models;

use Core\DataBase;

class User
{

    private $table = "user";

    public function login($email, $senha)
    {
        $db = DataBase::getInstance();

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $data = $db->getList($this->table, '*', ['email' => $email]);
        $user = $data[0];
        if (isset($user['id']) && password_verify($senha, $user['senha'])) {
            unset($user['senha']);
            return $user;
        }
        return false;
    }
    public function getAll()
    {

        $db = DataBase::getInstance();

        return $db->getList($this->table, "*");
    }
    public function findById($id)
    {
        $db = DataBase::getInstance();
        $data = $db->getList($this->table, '*', ['id' => $id]);


        return $data[0];
    }


    public function record($data = null)
    {
        $db = DataBase::getInstance();

        if ($data != null && !empty($data)) {

            if (
                isset($data['nome']) &&
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                isset($data['senha'])
            ) {
                $data = [
                    'nome' => $data['nome'],
                    'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
                    'mensagem' => $data['mensagem'] ? $data['mensagem'] : null,
                    'senha' => password_hash($data['senha'], PASSWORD_BCRYPT, ["cost" => 10]),
                ];


                return $db->insert($this->table, $data);
            }
        }

        return false;
    }
    public function update($data, $condition)
    {
        $db = DataBase::getInstance();
        $data['senha'] = password_hash($data['senha'], PASSWORD_BCRYPT, ["cost" => 10]);
        return $db->update($this->table, $data, $condition);
    }
    public function delete(int $id)
    {
        $db = DataBase::getInstance();
        return  $db->delete($this->table, ['id' => $id]);
    }
}
