<?php

use PHPUnit\Framework\TestCase;
use UchiPro\ApiClient;
use UchiPro\Identity;
use UchiPro\Vendors\Limits;

class VendorsTest extends TestCase
{
    /**
     * @var Identity
     */
    private $identity;

    public function setUp()
    {
        $url = getenv('UCHIPRO_URL');
        $login = getenv('UCHIPRO_LOGIN');
        $password = getenv('UCHIPRO_PASSWORD');
        $accessToken = getenv('UCHIPRO_ACCESS_TOKEN');

        if (!empty($accessToken)) {
            $this->identity = Identity::createByAccessToken($url, $accessToken);
        } else {
            $this->identity = Identity::createByLogin($url, $login, $password);
        }
    }

    /**
     * @return ApiClient
     */
    public function getApiClient()
    {
        return ApiClient::create($this->identity);
    }

    public function testGetVendors()
    {
        $vendorsApi = $this->getApiClient()->vendors();

        $vendors = $vendorsApi->findBy();

        $this->assertTrue(is_array($vendors));
    }

    public function testGetVendorLimits()
    {
        $vendorsApi = $this->getApiClient()->vendors();

        $vendors = $vendorsApi->findBy();

        if (isset($vendors[0])) {
            $vendor = $vendors[0];
            $limits = $vendorsApi->getVendorLimits($vendor);
            $this->assertInstanceOf(Limits::class, $limits);
        }
    }
}
