<?php
    require_once 'includes/application_top.php';
    use Site\Base\Collection;

    //$thing = Database::getInstance();
    //echo $thing->sayHi();
    //echo ArrayTools::sayHi();
    $thing = new Collection();

    $choice = $thing->getNth(1);
    echo var_dump($choice);


    echo '<p>Welcome Home</p>';

    /**public static function sayHi(): string
    {
        return '<p>Hello World Array</p>';
    } */
?>