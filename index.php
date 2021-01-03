<?php
include_once("handler/database.php");
include_once("inc/functions.php");

$messages = GetActiveMessages();
?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>The XYZ Network - Loading Screen</title>
    <meta name="description" content="The loading screen for The XYZ Network">
    <meta name="author" content="The XYZ Network">

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="center-screen">
        <img class="logo floating" src="assets/logo.png">
    </div>
    <div class="bottom-screen">
        <?php foreach($messages as $order => $message) { ?>
        <div id="content-<?= $order ?>"><img src="<?= GetAvatar($message['userid']) ?>" class="round"><a class="name" style="color: <?= htmlspecialchars(GetColour($message['userid'])) ?>"><?= htmlspecialchars(GetName($message['userid'])) ?></a>: <?= htmlspecialchars($message['message']) ?></div>
        <?php } ?>
    </div>

    <script>
        var divs = $('div[id^="content-"]').hide(),
            i = 0;
        (function cycle() {

            divs.eq(i).fadeIn(400)
                .delay(2000)
                .fadeOut(400, cycle);

            i = ++i % divs.length;

        })();
    </script>
</body>
</html>

