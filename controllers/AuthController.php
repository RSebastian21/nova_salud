<?php

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }

        $this->view('auth/login', ['title' => 'Login']);
    }

    public function authenticate(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Por favor completa todos los campos.';
            $this->redirect('login');
            return;
        }
        
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            $_SESSION['success'] = 'Bienvenido ' . $user['name'];
            $this->redirect('dashboard');
            return;
        }

        $_SESSION['error'] = 'Credenciales inválidas.';
        $this->redirect('login');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('login');
    }
}

