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

        $result = $database->select(
        "SELECT * FROM users WHERE email LIKE '$email' AND password LIKE '$password'");

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

        $database->select("INSERT INTO users (username, email, password) VALUES ('$name','$email','$password')"
        );

        $message = "Usuario $name criado com sucesso!";
        echo "<script>alert('$message');</script>";
    }

    public function checkingIfEmailAlreadyExists(string $email, $database)
    {
        $query = $database->select("SELECT * FROM  users WHERE email LIKE '$email'");

        if (count($query) > 0)
        {
            throw new \Exception("Esse email já está cadastrado !");
        }

    }

    public function deleteUser(int $id)
    {
        $database = new Database();
        $database->select("DELETE from users WHERE id = '$id'");

        $data = $database->select("SELECT id FROM users WHERE id = '$id'");

        if(!$data){
            $message = 'O usuário foi excluido.';
            echo "<script>alert('$message');</script>";
        }

        if($data === $id){
            $message = "Algo deu errado e o usuario não foi deletado";
            echo "<script>alert('$message');</script>";
        }
    }


    public function updateUser(int $id, string $field, string $newParam)
    {
        $this->loadUserById($id);

        $fields = array("username", "email", "password");

        if ($field !== $fields[0] && $field !== $fields[1] && $field !== $fields[2] )
        {
            throw new \Exception(
                "O campo '$field' não existe,
                Escolha entre username,
                email ou password"
            );
        }

        $database = new Database();
        $database->select("UPDATE users SET $field = '$newParam' WHERE id = '$id';");

        $this->setEmail($newParam);
        
        $message = "O $field foi alterado para $newParam";

        echo "<script>alert('$message');</script>";
    }



}