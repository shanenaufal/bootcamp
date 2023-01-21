<?php

require_once("Database.php");

class User
{
    private string $table = 'users';
    private ?object $statement;

    public function __constuct()
    {
        $this->statement = new Database();
        $this->statement = $this->statement->connection;
        $this->email = $_POST['email'] ?? null;
        $this->password = $_POST['password'] ?? null;
    }

    public function users()
    {
        $query = "SELECT * FROM $this->table";
        $statement = $this->statement->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($users);
        echo "</pre>";
        return $statement;
    }

    public function store(): void
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $statement = $this->statement->prepare($query);
        $statement->bindParam(':email', $this->email);
        $statement->ecexute();
        if ($statement->rowCount()>0){
            $response = [
                'message' => 'Data user sudah ada',
        ];
        }else {
            $query = "INSERT INTO {$this->table} (nama , kelamin, telpon, prodi, email, password) VALUES (:nama, :kelamin, :telpon, :prodi, :email, :password)";
            $statement = $this->statement->prepare($query);
            $password = md5($this->password);
            $statement->bindParam(':nama', $this->nama);
            $statement->bindParam(':kelamin', $this->kelamin);
            $statement->bindParam(':telpon', $this->telpon);
            $statement->bindParam(':prodi', $this->prodi);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':password', $this->password);
            $statement->execute();
            $response = [
                'message' => 'Data user berhasil ditambah',
            ];
            echo json_encode($response);
        }
       
    }
        
}

$users = new User();
$users = $users->users();
//$users->store();
var_dump($users);