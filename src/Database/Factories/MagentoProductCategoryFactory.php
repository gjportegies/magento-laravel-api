<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Grayloon\Magento\Models\MagentoCategory;
use Grayloon\Magento\Models\MagentoProduct;
use Grayloon\Magento\Models\MagentoProductCategory;

$factory->define(MagentoProductCategory::class, function () {
    return [
        'magento_product_id'  => factory(MagentoProduct::class)->create(),
        'magento_category_id' => factory(MagentoCategory::class)->create(),
    ];
});
