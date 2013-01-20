GITHUB-PHP-SDK

Create an instance of Github object 

$github = Github(array(
	'APP_ID'     => GITHUB_APP_ID,
	'APP_SECRET' => GITHUB_APP_SECRET
));

To get information about user
$github->getUser()

To get login url 
$github->getLoginUrl();

