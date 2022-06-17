<?php
//error_reporting(0);
require_once "MyPdo.php";

class Inventor
{
    /* @var MyPDO */
    protected $db;

    protected int $id;
    protected string $name;
    protected string $surname;
    protected DateTime $birth_date;
    protected string $birth_place;
    protected string $description;
    protected ?DateTime $death_date = null;
    protected string $death_place;


    public function __construct()
    {
        $this->db = MyPDO::instance();
    }

    /**
     * @param mixed $data
     * @return Inventor
     */
    public static function getUser(mixed $data): Inventor
    {
        $user = new Inventor();
        $user->id = $data['ID'];
        $user->name = $data['Name'];
        $user->surname = $data['Surname'];
        $user->description = $data['Description'];
        $user->birth_date = DateTime::createFromFormat('Y-m-d', $data['Birth_date']);
        $user->birth_place = $data['Birth_place'];
        return $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getDeathDate(): DateTime
    {
        if($this->death_date==null){
            $this->death_date = DateTime::createFromFormat('Y-m-d', "0001-01-01");
        }
        return $this->death_date;
    }

    /**
     * @param DateTime $death_date
     */
    public function setDeathDate(?string $death_date): void
    {
        if (str_contains($death_date, '-')) {

            $this->death_date = DateTime::createFromFormat('Y-m-d', $death_date);
        }
        else if(str_contains($death_date, '.')){
            $this->death_date = DateTime::createFromFormat('d.m.Y', $death_date);
        }
        else{
            $this->death_date=null;
        }

    }

    /**
     * @return string
     */
    public function getDeathPlace(): string
    {
        return $this->death_place;
    }

    /**
     * @param string $death_place
     */
    public function setDeathPlace(string $death_place): void
    {
        $this->death_place = $death_place;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getBirthDate(): DateTime
    {
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        if(str_contains($birth_date, '-')){
            $this->birth_date = DateTime::createFromFormat('Y-m-d', $birth_date);
        }
        else{
            $this->birth_date = DateTime::createFromFormat('d.m.Y', $birth_date);
        }
    }

    /**
     * @return string
     */
    public function getBirthPlace(): string
    {
        return $this->birth_place;
    }

    /**
     * @param string $birth_place
     */
    public function setBirthPlace(string $birth_place): void
    {
        $this->birth_place = $birth_place;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public static function all()
    {

        return MyPDO::instance()->run("SELECT * FROM Inventors ")->fetchAll();
    }

    public static function searchByDescription($description)
    {
        $data = MyPDO::instance()->run("SELECT * FROM Inventors WHERE description = ?", [$description])->fetch();
        if (!$data) {
            return false;
        }
        $user = self::getUser($data);
        return $user;
    }


    public static function findBySurname($surname)
    {

        return MyPDO::instance()->run("SELECT * FROM Inventors WHERE Surname = ?", [$surname])->fetchAll();
    }

    public static function findInventor($id)
    {
        $data = MyPDO::instance()->run("SELECT * FROM Inventors WHERE ID = ?", [$id])->fetch();
        $user = self::getUser($data);
        if ($data['Death_date']) {
            $user->death_date = DateTime::createFromFormat('Y-m-d', $data['Death_date']);
        }
        $user->death_place = $data['Death_place'];

        return $user;
    }

    public static function findInventorById($id)
    {
        return Inventor::findInventor($id)->toArray();
    }

    public static function findWithInventions($id)
    {
        $data1 = MyPDO::instance()->run("SELECT * FROM Inventors WHERE ID = ?", [$id])->fetch();
        $data = MyPDO::instance()->run("SELECT * FROM Inventions WHERE Inventor_id=?", [$data1["ID"]])->fetchAll();
        return ["Inventor" => $data1, "inventions" => $data];
    }

    public static function updateInventor($id, $name, $surname, $birthPlace, $birthDate, $description, $deathDate, $deathPlace)
    {
        $user = Inventor::findInventor($id);
        MyPDO::instance()->run("UPDATE Inventors SET Name = ?, Surname=?, Birth_date=?, Birth_place=?, 
                                    Description=?, Death_date=?, Death_place=? WHERE ID=?;",
            [$name == "" ? $user->getName() : $name, $surname == "" ? $user->getSurname() : $surname, $birthDate == "" ? $user->getBirthDate()->format('Y-m-d') : $birthDate,
                $birthPlace == "" ? $user->getBirthPlace() : $birthPlace, $description == "" ? $user->getDescription() : $description,
                $deathDate == "" ? strcmp($user->getDeathDate()->format('Y-m-d'), '0001-01-01') == 0 ? null : $user->getDeathDate()->format('Y-m-d') : $deathDate, $deathPlace == "" ? $user->getDeathPlace() : $deathPlace, $id])->fetch();
    }

    public function destroy()
    {
        MyPDO::instance()->run("delete from Inventors where id = ?",
            [$this->id]);
        unset($this->id);
        return true;
    }

    public function save()
    {
        var_dump($this->death_date);
        $this->db->run("INSERT into Inventors 
            (`Name`, `Surname`, `Birth_date`, `Birth_place`, `description`, `Death_date`, `Death_place`) values (?, ?, ?, ?, ?, ?, ?)",
            [$this->name, $this->surname, $this->birth_date->format('Y-m-d'), $this->birth_place, $this->description, isset($this->death_date) ? $this->death_date->format('Y-m-d') : null, $this->death_place]);
        $this->id = $this->db->lastInsertId();
    }


    public function toArray()
    {
        return ['ID' => $this->id, 'Name' => $this->name, 'Surname' => $this->surname, 'Description' => $this->description, 'Birth_date' => date_format($this->birth_date, 'Y-m-d'), 'Birth_place' => $this->birth_place, 'Death_date' => date_format($this->death_date, 'Y-m-d'), 'Death-place' => $this->death_place];
    }
}