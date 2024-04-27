<?

    global $database;

    require __DIR__ . '/vendor/autoload.php';
 
    // Using Medoo namespace
    use Medoo\Medoo;

    try {
        $pdo = new PDO('mysql:dbname=DB_NAME;host=localhost', 'DB_USR', 'DB_PWD');
    } catch (PDOException $e) {
        // throw new Exception ($e->getMessage());
        die('Database Connection failed');
    }
    $database = new Medoo([
        // Initialized and connected PDO object
        'pdo' => $pdo,
    
        // [optional] Medoo will have different handle method according to different database type
        'database_type' => 'mysql'
        //"logging" => true
    ]);

?>