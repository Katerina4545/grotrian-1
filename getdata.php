<?php
$errors = array();
if($_POST['ABBR'] == "")    $errors[] = "error!";
if($_POST['IONIZATION'] == "")   $errors[] = "error!";


if(empty($errors)){

    $new = $_POST['NEW'];

    if ($new == 0){
        echo 0;
    }
    else {
        $symbol = $_POST['ABBR'];
        $ion = $_POST['IONIZATION'];


        $url = "http://10.2.5.45/en/api/v1/periodic-table/search?ABBR=" . $symbol;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($returned, true);
        $array = $array[0];
        $id = $array["ID"];

        $url = "http://10.2.5.45/en/api/v1/atoms/search?ID_ELEMENT=" . $id . "&IONIZATION=" . $ion;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($returned, true);
        $array = $array[0];
        $id = $array["ID"];


        $url = "http://10.2.5.45/en/api/v1/atoms/" . $id . "?expand=levels,transitions";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);

        echo $returned;
    }
}
else{
// если были ошибки, то выводим их
    $msg_box = "";
    foreach($errors as $one_error){
        $msg_box .= "<span style='color: red;'>$one_error</span><br/>";
    }
    echo $msg_box;
}