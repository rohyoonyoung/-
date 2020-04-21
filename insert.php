<?php

    error_reporting(E_ALL);
    ini_set('display_errors',1);

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.

        $title=$_POST['title'];
        $author=$_POST['author'];

        if(empty($title)){
            $errMSG = "책 제목을 입력하세요.";
        }
        else if(empty($author)){
            $errMSG = "작가명을 입력하세요.";
        }

        if(!isset($errMSG)) // 이름과 나라 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 book 테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO book(title, author) VALUES(:title, :author)');
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':author', $author);


                // SQL 실행 결과를 위한 메시지를 생성
                if($stmt->execute())
                {
                    $successMSG = "새로운 도서를 추가했습니다.";
                }
                else
                {
                    $errMSG = "도서 추가 에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }

    }

?>


<?php
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Title: <input type = "text" name = "title" />
                Author: <input type = "text" name = "author" />
                <input type = "submit" name = "submit" />
            </form>

       </body>
    </html>

<?php
    }
?>
