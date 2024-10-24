<?php
include 'autoload.php';

session_start();

if (isset($_POST['reset'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Zorg ervoor dat er een bord is opgeslagen in de sessie.
if (!isset($_SESSION['bord'])) {
    $_SESSION['bord'] = new Bord();
}

// Haal het bord op uit de sessie.
$bord = $_SESSION['bord'];

// Als een kaart is geklikt, update het bord.
if (isset($_GET['kaart'])) {
    $bord->klikOpKaart($_GET['kaart']);
    $_SESSION['bord'] = $bord;
}

// Als speler gewonnen heeft, dan geef een melding en stop de sessie.
if ($bord->isGewonnen()) {
    echo "<link rel='stylesheet' href='styles.css'>";
    echo '<body>';
    echo '<h2>Gefeliciteerd, je hebt gewonnen!</h2>';
    echo '<form method="post"><button type="submit" name="reset">Reset</button></form>';
    echo '</body>';
    session_destroy();
    exit();
}

?>

<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <table>
            <?php
                // Toon de kaarten met een link om te kiezen.
                foreach ($bord->getKaarten() as $index => $kaart) {
                    if ($index % 4 == 0)
                        echo '<tr>';

                    $klasse = $kaart->isOmgedraaid() ? 'kaart-actief' : '';
                    $waarde = $kaart->isOmgedraaid() ? $kaart->getWaarde() : '?';
                    echo "<td class='$klasse'><a href='?kaart=$index'>$waarde</a></td>";

                    if ($index % 4 == 3)
                        echo '</tr>';
                }
            ?>
        </table>


        <form method="post">
            <button type="submit" name="reset">Reset het spel</button>
        </form>
    </div>
</body>

</html>