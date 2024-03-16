<?php

class User 
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $created_at;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function getUser(): array
    {
        $result = [];

        $result = [
            'Nome' => $this->getName(),
            'Email' => $this->getEmail(),
            'Password' => $this->getPassword(),
        ];

        return $result;
    }

    public function setName($name): User
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail($email): User 
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }
    
    public function setCreatedAt($created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function loadUserById($id): array
    {
        $database = new Database();

        $data = $database->select("SELECT * FROM users WHERE id LIKE '$id' ");
        if(!$data){
            throw new \Exception("O id '$id' do usuario não existe ou não foi encontrado.");
        }

        $this->setName($data[0]['username']);
        $this->setEmail($data[0]['email']);
        $this->setPassword($data[0]['password']);
        $this->setCreatedAt($data[0]['created_at']);

        $result = [];

        $date = date_create($this->getCreatedAt());

        $result = [
            'Nome'=> $this->getName(),
            'Email'=> $this->getEmail(),
            'Senha'=> $this->getPassword(),
            'Data de cadastro'=> date_format($date,"d-m-Y")
        ];

        return $result;
       
    }
}