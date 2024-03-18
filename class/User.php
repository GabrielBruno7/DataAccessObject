<?php

class User 
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $created_at;

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

    public function loadAllUsers()
    {
        $database = new Database();

        $data = $database->select("SELECT * FROM users");

        return $data;
        
    }
    public function loadByName(string $name)
    {
        $error = "O nome não existe ou não foi encontrado na base de dados";

        $database = new Database();

        $data = $database->select("SELECT * FROM users WHERE username LIKE '%$name%'");

        if(!$data or $name === ""){
            throw new \Exception($error);
        }

        return $data;
        
    }
    public function login(string $email, string $password)
    {
        $database = new Database();

        $result = $database->select("SELECT * FROM users WHERE email LIKE '$email' AND password LIKE '$password'");

        if (!$result) {
            throw new \Exception("Email ou senha invalidos ou faltando.");
        }

        $this->setEmail($email);
        $this->setPassword($password);

        return $result;
    }
    public function createUser(string $name, string $email, string $password)
    {
        $database = new Database();

        $this->checkingIfEmailAlreadyExists($email, $database);

        $database->select("INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')");

    }

    public function checkingIfEmailAlreadyExists(string $email, $database)
    {
        $query = $database->select("SELECT * FROM  users WHERE email LIKE '$email'");

        if (count($query) > 0)
        {
            throw new \Exception("Esse email já está cadastrado !");
        }

    }

    public function updateUser(int $id, ?string $newName = null, ?string $newEmail = null)
    {
        $database = new Database;

        $result = [];

        $result = $database->select("SELECT * FROM users WHERE id LIKE '$id'");

        $this->updateName($newName, $database, $result, $id);

        $this->updateEmail($newEmail, $database, $result, $id);

    }

    public function updateName($newName, $database, $result, $id)
    {
        if ($newName !== null) {
            $this->setName($result[0]['username']);
            $this->setName($newName);
            $database->select("UPDATE users SET username = '$newName' WHERE id LIKE '$id'");
        }
    }
    public function updateEmail($newEmail, $database, $result, $id)
    {
        if ($newEmail !== null) {
            $this->setName($result[0]['email']);
            $this->setName($newEmail);
            $database->select("UPDATE users SET email = '$newEmail' WHERE id LIKE '$id'");
        }
    }

    







}