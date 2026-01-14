# SilverStripe Foxy API

An addon module for SilverStripe Foxy that adds API functionality with Foxy.io

[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-foxy-api/v/stable)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)
[![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-foxy-api/downloads)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)
[![License](https://poser.pugx.org/dynamic/silverstripe-foxy-api/license)](https://packagist.org/packages/dynamic/silverstripe-foxy-api)

## Requirements

* PHP ^8.1
* SilverStripe CMS ^5.0
* dynamic/silverstripe-foxy ^3.0

## Installation

```bash
composer require dynamic/silverstripe-foxy-api ^2.0
```


## License

See [License](license.md)


## Configuration

### Using Environment Variables (Recommended)

Add these variables to your `.env` file. You can obtain these from your Foxy admin by creating a **Private Integration** at [Foxy Integrations](https://admin.foxy.io/admin.php?ThisAction=AddIntegration):

```bash
FOXY_API_CLIENT_ID="your-client-id"
FOXY_API_CLIENT_SECRET="your-client-secret"
FOXY_API_ACCESS_TOKEN="your-access-token"
FOXY_API_REFRESH_TOKEN="your-refresh-token"
```

Then enable the API in your project's YAML config:

```yaml
Dynamic\Foxy\API\Client\APIClient:
  enable_api: true
```

### Alternative: Full YAML Configuration

If you prefer to keep credentials in YAML (not recommended for production):

```yaml
Dynamic\Foxy\API\Client\APIClient:
  enable_api: true
  client_id: 'your-client-id'
  client_secret: 'your-client-secret'
  access_token: 'your-access-token'
  refresh_token: 'your-refresh-token'
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
