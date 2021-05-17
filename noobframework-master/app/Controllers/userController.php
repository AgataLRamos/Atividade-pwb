<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Session;
use App\Models\User;

class UserController extends Controller
{

    private $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
    }
    public function index()
    {
        $user = $this->session->get('user');
        if ($user) {
            $userModel = new User();
            $users = $userModel->getAll();
            $this->view('users', ['users' => $users, 'user ' => $user]);
        } else

            $this->redirect('/user/login');
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
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            $user = $this->session->get('user');

            if ($user) {
                $this->redirect('/user');
            }
            $this->view('login');
        } else {
            $userModel = new User();
            $user = $userModel->login($request->post('email'), $request->post('senha'));

            if ($user) {
                $this->session->set('user', $user);
                $this->redirect('/user');
            }
            $this->view('login', ['email' => $request->post('email'), 'message' => 'Login ou senha inválido']);
        }
    }
    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            $userId = $request->get();
            $userModel = new User();
            $user = $userModel->findById($userId);
            $this->view('form', ['user' => $user]);
        } else {
            $userId = $request->get();
            $data = $request->post();
            $userModel = new User();
            $user = $userModel->update($data, ['id' => $userId]);
            $this->redirect('/user');
        }
    }
    public function delete(Request $request)
    {
        $userId = $request->get();

        if ($userId != null) {
            $userModel = new User();
            $users = $userModel->delete($userId);
        }
        $this->redirect('/user');
    }
    public function logout()
    {

        $this->session->destroy();
        $this->redirect('/user/create');
    }
}
