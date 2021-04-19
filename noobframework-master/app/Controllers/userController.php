<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $userModel = new User();
        $users = $userModel->getAll();
        $this->view('users', ['users' => $users]);
    }


    public function create(Request $request)
    {

        if ($request->isMethod('get')) {
            $this->view('form');
        } else {
            $userModel = new User();

            $response = $userModel->record($request->post());

            $this->view('apresenta', ['user' => $request->post(), 'response' => $response]);
        }
    }
}
