<?php
include 'header.php';
echo '<div align="center">';
echo '<p><form action="dashboard.php">';
echo '<button type="submit" style="width:524px; font-size:1.2em">Show Dashboard Of SkipDB</button>';
echo '</form></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<form action="insertshow.php">';
echo '<div><button type="submit">Insert TV Show Entry</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="deleteshow.php">';
echo '<div><button type="submit">Delete TV Show Entry</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="insertshowseason.php">';
echo '<div><button type="submit">Insert Season Entry For TV Show</button></div>';
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
echo '<form action="insertepisode.php">';
echo '<div><button type="submit">Insert Single Episode</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="delete.php">';
echo '<div><button type="submit">Delete Single Episode</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="insertmultipleepisodes.php">';
echo '<div><button type="submit">Insert Multiple Episodes</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="deletemultipleepisodes.php">';
echo '<div><button type="submit">Delete All Episodes Of A Season</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="update.php">';
echo '<div><button type="submit">Update Episode</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="listing.php">';
echo '<div><button type="submit">List All TV Shows</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<form action="importkodidb.php">';
echo '<div><button type="submit">Import Kodi DB</button></div>';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form action="tools.php">';
echo '<div><button type="submit">Tools</button></div>';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
include 'footer.php';
?>
