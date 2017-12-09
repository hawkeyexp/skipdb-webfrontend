<?php
ini_set('max_execution_time',60);
$updated = false;
$found = false;
$version = file('version.php')[0];

include 'header.php';

echo '<h2>DYNAMIC UPDATE SYSTEM</h1>';
echo '<div align="center">';
//Check For An Update
$getVersions = file_get_contents('https://raw.githubusercontent.com/hawkeyexp/skipdb-webfrontend/master/updater/current-release-versions.php') or die ('ERROR');
if ($getVersions != '')
{
	echo '<p><div class="info">CURRENT VERSION: '.$version.'</div></p>';
	echo '<p><div class="info">Reading Current Releases List</div></p>';
	$versionList = explode("\n", $getVersions);
	foreach ($versionList as $aV)
	{
		if ( $aV > $version) {
			echo '<p><div class="new">New Update Found: v'.$aV.'</div></p>';
			$found = true;
			
			//Download The File If We Do Not Have It
			if ( !is_file( './UPDATES/skipdb-admin-'.$aV.'.zip' )) {
				echo '<p><div class="info">Downloading New Update</div></p>';
				$newUpdate = file_get_contents('https://raw.githubusercontent.com/hawkeyexp/skipdb-webfrontend/master/updater/skipdb-admin-'.$aV.'.zip');
				if ( !is_dir( './UPDATES/' ) ) mkdir ( './UPDATES/' );
				$dlHandler = fopen('./UPDATES/skipdb-admin-'.$aV.'.zip', 'w');
				if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
				fclose($dlHandler);
				echo '<p><div class="new">Update Downloaded And Saved</div></p>';
			} else echo '<p><div class="info">Update already downloaded.</div></p>';

			if (isset($_GET['doUpdate'])) {
			    $doUpdate = $_GET['doUpdate'];
			}
			else {
			    $doUpdate = false;
			    $updated = false;
			}
			if ($doUpdate == true) {
				//Open The File And Do Stuff
				$zipHandle = zip_open('./UPDATES/skipdb-admin-'.$aV.'.zip');
				echo '<div class="info" style="height: auto;">';
				while ($aF = zip_read($zipHandle) ) 
				{
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					
					//Continue if its not a file
					if ( substr($thisFileName,-1,1) == '/') continue;
					
	
					//Make the directory if we need to...
					if ( !is_dir ( './'.$thisFileDir ) )
					{
						 mkdir ( './'.$thisFileDir );
						 echo '<p>Created Directory '.$thisFileDir.'</p>';
					}
					
					//Overwrite the file
					if ( !is_dir('/'.$thisFileName) ) {
						echo '<p>'.$thisFileName.'...........';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						if ( strpos($thisFileName,'.png' == false) ) {
						    $contents = str_replace("\r\n", "\n", $contents);
						}
						$updateThis = '';
						
						//If we need to run commands, then do it.
						if ( $thisFileName == 'upgrade.php' )
						{
							$upgradeExec = fopen ('upgrade.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include ('upgrade.php');
							unlink('upgrade.php');
							echo' EXECUTED</p>';
						}
						else
						{
							$updateThis = fopen('./'.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
							echo' UPDATED</p>';
						}
					}
				}
				echo '</div><p>';
				$updated = true;
			}
			else {
			    echo '<form action="updater.php">';
			    echo '<input type="hidden" name="doUpdate" value="true"/>';
			    echo '<p><button type="submit" style="width: 524px;">Update ready. Install Now?</button></p>';
			    echo '</form>';
			}
			break;
		}
	}
	
	if ($updated == true) {
	    $version = file('version.php')[0];
	    echo '<p class="new">SkipDB Updated to version '.$version.'</p><p>';
	}
	else if ($found != true) echo '<p class="info">No update is available</p><p>';

	
}
else echo '<p>Could not find latest realeases.</p>';

echo '<form action="tools.php">';
echo '<div><button type="submit">Back</button></div>';
echo '</form>';
echo '</div>';
include 'footer.php';
?>
