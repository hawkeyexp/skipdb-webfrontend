<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Mainmenu Insert</h2></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<form action="insertshow.php">';
echo '<div><button type="submit">Insert TV Show Entry</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="insertshowseason.php">';
echo '<div><button type="submit">Insert Season Entry For TV Show</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="insertepisode.php">';
echo '<div><button type="submit">Insert Single Episode</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="insertmultipleepisodes.php">';
echo '<div><button type="submit">Insert Multiple Episodes</button></div>';
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