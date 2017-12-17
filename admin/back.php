<?php
echo '<div align="center">';
echo '<table>';
echo '<tr>';
echo '<td>';
if (isset($_GET['ref'])) {
    echo '<form action="'.$_SERVER["HTTP_REFERER"].'">';
    echo '<button class="backbutton">Back</button>';
    echo '</form>';
}
else {
    echo '<form>';
    echo '<button onclick="goBack()" class="backbutton">Back</button>';
    echo '</form>';
}
echo '</td>';
echo '<td>';
echo '<form action="index.php">';
echo '<button type="submit">Home</button>';
echo '</form>';
echo '<td>';
echo '</tr>';
echo '<table>';
echo '</div>';
?>
