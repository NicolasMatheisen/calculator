<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numbers = ["0","1","2","3","4","5","6","7","8","9"];

    foreach ($numbers as $value) {
        if (isset($_POST[$value])) {
            echo $value;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles.css">
		<title>Taschenrechner</title>
	</head>
	<body>
		<main class="calculator">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">       
				<div class="display" id="display">0</div>

				<div class="calculatorKeys">
					<button class="button buttonFunction" type="submit" name="clear">AC</button>
					<button class="button buttonFunction" type="submit" name="negate">+/-</button>
					<button class="button buttonFunction" type="submit" name="percent">%</button>
					<button class="button buttonOperator" type="submit" name="divide">:</button>

					<button class="button buttonNumber" type="submit" name="7">7</button>
					<button class="button buttonNumber" type="submit" name="8">8</button>
					<button class="button buttonNumber" type="submit" name="9">9</button>
					<button class="button buttonOperator" type="submit" name="multiply">x</button>

					<button class="button buttonNumber" type="submit" name="4">4</button>
					<button class="button buttonNumber" type="submit" name="5">5</button>
					<button class="button buttonNumber" type="submit" name="6">6</button>
					<button class="button buttonOperator" type="submit" name="subtract">-</button>

					<button class="button buttonNumber" type="submit" name="1">1</button>
					<button class="button buttonNumber" type="submit" name="2">2</button>
					<button class="button buttonNumber" type="submit" name="3">3</button>
					<button class="button buttonOperator" type="submit" name="add">+</button>
					
					<button class="button buttonNumber large" type="submit" name="0">0</button>
					<button class="button buttonFunction" type="submit" name=",">,</button>
					<button class="button buttonFunction" type="submit" name="equals">=</button>	
				</div>
			</form>
		</main>
	</body>
</html>