<?php


class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
    {
        if (DB::$db === null)
        {
            try
            {
                $hostname = 'rp2.studenti.math.hr';  // Provjerite je li ovo točan host
                $dbname = 'poljak';
                $username = 'student';
                $password = 'pass.mysql';
                $dsn = "mysql:host=$hostname;dbname=$dbname;charset=utf8";
                
                DB::$db = new PDO($dsn, $username, $password);
                DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                exit('PDO Error: ' . $e->getMessage());
            }
        }
        return DB::$db;
    }
}

?>
