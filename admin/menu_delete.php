<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Mainmenu Delete</h2></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<form action="deleteshow.php">';
echo '<div><button type="submit">Delete TV Show Entry</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="deleteshowseason.php">';
echo '<div><button type="submit">Delete Season Entry For TV Show</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="deleteepisode.php">';
echo '<div><button type="submit">Delete Single Episode</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="deletemultipleepisodes.php">';
echo '<div><button type="submit">Delete All Episodes Of A Season</button></div>';
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