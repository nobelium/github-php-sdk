Github-php-sdk
==============

> A minimalistic sdk for [Github](http://developer.github.com/v3/) v3 api

Usage:
-----
To use the github api inclue the source file

```require_once ('github.php');```

create an object of github class 

```
$github = Github(array( 'APP_ID' => GITHUB_APP_ID, 
                        'APP_SECRET' => GITHUB_APP_SECRET,
                        'SCOPE' => SCOPE(comma seperated values, defaults to 'repo')[optional],
                        'REDIRECT_URI' => REDIRECT_URL[optional],
                ));             
```

To generate the login url for users, call the getLoginUrl method

```$url = $github->getLoginUrl();```

To get user info, call the getUser method

```$user = $github->getUser();```

Use the api method to make api calls

```$data = $github->api("\path", 'GET/POST', 'get parameters as hashmap', 'post paramenters as hashmap[optional]');```

###Useful Stuff###
You can directly set the access token using setAccessToken method

```$github->setAccessToken(<access_token>);```

app secret/app id can be changed after creation using 'setAppSecret' and 'setAppId'

Get methods of the above are also available

####Contributing####

If you find a bug or interested in working on a new feature contact me or just open a pull request.