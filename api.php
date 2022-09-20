<?php
$result_x = null;
$result_y = null;
$result_r = null;
$main_result = null;
$start = microtime(true);
$success = null;
function data_validate(): void {
    global $result_x;
    global $result_y;
    global $result_r;
    global $main_result;
    global $success;
    if (is_numeric($new_x = valid_X(@$_POST["x"])) && is_numeric($new_y = valid_Y(@$_POST["y"])) &&
        is_numeric($new_r = valid_R(@$_POST["R"]))) {
        if ($new_x < 0 && $new_y < 0) {
            $main_result = "нет (3я четверть)";
            $success = false;
        } elseif ($new_x <= 0 && 0 <= $new_y) {
            if ($new_y <= $new_x + $new_r/2) {
                $main_result = "да, точка попала в треугольник";
                $success = true;
            } else {
                $main_result = "нет, точка не попала в треугольник";
                $success = false;
            }
        } elseif ($new_x >= 0 && $new_y <= 0) {
            if ($new_x <= $new_r/2 && $new_y >= -$new_r) {
                $main_result = "да, точка попала в прямоугольник";
                $success = true;
            } else {
                $main_result = "нет, точка не попала в прямоугольник";
                $success = false;
            }
        } elseif ($new_x > 0 && $new_y > 0) {
            if (hypot($new_x, $new_y) <= $new_r/2) {
                $main_result = "да, точка попала в четверть круга";
                $success = true;
            } else {
                $main_result = "нет, точка не попала в четверть круга";
                $success = false;
            }
        }
        $result_x = $new_x;
        $result_y = $new_y;
        $result_r = $new_r;
    } else {
        $main_result = "данные некорректны";
    }
}

function valid_X($x): ?float{
    if (is_numeric($x)) {
        $new_x = floatval($x);
        if (-3 < $new_x && $new_x < 3) {
            return $new_x;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function valid_Y($y): ?int {
    if (in_array($y, ["-4", "-3", "-2", "-1", "0", "1", "2", "3", "4"])) {
        return intval($y);
    } else {
        return null;
    }
}

function valid_R($r): ?int {
    if (in_array($r, ["1", "2", "3", "4", "5"])) {
        return intval($r);
    } else {
        return null;
    }
}

data_validate();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["att"])) {
    $_SESSION["att"]=array();
}
if (sizeof($_SESSION["att"]) >= 10) {
    for ($i = 0; $i < 9; $i++){
        $_SESSION["att"][$i] = $_SESSION["att"][$i+1];
    }
}
$curr = array("data"=>date("j F, Y, g:i:s a"), "x"=>$result_x, "y"=>$result_y, "r"=>$result_r, "result"=>$main_result, "time"=>microtime(true) - $start);
$_SESSION["att"][] = $curr;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link rel="stylesheet" href="css/result.css">
</head>
<body>
    <div class="image">
        <?php
        if ($success == 1){
            echo "<img id='gif' src='pictures/кулачки.gif'>";
        } else {
            echo "<img id='gif' src='pictures/Со-Хён.gif'>";
        }
        ?>
    </div>
    <table class="result-table">
        <tr>
            <td>Дата</td>
            <td>X</td>
            <td>Y</td>
            <td>R</td>
            <td>Попадание</td>
            <td>Время обработки запроса</td>
        </tr>
        <?php
        $max=sizeof($_SESSION['att']);
        for($i=0; $i<$max; $i++) {
                echo "<tr>";
                echo "<td>" . $_SESSION['att'][$i]["data"] . "</td>";
                echo "<td>" . $_SESSION['att'][$i]["x"] . "</td>";
                echo "<td>" . $_SESSION['att'][$i]["y"] . "</td>";
                echo "<td>" . $_SESSION['att'][$i]["r"] . "</td>";
                echo "<td>" . $_SESSION['att'][$i]["result"] . "</td>";
                echo "<td>" . $_SESSION['att'][$i]["time"] . "</td>";
                echo "<tr>";
        }
        ?>
    </table>
<script src="validation.js"></script>
</body>
</html>