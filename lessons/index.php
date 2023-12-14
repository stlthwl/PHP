<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP</title>
</head>
<body>
<?php
    // массив
    $nums = array(1, 2, 3, 4, 5);
    $nums[0] = 10;
    echo $nums[0] . '<br>';

    // ассоциативный массив
    $arr = [
        'name' => 'Александр',
        'lastname' => 'Ефремов',
        'age' => 31
    ];
    echo "Возраст " . $arr['age'] . " год" . '<br>';

    /* Циклы
     * for
     */
//    цикл for
    $string = '';
    for($i = 1; $i <= 10; $i++) {
        if ($i != 10) {
            $string = $string . $i . ', ';
        }
        else
            $string = $string . $i;
    }
    echo "Цикл for, собираем числа от 1 до 10 в строку: $string" . "<br>";

//    foreach
    foreach ($arr as $item => $value) {
        echo "key: $item" . ' - ' . "value: $value" . "<br>";
    }
//  цикл while
    $n = 1;
    while ($n < 10) {
        echo '<br>Цикл while:';
        echo $n . '<br>';
        $n++;
    }
//  цикл do while

    $n = 10;
    do {
        echo "do while: " . $n . "<br>";
    } while($n < 1);

//  Функции
    echo "Функции:" . "<br>";
    echo "Длина массива 'arr':" . count($arr) . "<br>";

    // статическая переменная в функции
    function test_static() {
        static $x = 1;
        $x ++;
        return $x;
    }

    echo test_static() . "<br>";
    echo test_static() . "<br>";

?>
</body>
</html>
