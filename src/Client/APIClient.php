<?php

namespace Dynamic\Foxy\API\Client;

use Dynamic\Foxy\Model\FoxyHelper;
use Foxy\FoxyClient\FoxyClient;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Extensible;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Core\Injector\Injector;

class APIClient
{
    use Configurable;
    use Injectable;
    use Extensible;

    private static bool $enable_api = false;

    private static ?string $client_id = null;

    private static ?string $client_secret = null;

    private static ?string $access_token = null;

    private static ?string $refresh_token = null;

    private ?FoxyClient $client = null;

    private ?string $current_store = null;

    public function __construct()
    {
        $config = [
            'use_sandbox' => false,
        ];

        // Load credentials from environment variables first, fall back to YAML config
        $config['client_id'] = $this->getCredential('client_id', 'FOXY_API_CLIENT_ID');
        $config['client_secret'] = $this->getCredential('client_secret', 'FOXY_API_CLIENT_SECRET');
        $config['access_token'] = $this->getCredential('access_token', 'FOXY_API_ACCESS_TOKEN');
        $config['refresh_token'] = $this->getCredential('refresh_token', 'FOXY_API_REFRESH_TOKEN');
        $config['access_token_expires'] = 7200;

        $guzzle_config = [
            'defaults' => [
                'debug' => false,
                'exceptions' => false,
            ],
        ];

        $guzzle = new Client($guzzle_config);

        $fc = new FoxyClient($guzzle, $config);

        $this->setClient($fc);
        $this->setCurrentStore();
    }

    /**
     * Get a credential value, checking environment variable first, then YAML config.
     */
    private function getCredential(string $configKey, string $envKey): ?string
    {
        // Environment variable takes precedence
        $value = Environment::getEnv($envKey);
        if ($value) {
            return $value;
        }

        // Fall back to YAML config
        return $this->config()->get($configKey);
    }

    public function getClient(): ?FoxyClient
    {
        return $this->client;
    }

    public function setClient(FoxyClient $client): self
    {
        $this->client = $client;

        return $this;
    }

    public static function is_valid(): bool
    {
        $hasClientId = Environment::getEnv('FOXY_API_CLIENT_ID') ?: self::config()->get('client_id');
        $hasClientSecret = Environment::getEnv('FOXY_API_CLIENT_SECRET') ?: self::config()->get('client_secret');
        $hasAccessToken = Environment::getEnv('FOXY_API_ACCESS_TOKEN') ?: self::config()->get('access_token');
        $hasRefreshToken = Environment::getEnv('FOXY_API_REFRESH_TOKEN') ?: self::config()->get('refresh_token');

        return (bool) (
            self::config()->get('enable_api') &&
            $hasClientId &&
            $hasClientSecret &&
            $hasRefreshToken &&
            $hasAccessToken
        );
    }

    public function getCurrentStore(): ?string
    {
        return $this->current_store;
    }

    public function setCurrentStore(): void
    {
        $client = $this->getClient();
        $helper = FoxyHelper::create();

        $errors = [];
        $data = [
            'store_domain' => $helper->getStoreCartURL(),
        ];

        if ($client && $result = $client->get()) {
            $errors = array_merge($errors, $client->getErrors($result));
            if ($reporting_uri = $client->getLink('fx:reporting')) {
                $errors = array_merge($errors, $client->getErrors($reporting_uri));
                if ($result = $client->get($reporting_uri)) {
                    $errors = array_merge($errors, $client->getErrors($result));
                    if ($store_exists_uri = $client->getLink('fx:reporting_store_domain_exists')) {
                        $errors = array_merge($errors, $client->getErrors($store_exists_uri));
                        if ($result = $client->get($store_exists_uri, $data)) {
                            $errors = array_merge($errors, $client->getErrors($result));
                            if ($store = $client->getLink('fx:store')) {
                                $errors = array_merge($errors, $client->getErrors($store));
                                $this->current_store = $store;
                            }
                        }
                    }
                }
            }
            if (count($errors)) {
                Injector::inst()
                    ->get(LoggerInterface::class)->error('setCurrentStore errors - ' . json_encode($errors));
            }
        }
    }
}

