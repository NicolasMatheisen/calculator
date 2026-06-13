<?php
    session_start();
	
	if (!isset($_SESSION["display"])) 
	{
    	$_SESSION["display"] = "0";
	}

   if (isset($_POST["number"])) 
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
	elseif (isset($_POST["action"])) 
	{
		$action = $_POST["action"];
		if ($action === "clear") 
		{
			$_SESSION["display"] = "0";
		}
		elseif ($action === "negate") 
		{
			if ($_SESSION["display"] !== "0") 
			{
				/* 
				strpos durchsucht den string und sucht die position in unserem fall das -
				Find the position of the first occurrence of "-" inside the string:
				0 überprüft die erste position wie in einem array[0] ob ein negation da ist wir wollen keine mehrfachen negationen wie zB -----5
				Bedingung ? AusdruckWennWahr : AusdruckWennFalsch;
				*/
                $_SESSION["display"] = (strpos($_SESSION["display"], "-") === 0)
                    ? substr($_SESSION["display"], 1)
                    : "-" . $_SESSION["display"];
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