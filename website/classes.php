<?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 25-1-2018
 * Time: 10:51
 */
include 'db.php';
$db = new MySQL();
$db->connect('127.0.0.1','root','', 'benno', '3306');

Class Customer
{
    /**
     * customer class
     *
     * @param int @id
     * @param string @firstName
     * @param string @middleName
     * @param string @lastName
     * @param string @birthday
     * @param int @phonenumber
     * @param string @email
     * @param string @active
     */

    private $id;
    private $firstname;
    private $middlename = null;
    private $lastname;
    private $birthday;
    private $phonenumber;
    private $email;
    private $active;
//    private $username; tbi not yet in db
//    private $password; tbi not yet in db

    /**
     * Customer constructor.
     * @param $id
     * @param $firstname
     * @param null $middlename
     * @param $lastname
     * @param $birthday
     * @param $phonenumber
     * @param $email
     * @param $active
     */

    public function __construct($id=null, $firstname=null, $middlename=null, $lastname=null, $birthday=null, $phonenumber=null, $email=null, $active=null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->phonenumber = $phonenumber;
        $this->email = $email;
        $this->active = $active;
    }

    /**
     * @param mixed $id;
     * @param mixed $db;
     * @return mixed customer
     */
    public static function getCustomerByCustomerId($db, $id)
    {
        $test = new Customer();
        $customer = $db->query('SELECT * FROM `klanttabel` WHERE klantnummer = '.$id)->fetch_assoc();
        $test->setId($customer['klantnummer']);
        $test->setFirstname($customer['voornaam']);
        $test->setMiddlename($customer['tussenvoegsel']);
        $test->setLastname($customer['achernaam']);
        $test->setBirthday($customer['geboortedatum']);
        $test->setPhonenumber($customer['telefoonnummer']);
        $test->setEmail($customer['emailadres']);
        $test->setActive($customer['actief']);
        return $test;
    }

    public static function activateCustomerByCustomerId($db, $id)
    {
        $db->query('UPDATE `klanttabel` SET `actief`=TRUE WHERE `klantnummer`='.$id);
    }

    public static function deactivateCustomerByCustomerId($db, $id)
    {
        $db->query('UPDATE `klanttabel` SET `actief`=FALSE WHERE `klantnummer`='.$id);
    }

    /**
     * @param mixed $db;
     */
    public function insertCustomerInDB($db)
    {
        $db->query('INSERT INTO `klanttabel`
                    (`voornaam`, `tussenvoegsel`, `achernaam`, `geboortedatum`, `telefoonnummer`, `emailadres`, `actief`) 
                    VALUES (
                            '.$this->getFirstname().',
                            '.$this->getMiddlename().',
                            '.$this->getLastname().',
                            '.$this->getBirthday().',
                            '.$this->getPhonenumber().',
                            '.$this->getEmail().',
                            '.$this->getActive().'
        ');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return null
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param null $middlename
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * @param mixed $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


}

