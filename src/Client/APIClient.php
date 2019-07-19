<?php

namespace Dynamic\Foxy\API;

use Dynamic\Foxy\Model\FoxyHelper;
use Dynamic\Foxy\Model\Setting;
use Foxy\FoxyClient\FoxyClient;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extensible;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Core\Injector\Injector;

class APIClient
{
    use Configurable;
    use Injectable;
    use Extensible;

    /**
     * @var
     */
    private static $enable_api;

    /**
     * @var
     */
    private static $client_id;

    /**
     * @var
     */
    private static $client_secret;

    /**
     * @var
     */
    private static $access_token;

    /**
     * @var
     */
    private static $refresh_token;

    /**
     * @var
     */
    private $client;

    /**
     * @var
     */
    private $current_store;

    /**
     * APIClient constructor.
     */
    public function __construct()
    {
        $config = [
            'use_sandbox' => false,
        ];

        $config['client_id'] = $this->config()->get('client_id');
        $config['client_secret'] = $this->config()->get('client_secret');
        $config['refresh_token'] = $this->config()->get('refresh_token');
        $config['access_token'] = $this->config()->get('access_token');
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
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return bool
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function is_valid()
    {
        $helper = FoxyHelper::create();

        return self::config()->get('enable_api') &&
            self::config()->get('client_id') &&
            self::config()->get('client_secret') &&
            self::config()->get('refresh_token') &&
            self::config()->get('access_token');
    }

    /**
     * @return mixed
     */
    public function getCurrentStore()
    {
        return $this->current_store;
    }

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function setCurrentStore()
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
