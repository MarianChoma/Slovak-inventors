<?php
require_once "MyPdo.php";

class Invention
{
    /* @var MyPDO */
    protected $db;

    protected int $id;
    protected string $inventor_id;
    protected ?DateTime $invention_date=null;
    protected string $description;

    public function __construct()
    {
        $this->db = MyPDO::instance();
    }

    /**
     * @return string
     */
    public function getInventorId(): string
    {
        return $this->inventor_id;
    }

    /**
     * @param string $inventor_id
     */
    public function setInventorId(string $inventor_id): void
    {
        $this->inventor_id = $inventor_id;
    }

    /**
     * @return DateTime
     */
    public function getInventionDate(): DateTime
    {
        return $this->invention_date;
    }

    /**
     * @param DateTime $invention_date
     */
    public function setInventionDate(string $invention_date): void
    {

        if(str_contains($invention_date, '-')) {
            $this->invention_date = DateTime::createFromFormat('Y-m-d', $invention_date);
        }
        else if(str_contains($invention_date, '.')){
            $this->invention_date = DateTime::createFromFormat('d.m.Y', $invention_date);
        }
        else if($invention_date!=""){
            $this->invention_date = DateTime::createFromFormat('Y', $invention_date);
        }
        else{
            $this->invention_date=null;
        }
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    public function save()
    {
        var_dump($this->invention_date);
        $this->db->run("INSERT into Inventions 
            (`Inventor_id`, `Invention_date`, `description`) values (?, ?, ?)",
            [$this->inventor_id, isset($this->invention_date) ? $this->invention_date->format("Y-m-d") : null, $this->description]);
        $this->id = $this->db->lastInsertId();
    }
    public static function findByCentury($century){
        return MyPDO::instance()->run("SELECT * FROM Inventions WHERE (SUBSTRING((EXTRACT(YEAR FROM(Invention_date))-1),1,2))+1=?;", [$century])->fetchAll();
    }

    public static function findByYear($year){
        $data= MyPDO::instance()->run("SELECT * FROM Inventions WHERE YEAR(Invention_date)=?;", [$year])->fetchAll();
        $data1= MyPDO::instance()->run("SELECT * FROM Inventors WHERE YEAR(Birth_date)=?;", [$year])->fetchAll();
        $data2= MyPDO::instance()->run("SELECT * FROM Inventors WHERE YEAR(Death_date)=?;", [$year])->fetchAll();

        return ["inventions"=>$data, "birth"=>$data1, "death"=>$data2];
    }
}