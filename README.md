# SilverStripe Foxy API

An addon module for SilverStripe Foxy that adds API functionality with Foxy.io

[![Build Status](https://travis-ci.org/dynamic/silverstripe-foxy-api.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-foxy-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-foxy-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-foxy-api/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-foxy-api/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-foxy-api/build-status/master)
[![codecov](https://codecov.io/gh/dynamic/silverstripe-foxy-api/branch/master/graph/badge.svg)](https://codecov.io/gh/dynamic/silverstripe-foxy-api)

[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-foxy-api/v/stable)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)
[![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-foxy-api/downloads)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/silverstripe-foxy-api/v/unstable)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)
[![License](https://poser.pugx.org/dynamic/silverstripe-foxy-api/license)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)


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

Dynamic\Foxy\API\Client\APIClient:
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
