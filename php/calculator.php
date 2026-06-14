<?php
session_start();

	if (!isset($_SESSION["display"])) 
	{
		$_SESSION["display"] = "0";
	}

	if (isset($_POST["number"])) 
		{
		if (!empty($_SESSION["waitingForSecond"]) && $_SESSION["waitingForSecond"] === true) 
		{
			$_SESSION["display"] = $_POST["number"];
			$_SESSION["waitingForSecond"] = false;
		} 
		else 
		{
			if ($_SESSION["display"] === "0") 
			{
				$_SESSION["display"] = $_POST["number"];
			} 
			else 
			{
				$_SESSION["display"] .= $_POST["number"];
			}
		}
	}
	elseif (isset($_POST["action"])) 
		{
		$action = $_POST["action"];

		if ($action === "clear") 
		{
			$_SESSION["display"] = "0";
			unset($_SESSION["result"], $_SESSION["operator"], $_SESSION["operatorSymbol"], $_SESSION["waitingForSecond"]);
		}
		elseif ($action === "negate") 
		{
			if ($_SESSION["display"] !== "0") 
			{
				/* 
				strpos durchsucht den string und sucht die position in unserem fall wo das - liegt
				Find the position of the first occurrence of "-" inside the string:
				0 überprüft die erste position wie in einem array[0] ob eine negation da ist, wir wollen keine mehrfachen negationen wie zB -----5
				Bedingung ? AusdruckWennWahr : AusdruckWennFalsch;
				*/
				
				$_SESSION["display"] = (strpos($_SESSION["display"], "-") === 0)
					? substr($_SESSION["display"], 1)
					: "-" . $_SESSION["display"];
			}
		}
		elseif ($action === ",") 
		{
			if (strpos($_SESSION["display"], ",") === false) 
			{
				$_SESSION["display"] .= ",";
			}
		}
		elseif ($action === "percent") 
		{
			$float = str_replace(",", ".", $_SESSION["display"]);

			/*
				^: Anfang des Ausdrucks
				-?: optional: evtl eine negative Zahl
				\d+: mindestens eine GanzZahl oder mehrere 0-9
				(\.\d+)?: die Klammer präsentieren eine Gruppe und das ? sagt dass diese wieder nur optional ist
					\.: das bedeuted dass der . als Zeichen dort ist
					\d+: mindestens eine GanzZahl oder mehrere 0-9
				$: Ende des Ausdrucks
			*/

			if (preg_match("/^-?\d+(\.\d+)?$/", $float)) 
			{
				$result = floatval($float) / 100.0;
				$_SESSION["display"] = str_replace(".", ",", (string)$result);
			}
		}
		elseif (in_array($action, ["add", "subtract", "multiply", "divide"])) 
		{
			$_SESSION["result"] = $_SESSION["display"];
			$_SESSION["operator"] = $action;

			$symbols = 
			[
				"add" => "+",
				"subtract" => "-",
				"multiply" => "×",
				"divide" => ":"
			];
			$_SESSION["operatorSymbol"] = $symbols[$action];

			$_SESSION["display"] = $_SESSION["result"] . " " . $_SESSION["operatorSymbol"];
			$_SESSION["waitingForSecond"] = true;
		}
		elseif ($action === "equals") 
		{
			if (isset($_SESSION["result"]) && isset($_SESSION["operator"])) 
			{
				$firstNumber = floatval(str_replace(",", ".", $_SESSION["result"]));
				$secondNumber = floatval(str_replace(",", ".", $_SESSION["display"]));

				switch ($_SESSION["operator"]) 
				{
					case "add":
						$result = $firstNumber + $secondNumber;
						break;
					case "subtract":
						$result = $firstNumber - $secondNumber;
						break;
					case "multiply":
						$result = $firstNumber * $secondNumber;
						break;
					case "divide":
						if ($secondNumber == 0) 
						{
							$result = "Division durch 0 ist nicht erlaubt!";
						} 
						else 
						{
							$result = $firstNumber / $secondNumber;
						}
						break;
				}

				$_SESSION["display"] = str_replace(".", ",", (string)$result);
				unset($_SESSION["result"], $_SESSION["operator"], $_SESSION["operatorSymbol"], $_SESSION["waitingForSecond"]);
			}
		}
	}

$display = $_SESSION["display"];
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
			<form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">   

				<div class="display" id="display">
					<?php echo $display; ?>
				</div>

				<div class="calculatorKeys">
					<button class="button buttonFunction" type="submit" name="action" value="clear">AC</button>
                    <button class="button buttonFunction" type="submit" name="action" value="negate">+/-</button>
                    <button class="button buttonFunction" type="submit" name="action" value="percent">%</button>
                    <button class="button buttonOperator" type="submit" name="action" value="divide">:</button>

                    <button class="button buttonNumber" type="submit" name="number" value="7">7</button>
                    <button class="button buttonNumber" type="submit" name="number" value="8">8</button>
                    <button class="button buttonNumber" type="submit" name="number" value="9">9</button>
                    <button class="button buttonOperator" type="submit" name="action" value="multiply">x</button>

                    <button class="button buttonNumber" type="submit" name="number" value="4">4</button>
                    <button class="button buttonNumber" type="submit" name="number" value="5">5</button>
                    <button class="button buttonNumber" type="submit" name="number" value="6">6</button>
                    <button class="button buttonOperator" type="submit" name="action" value="subtract">-</button>

                    <button class="button buttonNumber" type="submit" name="number" value="1">1</button>
                    <button class="button buttonNumber" type="submit" name="number" value="2">2</button>
                    <button class="button buttonNumber" type="submit" name="number" value="3">3</button>
                    <button class="button buttonOperator" type="submit" name="action" value="add">+</button>
                    
                    <button class="button buttonNumber large" type="submit" name="number" value="0">0</button>
                    <button class="button buttonFunction" type="submit" name="action" value=",">,</button>
                    <button class="button buttonFunction" type="submit" name="action" value="equals">=</button> 
				</div>
			</form>
		</main>
	</body>
</html>