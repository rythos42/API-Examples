<?php
require_once("../includes/clientService.php");

if (!isset($_POST['submit'])) {
	?>
	<!DOCTYPE html> 
	<html>
		<head>
			<title>List Class Descriptions Demo</title>
			<link rel="stylesheet" type="text/css" href="../styles/site.css" />
		</head>
		
		<body>
		<form method="post" action="SearchForClients.php">
			<div class="input-field">
				<label>Source Name:</label>
				<input type="text" size="25" name="sourceName" />
			</div>
			<div class="input-field">
				<label>Key:</label>
				<input type="password" size="25" name="key" />
			</div>
			<div class="input-field">
				<label>SiteID:</label>
				<input type="text" size="5" name="siteID" value="-99"/>
			</div>
			<div class="input-field">
				<label>User name:</label>
				<input type="text" size="25" name="userName" />
			</div>
			<div class="input-field">
				<label>Password:</label>
				<input type="text" size="25" name="password" />
			</div>
			<div class="input-field">
				<label>Search:</label>
				<input type="text" size="25" name="searchText" />
			</div>
			
			<input type="submit" name="submit" />
		</form>
	<?php
} else {
	$sourcename = $_POST["sourceName"];
	$key = $_POST["key"];
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$siteID = $_POST["siteID"];
	
	$searchText = $_POST["searchText"];

	$clientService = new MBClientService();

	$creds = new SourceCredentials($sourcename, $key, array($siteID));
	$clientService->SetDefaultCredentials($creds);
	
	$userCreds = new UserCredentials($userName, $password, array($siteID));
	$clientService->SetDefaultUserCredentials($userCreds);
	
	$result = $clientService->GetClientsBySearch($searchText);
	
	$cdsHtml = '<table><tr><td>ID</td><td>Name</td></tr>';
	$clients = toArray($result->GetClientsResult->Clients->Client);
	foreach ($clients as $client) {
		$cdsHtml .= sprintf('<tr><td>%d</td><td>%s</td></tr>', $client->ID, $client->FirstName . ' ' . $client->LastName);
	}
	$cdsHtml .= '</table>';
	echo $cdsHtml;
}
?>
	</body>
</html>