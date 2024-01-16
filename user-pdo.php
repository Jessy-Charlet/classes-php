<?php
session_start();
class user
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct()
    // Est appelé automatiquement lors de l’initialisation de votre objet.
    // Initialise les différents attributs de votre objet.
    {
        $this->login = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
    }

    public function register($login, $password, $email, $firstname, $lastname)
    // Crée l’utilisateur en base de donnée dans la table “utilisateurs”.
    // Retourne un tableau contenant l'ensemble des informations de ce même utilisateur.
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')";
        $connexion = new PDO('mysql:host=localhost; dbname=classes; charset=utf8', 'root', '');
        $stat = $connexion->prepare($sql);
        $stat->execute();
        $infos = array($login, $password, $email, $firstname, $lastname);
        echo '<table>
        <tr>
        <td>' . $login . ' </td>
        <td> ' . $password . '</td>
        <td>' . $email . '</td>
        <td>' . $firstname . '</td>
        <td>' . $lastname . '</td>
        </tr>
        </table>';

    }

    public function connect($login, $password)
    // Connecte l’utilisateur, et donne aux attributs de la classe les valeurs
    // correspondantes à celles de l’utilisateur
    {
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
        $connexion = new PDO('mysql:host=localhost; dbname=classes; charset=utf8', 'root', '');
        $stat = $connexion->prepare($sql);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_ASSOC);
        if (mysqli_num_rows($result)) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['connect'] = true;
            $this->login = $row['login'];
            $this->password = $row['password'];
            $this->email = $row['email'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $_SESSION['connect'] = true;
            echo "connecté";
        }
    }

    public function disconnect()
    // Déconnecte l’utilisateur
    {
        $this->login = "";
        $this->password = "";
        $this->email = "";
        $this->firstname = "";
        $this->lastname = "";
        unset($_SESSION['connect']);
    }

    public function delete($login)
    //Supprime ET déconnecte un user
    {
        $sql = "DELETE FROM utilisateurs WHERE login = '$login'";
        $connexion = new PDO('mysql:host=localhost; dbname=classes; charset=utf8', 'root', '');
        $stat = $connexion->prepare($sql);
        $stat->execute();
        unset($_SESSION['connect']);
    }

    public function update($login, $password, $email, $firstname, $lastname)
    // Met à jour les attributs de l’objet, et modifie les
    // informations en base de données.
    {
        $id = $this->id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $sql = "UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = '$id'";
        $connexion = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
        $stat = $connexion->prepare($sql);
        $stat->execute();
    }

    public function isConnected()
    // Retourne un booléen (true ou false) permettant de savoir si
    // un utilisateur est connecté ou non
    {
        if (isset($_SESSION['connect'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos()
    // Retourne un tableau contenant l’ensemble des informations de
    // l’utilisateur
    {
        echo '<table>
        <tr>
        <td>' . $this->login . ' </td>
        <td>' . $this->email . '</td>
        <td>' . $this->firstname . '</td>
        <td>' . $this->lastname . '</td>
        </tr>
        </table>';
    }
    public function getLogin()
    // Retourne le login de l’utilisateur
    {
        return $this->login;
    }
    public function getEmail()
    // Retourne l'email de l’utilisateur
    {
        return $this->email;
    }
    public function getFirstname()
    // Retourne le firstname de l’utilisateur
    {
        return $this->firstname;
    }
    public function getLastname()
    // Retourne le lastname de l’utilisateur
    {
        return $this->lastname;
    }
}

$user = new user();
$user->register('Toki3', '123', 'mail@mail.com', 'prénom', 'nom');
// $user->connect('Toki3', '123');
// $user->disconnect();
// $user->delete('Toki3');
// $user->update('Toki3', '123', 'mail@mail.com', 'prénom', 'nom');
// $user->isConnected();
// $user->getAllInfos();
// $user->getLogin();
// $user->getEmail();
// $user->getFirstname();
// $user->getLastname();
?>