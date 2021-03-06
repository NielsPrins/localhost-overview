<?php
include 'LocalhostOverview.php';
$oLocalhostOverview = new LocalhostOverview();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Localhost overview</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/assets/style.css">
    <link rel="icon" type="image/png" href="/assets/favicon.png"/>
</head>
<body>

<?php
if ( $oLocalhostOverview->hasPhpMyAdmin() ) {
	echo '<a class="php_my_admin_button" href="http://localhost/phpmyadmin/"><img src="assets/php_my_admin.ico" alt="phpMyAdmin"></a>';
}
?>

<div class="domain_links" style="grid-template-columns: repeat(<?php echo $oLocalhostOverview->getItemWidth(); ?>, 1fr);">
	<?php
	foreach ( $oLocalhostOverview->getWebsites() as $aData ) {

		echo '<a href="' . $aData[ 'url' ] . '">';

		if ( $aData[ 'favicon' ] ) {
			echo '<img src="' . $aData[ 'favicon' ] . '">';
		}

		echo $aData[ 'name' ];
		echo '</a>';
	}
	?>
</div>

</body>
</html>