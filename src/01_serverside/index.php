<?php

$firstName = $_GET['nameone'];
$secondName = $_GET['nametwo'];
$loveIndex = calculateLoveIndex($firstName, $secondName);
$pictureValue = calculatePictureValue($loveIndex);
$renderedWelcomePage = renderWelcomePage($firstName, $secondName, $pictureValue);
$renderedBody = renderBody($renderedWelcomePage);
echo ($renderedBody);





function renderBody($content, $title = "Love Calculator")
{
    $template = <<<HTML
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$title</title>
        <link rel="stylesheet" href="./res/style.css">
    </head>
    <body>
        $content
    </body>
    </html>
    HTML;
    return $template;
}

function calculateLoveIndex($firstName, $secondName)
{
    $names = $firstName . $secondName;
    $loveIndex = 0;
    for ($i = 0; $i < strlen($names); $i++) {
        $currentChar = substr($names, $i, 1);
        $charValue = ord($currentChar);
        $loveIndex = $loveIndex + $charValue;
    }
    $loveIndex = $loveIndex % 100;
    $loveIndex = $loveIndex + 1;
    return $loveIndex;
}

function calculatePictureValue($loveIndex)
{
    $pictureValue = (($loveIndex / 20) + 1);
    $pictureValue = substr($pictureValue, 0, 1);
    return $pictureValue;
}

function renderWelcomePage($firstName, $secondName, $pictureValue)
{

    $template = <<<HTML
    <h1>Love Calculator</h1>
    <form method="GET" class="card" style="display: flex; flex-direction: column;">
        <label class="labels" for="nameone">Dein Name</label>
        <input name="nameone" value="$firstName" class="inputs" id="nameone" type="text">
        <label class="labels" for="nametwo">Dein Schwarm</label>
        <input name="nametwo" value="$secondName" class="inputs" id="nametwo" type="text">
        <button type="submit" class="buttons">Let's Match</button>
        <div>
        <img src="./res/smiley_$pictureValue.png">
        </div>
    </form>
    HTML;
    return $template;
}

function renderResultPicture($pictureValue)
{
    $template = <<<HTML
    <img src="./res/smiley_$pictureValue.png">
    HTML;
    return $template;
}
