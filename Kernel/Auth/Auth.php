<?php

namespace App\Kernel\Auth;

use App\Kernel\Auth\AuthInterface;
use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Session\SessionInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private DatabaseInterface $db,
        private SessionInterface  $session,
        private ConfigInterface   $config,
    )
    {
    }

    public function attempt(string $username, string $password): bool
    {

        $userData = $this->db->first($this->table(), [
            $this->username() => $username,
        ]);

        if (!$userData) {
            return false;
        }


        $user = new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );


        if (!password_verify($password, $user->password())) {
            return false;
        }


        $this->session->set($this->sessionField(), $user->id());

        return true;
    }

    public function logout(): void
    {
        $this->session->remove($this->sessionField());
    }


    public function user(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $userData = $this->db->first($this->table(), [
            'id' => $this->session->get($this->sessionField()),
        ]);

        if (!$userData) {
            return null;
        }


        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }

    public function check(): bool
    {
        return $this->session->has($this->sessionField());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function username(): string
    {
        return $this->config->get('auth.username', 'email');
    }

    public function password(): string
    {
        return $this->config->get('auth.password', 'password');
    }

    public function table(): string
    {
        return $this->config->get('auth.table', 'users');
    }

    public function sessionField(): string
    {
        return $this->config->get('auth.sesion_field', 'users_id');
    }
}
