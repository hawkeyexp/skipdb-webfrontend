<?php
if (isset($_GET['url'])){

    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Check JSON Interface Of SkipDB</h2></p>';
    echo '<div class="info">Result</div><p>';

    $url = $_GET['url'];
    $request = '/index.php?title=test&season=test&episode=test';
    $completeurl = $url.$request;

    $arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
        	"verify_peer_name"=>false,
	),
    );

    $response = file_get_contents($completeurl, false, stream_context_create($arrContextOptions));
    $result = json_decode($response);

    if (($result->{'title'} == "test") and ($result->{'season'} == "test") and ($result->{'episode'} == "test")) {
	echo '<div class="desc">Check OK!</div><p>';
    }
    else {
	echo '<div class="del">Check FAILED!</div><p>';
    }
    echo '</div>';
    include 'backtools.php';
    include 'footer.php';
}
else {
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Check JSON Interface Of SkipDB</h2></p>';
    echo '<form action="checkjson.php" method="get">';
    echo '<div class="desc"><label>Server URL</label></div><div><input type="text" name="url" /></div>';
    echo '<p><input type="submit" value="Test Now!" class="riskybutton"></p>';
    echo '</form>';
    echo '</div>';
    include 'backtools.php';
    include 'footer.php';
}
?>
