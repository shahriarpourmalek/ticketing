<?php

namespace App\DTOs;

class LoginUserDTO
{
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function toArray()
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
