<?php
    $result_x = null;
    $result_y = null;
    $result_r = null;
    $main_result = null;
    function data_validate(): void
    {
        global $result_x;
        global $result_y;
        global $result_r;
        global $main_result;
        if (($x = @$_POST["x"]) != null && ($y = @$_POST["y"]) != null && ($r = @$_POST["R"]) != null) {
            if (($new_x = valid_X($x)) != null && ($new_y = valid_Y($y)) != null && ($new_r = valid_R($r)) != null) {
                if ($new_x < 0 && $new_y < 0) {
                    $main_result = "нет (3я четверть)";
                } elseif ($new_x < 0 && 0 < $new_y) {
                    if ($new_y < $new_x + $new_r/2) {
                        $main_result = "да, точка попала в треугольник";
                    } else {
                        $main_result = "нет, точнка не попала в треугольник";
                    }
                } elseif ($new_x > 0 && $new_y < 0) {
                    if ($new_x < $new_r/2 && $new_y > -$r) {
                        $main_result = "да, точка попала в прямоугольник";
                    } else {
                        $main_result = "нет, точка не попала в прямоугольник";
                    }
                } elseif ($new_x > 0 && $new_y > 0) {
                    if (hypot($new_x, $new_y) < $new_r/2) {
                        $main_result = "да, точка попала в четверть круга";
                    } else {
                        $main_result = "нет, точка не попала в четверть круга";
                    }
                }
                $result_x = $new_x;
                $result_y = $new_y;
                $result_r = $new_r;
            }
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
<table>
    <tr>
        <td colspan="2">
            Осокина Мария Юрьевна<br>
            P32091<br>
            1313<br>
        </td>
    </tr>
    <tr>
        <td class="graphic">
                <svg viewBox="0 0 600 600" width="300px" height="300px">
                    <path d="M 300 300
             L 200 300
             L 300 200
             A 100 100 0 0 1 400 300
             L 400 500
             L 300 500" fill="rgb(51, 153, 255)"></path>
                    <line x1="300" y1="0" x2="300" y2="600" stroke="black" stroke-width="3"></line>
                    <line x1="0" y1="300" x2="600" y2="300" stroke="black" stroke-width="3"></line>
                    <line x1="100" y1="295" x2="100" y2="305" stroke="black" stroke-width="3"></line>
                    <text x="90" y="290">-R</text>
                    <line x1="200" y1="295" x2="200" y2="305" stroke="black" stroke-width="3"></line>
                    <text x="190" y="290">-R/2</text>
                    <line x1="400" y1="295" x2="400" y2="305" stroke="black" stroke-width="3"></line>
                    <text x="390" y="290">R/2</text>
                    <line x1="500" y1="295" x2="500" y2="305" stroke="black" stroke-width="3"></line>
                    <text x="490" y="290">R</text>
                    <line x1="295" y1="100" x2="305" y2="100" stroke="black" stroke-width="3"></line>
                    <text x="310" y="105">R</text>
                    <line x1="295" y1="200" x2="305" y2="200" stroke="black" stroke-width="3"></line>
                    <text x="310" y="205">R/2</text>
                    <line x1="295" y1="400" x2="305" y2="400" stroke="black" stroke-width="3"></line>
                    <text x="310" y="405">-R/2</text>
                    <line x1="295" y1="500" x2="305" y2="500" stroke="black" stroke-width="3"></line>
                    <text x="310" y="505">-R</text>
                    <text x="315" y="10">y</text>
                    <text x="585" y="285">x</text>
                    <polygon points="290,10 300,0 310,10" fill="black"></polygon>
                    <polygon points="590,290 600,300 590,310" fill="black"></polygon>

                </svg>
                <br>
                <form method="post" action="#">
                    X:
                    <label><input type="text" oninput="validationX()" id="x" name="x"></label>
                    <span id="x-warning" style="display: none"></span>
                    <br>
                    Y:
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch-4" name="y" value="-4"> -4</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch-3" name="y" value="-3"> -3</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch-2" name="y" value="-2"> -2</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch-1" name="y" value="-1"> -1</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch0" name="y" value="0"> 0</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch1" name="y" value="1"> 1</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch2" name="y" value="2"> 2</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch3" name="y" value="3"> 3</label>
                    <label><input type="checkbox" oninput="checkboxVal(this)" id="ch4" name="y" value="4"> 4</label>
                    <br>
                    R:
                    <button type="button" id="btn1" disabled onclick="rChoose(this)" value="1">1</button>
                    <button type="button" id="btn2" disabled onclick="rChoose(this)" value="2">2</button>
                    <button type="button" id="btn3" disabled onclick="rChoose(this)" value="3">3</button>
                    <button type="button" id="btn4" disabled onclick="rChoose(this)" value="4">4</button>
                    <button type="button" id="btn5" disabled onclick="rChoose(this)" value="5">5</button>
                    <input type="hidden" name="R" id="chosen-button">
                    <br>
                    <input id="submit" type="submit">
                </form>
        </td>
        <td>
            <table class="result-table">
                <tr>
                    <td>X</td>
                    <td>Y</td>
                    <td>R</td>
                    <td>Попадание</td>
                </tr>
                <tr>
                    <td><?=$result_x?></td>
                    <td><?=$result_y?></td>
                    <td><?=$result_r?></td>
                    <td><?=$main_result?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script src="validation.js"></script>
</body>
</html>