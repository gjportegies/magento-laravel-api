<?php

namespace Grayloon\Magento\Tests\Support;

use Grayloon\Magento\Models\MagentoCustomer;
use Grayloon\Magento\Support\MagentoCustomers;
use Grayloon\Magento\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class MagentoCustomersTest extends TestCase
{
    public function test_can_count_magento_customers()
    {
        Http::fake(function ($request) {
            return Http::response([
                'total_count' => 1,
            ], 200);
        });

        $customers = new MagentoCustomers();

        $count = $customers->count();

        $this->assertEquals(1, $count);
    }

    public function test_can_create_magento_customer()
    {
        $customers = [
            [
                'id'         => '1',
                'group_id'   => '1',
                'created_at' => '2014-04-04 14:17:29',
                'updated_at' => '2014-04-04 14:17:29',
                'email'      => 'dschrute@dundermifflin.com',
                'firstname'  => 'Dwight',
                'lastname'   => 'Schrute',
                'store_id'   => 1,
                'website_id' => 1,
                'addresses' => [
                    [
                        'id' => 1,
                        'customer_id' => 1,
                        'region' => [
                            'region_code' => 'PA',
                            'region'      => 'Pennsylvania',
                            'region_id'   => 1,
                        ],
                        'region_id' => 1,
                        'country_id' => 'US',
                        'street' => [
                            '100 Beetfarm Lake',
                        ],
                        'telephone' => '888 888-8888',
                        'city'      => 'Scranton',
                        'firstname' => 'Dwight',
                        'lastname'  => 'Schrute',
                    ],
                ],
                'custom_attributes' => [
                    [
                        'attribute_code' => 'rewards_member',
                        'value'          => '1',
                    ],
                ],
            ],
        ];

        $magentoCustomers = new MagentoCustomers();

        $magentoCustomers->updateCustomers($customers);

        $customer = MagentoCustomer::first();

        $this->assertNotEmpty($customer);
        $this->assertEquals('Dwight', $customer->first_name);
        $this->assertNotEmpty($customer->addresses());
        $this->assertEquals('100 Beetfarm Lake', $customer->addresses()->first()->street);
        $this->assertNotEmpty($customer->customAttributes()->get());
        $this->assertEquals('rewards_member', $customer->customAttributes()->first()->attribute_type);
    }
}
