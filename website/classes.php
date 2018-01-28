<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'plugins/phpmailer/Exception.php';
require 'plugins/phpmailer/PHPMailer.php';
require 'plugins/phpmailer/SMTP.php';

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
     * @param string @password;
     * @param string @accounttype;
     * @param string @street;
     * @param int  @housenumber;
     * @param string  @houseaffix;
     * @param string  @zipcode;
     * @param string  @city;
     */

    private $id;
    private $firstname;
    private $middlename = null;
    private $lastname;
    private $birthday;
    private $phonenumber;
    private $email;
    private $active;
    private $password;
    private $accounttype;
    private $street;
    private $housenumber;
    private $houseaffix = null;
    private $zipcode;
    private $city;

    public function __construct($id = null, $firstname = null, $middlename = null, $lastname = null, $birthday = null, $phonenumber = null, $email = null, $active = null, $password = null, $accounttype = null, $street = null, $housenumber = null, $houseaffix = null, $zipcode = null, $city = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->phonenumber = $phonenumber;
        $this->email = $email;
        $this->active = $active;
        $this->password = $password;
        $this->accounttype = $accounttype;
        $this->street = $street;
        $this->housenumber = $housenumber;
        $this->houseaffix = $houseaffix;
        $this->zipcode = $zipcode;
        $this->city = $city;
    }

    /**
     * @param mixed $id;
     * @param mixed $db;
     * @return mixed customer
     */
    public static function getCustomerByCustomerId($db, $id)
    {
        $tempcustomer = new Customer();
        $customer = $db->query('SELECT * FROM `klanten` WHERE klantnummer = '.$id)->fetch_assoc();
        $tempcustomer->setId($customer['klantnummer']);
        $tempcustomer->setFirstname($customer['voornaam']);
        $tempcustomer->setMiddlename($customer['tussenvoegsel']);
        $tempcustomer->setLastname($customer['achternaam']);
        $tempcustomer->setBirthday($customer['geboortedatum']);
        $tempcustomer->setPhonenumber($customer['telefoonnummer']);
        $tempcustomer->setEmail($customer['emailadres']);
        $tempcustomer->setActive($customer['actief']);
        $tempcustomer->setPassword($customer['wachtwoord']);
        $tempcustomer->setAccounttype($customer['accounttype']);
        $tempcustomer->setStreet($customer['straat']);
        $tempcustomer->setHousenumber($customer['huisnummer']);
        $tempcustomer->setHouseaffix($customer['huisnummertoevoeging']);
        $tempcustomer->setZipcode($customer['postcode']);
        $tempcustomer->setCity($customer['stad']);

        return $tempcustomer;
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
        $db->query('INSERT INTO `klanten` 
                    (`voornaam`, `tussenvoegsel`, `achternaam`, `geboortedatum`, `telefoonnummer`, `emailadres`, `actief`, `wachtwoord`, `accounttype`, `straat`, `huisnummer`, `huisnummertoevoeging`, `postcode`, `stad`) 
                    VALUES ("'.$this->getFirstname().'",
                            "'.$this->getMiddlename().'",
                            "'.$this->getLastname().'",
                            "'.$this->getBirthday().'",
                            '.$this->getPhonenumber().',
                            "'.$this->getEmail().'",
                            '.$this->getActive().',
                            "'.$this->getPassword().'",
                            "'.$this->getAccounttype().'",
                            "'.$this->getStreet().'",
                            '.$this->getHousenumber().',
                            "'.$this->getHouseaffix().'",
                            "'.$this->getZipcode().'",
                            "'.$this->getCity().'"
                            );

        ');
    }

    public function updateCustomer($db)
    {
        $db->query('UPDATE `klanten` SET 
                                        `voornaam`= "'.$this->getFirstname().'",
                                        `tussenvoegsel`= "'.$this->getMiddlename().'",
                                        `achternaam`= "'.$this->getLastname().'",
                                        `geboortedatum`= "'.$this->getBirthday().'",
                                        `telefoonnummer`='.$this->getPhonenumber().',
                                        `emailadres`="'.$this->getEmail().'",
                                        `actief`='.$this->getActive().',
                                        `wachtwoord`= "'.$this->getPassword().'",
                                        `accounttype`= "'.$this->getAccounttype().'",
                                        `straat`= "'.$this->getStreet().'",
                                        `huisnummer`='.$this->getHousenumber().',
                                        `huisnummertoevoeging`="'.$this->getHouseaffix().'",
                                        `postcode`="'.$this->getZipcode().'",
                                        `stad`="'.$this->getCity().'"
                                        WHERE
                                        `klantnummer` = '.$this->getId().'
        ');
    }

    /**
     * @return boolean
     */
    public function sendAdviceEmailRequest(){
        try{
        $mail = new PHPMailer(true);
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'BeterDanHUbl@gmail.com';                 // SMTP username
        $mail->Password = 'degeitisgemolken';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
            $mail->smtpConnect(
                array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                )
            );
        //Recipients
        $customerfullname = $this->getFirstname() .' '.$this->getMiddlename() .' '.$this->getLastname();
        $mail->setFrom($this->getEmail(), $customerfullname );
        $mail->addAddress('BeterDanHUbl@gmail.com', "Benno's sportschool");     // Add a recipient
        $mail->addReplyTo($this->getEmail(), $customerfullname);


        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Sport advies aanvraag';
        $mail->Body    = 'De klant '.$customerfullname. ' heeft sport advies aangevraagd.<br> De sport activiteiten kan je met <a href="benno.using.ovh/stats.php?id='.$this->getId().'">deze link</a> nakijken. <br> Gelieve zo snel mogelijk naar '.$this->getEmail().' . ';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return 'Message has been sent';



        }catch (Exception $e){
            return 'Mail kan niet worden verzonden. De mailer gaf de volgende error: '. $mail->ErrorInfo;
        }
    }
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAccounttype()
    {
        return $this->accounttype;
    }

    /**
     * @param mixed $accounttype
     */
    public function setAccounttype($accounttype)
    {
        $this->accounttype = $accounttype;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getHousenumber()
    {
        return $this->housenumber;
    }

    /**
     * @param mixed $housenumber
     */
    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;
    }

    /**
     * @return null
     */
    public function getHouseaffix()
    {
        return $this->houseaffix;
    }

    /**
     * @param null $houseaffix
     */
    public function setHouseaffix($houseaffix)
    {
        $this->houseaffix = $houseaffix;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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

