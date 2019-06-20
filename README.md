# SilverStripe Foxy API

An addon module for SilverStripe Foxy that adds API functionality with Foxy.io

## Requirements

* SilverStripe ^4.0
* dynamic/silverstripe-foxy ^1.0

## Installation
 

```
composer require dynamic/silverstripe-foxy-api ^1.0
```


## License

See [License](license.md)


## Example configuration

In the FoxyCart Admin, go to the [Integrations](https://admin.foxycart.com/admin.php?ThisAction=AddIntegration) area. Create a new token, and record the information provided.

Create a `foxy.yml` file in your project and enter the following information provided by your Foxy integration:

```yaml

Dynamic\Foxy\API\APIClient:
  enable_api: true
  client_id: ''
  client_secret: ''
  access_token: ''
  refresh_token: ''
  
```

## Maintainers
 *  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)>
 
## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over 
existing issues to ensure yours is unique. 
 
If the issue does look like a new bug:
 
 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots 
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version, 
 Operating System, any installed SilverStripe modules.
 
Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.
 
## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
