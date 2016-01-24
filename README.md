# check_json
Nagios check script to read and alert from a json response

## Requires
Nothing special

## Setup
Download check_json zip file or clone it into your Nagios's libexec folder (might be /usr/local/nagios/libexec/), then
```$ php composer.phar install```
```$ php composer.phar dump-autoload -o```

## Usage
Nagios configuration:
```
define command {
        command_name    check_json
        command_line    /usr/bin/php $USER1$/check_json/check_json.php --url $ARG1$
}

define service {
        use                             generic-service
        host_name                       myhost
        service_description             my-service
        check_command                   check_json!https://my-site.com/checks/check-users-created.php
}
```

## JSON response
JSON retrieved must contain:
* status: string of nagios status ('OK', 'WARNING', 'CRITICAL')
* message: string of the message associated with the status

```
{
	"status": "WARNING",
	"message": "CHECK OK - 10 users created during the last hour"
}
```
