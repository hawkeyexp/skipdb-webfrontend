<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Mainmenu Update</h2></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<form action="updateepisode.php">';
echo '<div><button type="submit">Update Episode</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="updatemultipleepisodes.php">';
echo '<div><button type="submit">Update Multiple Episodes</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo '<div align="center">';
echo '<form action="index.php">';
echo '<div><button type="submit">Home</button></div>';
echo '</form>';
echo '</div>';
include 'footer.php';
?>
