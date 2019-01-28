<?php

class Database{
    protected const DB_SERVER   = 'localhost';
    protected const DB_USER     = 'root';
    protected const DB_PASSWORD = '';
    protected const DB_NAME     = 'demo';
    
    protected const SHOW_ERRORS = true;

    protected $dbh;


    /**
     * @param $text
     * @return mixed
     */
    public function test($text)
    {
        echo $text;
        return $text;
    }


    public function __construct(){
        $dsn= 'mysql:dbname='.self::DB_NAME.';host='.self::DB_SERVER.';charset=utf8';
        $attributes = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        try {
            $this->dbh = new PDO($dsn, self::DB_USER, self::DB_PASSWORD, $attributes);
        } catch (Exception $e) {
            echo "Unable to connect to DB: " . $e->getMessage();
            exit;
        }
    }
    
    /**
     * Get all products from db
     * @return mixed[][]
     */
    public function getProducts() {
        $sql = "SELECT * FROM products";
        return $this->fetchAll($sql);
    }


    /**
    * Get a single products from db based on id
    * @param $id
     * @return mixed[]
     */
    public function getProduct($id) {
        $sql = "SELECT * FROM products WHERE id=?";
        return $this->fetch($sql, [$id]);
    }
    
    /**
     * Migrerar tabellerna i databasen, alltså dödar dem och skapar dem igen
     * @return bool
     */
    public function migrateDatabase(){
        $sql = "    drop table if exists products;
                    create table products(
                        id int auto_increment,
                        name varchar(255) not null,
                        price int,
                        primary key(id)
                    );";
        return $this->runQuery($sql);
    }
    
    /**
     * Seedar, alltså fyller tabellerna med testdata
     * Kan gärna göras med Faker
     * @return bool
     */
    public function seedDatabase(){
        $sql = "
            truncate table products;
            insert into products values(null,'Kulting',40);
            insert into products values(null,'Bagge',null);
                    ";
        return $this->runQuery($sql);
    }
    
    /**
     * Kör sql som inte ska ge någon data tillbaka
     * @param string $sql
     * @param bool $showErrors Optional
     * @return bool
     */
    public function runQuery($sql){
        try {
            $stmt = $this->dbh->prepare($sql);    
            $stmt->execute();
            return true;
        } catch (Exception $e){
            if(SHOW_ERRORS){
                echo $e->getMessage();
                exit;
            }
            return false;
        }
    }
    
    /**
     * @param string $sql
     * @param mixed[] $params Indexerad array med bundna parametrar
     * @return mixed[]
     */
    public function fetch($sql, $params){
        try {
            $stmt = $this->dbh->prepare($sql);    
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (Exception $e){
            if(SHOW_ERRORS){
                echo $e->getMessage();
                exit;
            }
            return false;
        }
    }

    /**
     * @param string $sql
     * @return mixed[][]
     */
    public function fetchAll($sql){
        try {
            $stmt = $this->dbh->prepare($sql);    
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e){
            if(SHOW_ERRORS){
                echo $e->getMessage();
                exit;
            }
            return false;
        }
    }

    
}