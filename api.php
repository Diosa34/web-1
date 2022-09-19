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
//    if (($x = @$_POST["x"]) != null && ($y = @$_POST["y"]) != null && ($r = @$_POST["R"]) != null) {
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
//    }
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

class History extends SQLite3 {
    public function __construct()
    {
        parent::__construct("history.sqlite");
    }

    function create_table() {
        date_default_timezone_set('Europe/Moscow');
        $this->prepare(
                "CREATE TABLE IF NOT EXISTS hits(date TEXT, x REAL, y REAL, r REAL, result TEXT, time TEXT)"
        )->execute();
    }

    function insert($x, $y, $r, $result, $start) {
        $statement = $this->prepare(
            "INSERT INTO hits VALUES (:date, :x, :y, :r, :result, :time)"
        );
        $statement->bindValue(":date", date("j F, Y, g:i:s a"));
        $statement->bindValue(":x", $x);
        $statement->bindValue(":y", $y);
        $statement->bindValue(":r", $r);
        $statement->bindValue(":result", $result);
        $statement->bindValue(":time", microtime(true) - $start);
        $statement->execute();
    }

    function select_row($count): array {
        $statement = $this->prepare(
            "SELECT * FROM hits ORDER BY date DESC LIMIT :count"
        );
        $statement->bindValue(":count", $count);
        $answer = $statement->execute();
        $result_table = array();
        while ($row = $answer->fetchArray()) {
            $result_table[] = $row;
        }
        return $result_table;
    }
}
$number_of_records = 10;
data_validate();
$history = new History();
$history->create_table();
$history->insert($result_x, $result_y, $result_r, $main_result, $start);
$history_table = $history->select_row($number_of_records);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <link rel="stylesheet" href="result.css">
</head>
<body>
    <div class="image">
        <?php
        if ($success == 1){
            echo "<img id='gif' src='кулачки.gif'>";
        } else {
            echo "<img id='gif' src='Со-Хён.gif'>";
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
            if (count($history_table) < 10) {
                $number_of_records = count($history_table);
            }
            for ($i = 0; $i < $number_of_records; $i++) {
                echo "<tr>";
                echo "<td>" . $history_table[$i]["date"] . "</td>";
                echo "<td>" . $history_table[$i]["x"] . "</td>";
                echo "<td>" . $history_table[$i]["y"] . "</td>";
                echo "<td>" . $history_table[$i]["r"] . "</td>";
                echo "<td>" . $history_table[$i]["result"] . "</td>";
                echo "<td>" . $history_table[$i]["time"] . "</td>";
                echo "<tr>";
            }
        ?>
    </table>
<script src="validation.js"></script>
</body>
</html>