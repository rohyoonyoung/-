<?php

    error_reporting(E_ALL); 
    ini_set('display_errors',1);

    include('dbcon.php');


    $stmt = $con->prepare('select * from book');
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array();

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            array_push($data,
                array('id'=>$id,
                'title'=>$title,
                'author'=>$author
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("user1"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>
