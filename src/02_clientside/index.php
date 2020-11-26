<?php

if (isset($_GET['n1']) && isset($_GET['n2'])) {
    if (isset($_GET['submit']) && $_GET['submit'] === 'calc') {
        $firstNameVar = $_GET['n1'];
        $lastNameVar = $_GET['n2'];
        $loveIndex = calculateLoveIndex($firstNameVar, $lastNameVar);
        $renderedWelcomeScreen = renderWelcomePage($firstNameVar, $lastNameVar, $loveIndex);
        $renderedBody = renderBody($renderedWelcomeScreen);
        echo ($renderedBody);
    } elseif (isset($_GET['submit']) && $_GET['submit'] === 'save') {
        $nameOne = $_GET['n1'];
        $nameTwo = $_GET['n2'];

        if (isValid($nameOne) && isValid($nameTwo)) {
            $connection = mysqli_connect('localhost', 'root', '', 'lovecalculator');
            $connection->set_charset("utf8");;
            $stmt = $connection->prepare('INSERT INTO matches(name_one, name_two) VALUES (?, ?)');
            $stmt->bind_param('ss', $nameOne, $nameTwo);
            $stmt->execute();
            if ($stmt->affected_rows !== 1) {
                header('location: /02_clientside/index.php');
            } else {
                header('location: /02_clientside/index.php?n1=' . $nameOne . '&n2=' . $nameTwo);
            }
        } else {
            http_response_code(400);
        }
    } else {
        $renderedWelcomeScreen = renderWelcomePage();
        $renderedBody = renderBody($renderedWelcomeScreen);
        echo ($renderedBody);
    }
} else {
    $renderedWelcomeScreen = renderWelcomePage();
    $renderedBody = renderBody($renderedWelcomeScreen);
    echo ($renderedBody);
}

function calculateLoveIndex($n1, $n2)
{
    $loveIndex = 0;
    $names = $n1 . $n2;
    for ($i = 0; $i < strlen($names); $i++) {
        $currentChar = substr($names, $i, 1);
        $charValue = ord($currentChar);
        $loveIndex += $charValue;
    }
    $loveIndex = $loveIndex % 100;
    $loveIndex++;
    return $loveIndex;
}

function renderBody($content)
{
    $template = <<<HTML
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Love Calculator</title>
        <link rel="stylesheet" href="./res/style.css">
    </head>
    <body class="body-style">
        $content
    </body>
    </html>
    HTML;
    return $template;
}

function renderWelcomePage($firstNameVar = '', $lastNameVar = '', $loveIndex = null)
{
    if ($loveIndex === null) {
        $loveIndex = '';
    } else {
        $val = (($loveIndex / 20) + 1);
        $val = substr($val, 0, 1);
        $loveIndex = <<<HTML
        <div style="display: flex; flex-direction: column;">
            <img class="small" src="./res/smiley_$val.png">
            <div style="text-align: center;">$loveIndex %</div>
        </div>
        HTML;
    }

    $template = <<<HTML
    <h1 class="header">Welcome to the LoveCalculator</h1>
    <form id="form" action="index.php" method="GET" class="card">
        <div>
            <div style="display: flex; flex-direction: column;">
                <label class="labels" for="firstName">
                    Dein Name
                </label>
                <input class="inputs" name="n1" value="$firstNameVar" id="firstName" type="text">
            </div>
            <div style="display: flex; flex-direction: column;">
                <label class="labels" for="belovedName">
                    Dein Schwarm
                </label>
                <input class="inputs" name="n2" value="$lastNameVar" id="belovedName" type="text">
            </div>
        </div>
        <div style="display: flex; flex-direction: row; justify-content: space-around; margin-top: 20px;">
            $loveIndex
        </div>
        <div style="display: flex; flex-direction: row; justify-content: space-around; margin-top: 20px;">
            <button name="submit" value="calc" class="buttons" type="submit">Lets Match</button>
            <button class="buttons" type="reset">Reset</button>
            <button name="submit" value="save" class="buttons" type="submit">Save</button>
            <a class="buttons" href="/02_clientside/matches.html">Zu den Ergebnissen</a>
        </div>
    </form>
    HTML;
    return $template;
}

function isValid($value)
{
    return is_string($value) && (strlen($value) >= 3);
}
