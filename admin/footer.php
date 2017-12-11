<?php
$version = file('version.php')[0];
echo '<div align="center">';
echo '<p><div class="info">Created by Marc Hillesheim (c) 2017 - Version: '.$version.'</div></p>';
echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">';
echo '<input type="hidden" name="cmd" value="_s-xclick">';
echo '<input type="hidden" name="hosted_button_id" value="N7W7WET3MTTK4">';
echo '<input type="image" src="img/paypal.png" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">';
echo '<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">';
echo '</form>';
echo '</div>';
echo '</body>';
echo '</html>';
?>
