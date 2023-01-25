<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Playtime</title>
    <link rel=stylesheet href="./css/css.css">
</head>
<body>
    <div class="column" style="color:crimson">
        <h1>Command Injection</h1>
    </div>
    <div class="column" style="color:crimson">
        <form method=get action="level2.php">
            <div class="level">
            <label for="level">Select Level:</label>
            <select name="level" id="level">
                <option value="2" selected>Level 2</option>
            </select>
            </div>
            <div class="resp-textbox">
            <input type=text name=command placeholder="Enter Command Here" />
            </div>
            <div>
            <input type=submit value="Submit">
            </div>
        </form>
        --------------------------------------------------------- 

<?php
function check_input($input, $level){
    if (preg_match("/on.*=|javascript|script|img|svg|iframe|.*avascri.*|src|href|style/i", $input)){
        die("No XSS here plsssss!!!!");
    } 

    if (preg_match('/;/', $input))
        die("Hack detected");
    else return $input;
}

$command = $_GET['command'];
$level = $_GET['level'];

echo "<pre>";

echo "<b>Selected level:</b> Level $level \n";
echo "<b>Your input:</b> $command\n";
$command = check_input($command, $level);
echo "<b>[DEBUG]:</b> $command\n";

echo "</pre>";
?>
--------------------------------------------------------- 
    <h3>RESULT</h3>
<?php
echo "<pre>";

$command = "echo 'You have just input $command, hehehehe!\nYou will need more effort to get my flag bleeeeee!'";

passthru($command);
echo "</pre>";

include './setup_flag.php';
?>
    </div>
</body>

</html>