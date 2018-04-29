<?php
    echo '<div align="center"><p class="new" style="height: auto; width: 536px;">You need to update you index.php for json interface!<br>It was downloaded as json.php to current folder.<br>Rename and place it as index.php!</p></div>';
    echo '<div align="center"><p class="new" style="height: auto; width: 536px;">Config.inc is updgraded!<br>Set again your login and server data!</p></div>';

    // migrate fieldnames of tables
    include 'inc/config.inc';

    $sql = "ALTER TABLE `episode` CHANGE `EPISODE` `EPISODE_NUMBER` INT(11) NOT NULL;";
    $ergebnis = mysqli_query($verbindung, $sql);

    $sql = "ALTER TABLE `season` CHANGE `SEASON` `SEASON_NUMBER` INT(11) NOT NULL;";
    $ergebnis = mysqli_query($verbindung, $sql);
?>
