<?php

namespace Grayloon\Magento\Tests;

use Grayloon\Magento\Models\MagentoCategory;
use Grayloon\Magento\Models\MagentoCustomAttribute;
use Grayloon\Magento\Models\MagentoProduct;
use Grayloon\Magento\Models\MagentoProductCategory;

class MagentoProductModelTest extends TestCase
{
    public function test_can_create_magento_product()
    {
        $product = factory(MagentoProduct::class)->create();

        $this->assertNotEmpty($product);
    }

    public function test_can_get_custom_attributes_on_magento_product()
    {
        $product = factory(MagentoProduct::class)->create();

        factory(MagentoCustomAttribute::class)->create([
            'attributable_type'   => MagentoProduct::class,
            'attributable_id'     => $product->id,
        ]);

        $attributes = $product->customAttributes()->get();

        $this->assertNotEmpty($product, $attributes);
        $this->assertEquals(1, $attributes->count());
        $this->assertEquals(MagentoProduct::class, $attributes->first()->attributable_type);
    }

    public function test_can_add_custom_attributes_to_magento_product()
    {
        $product = factory(MagentoProduct::class)->create();

        $attribute = $product->customAttributes()->updateOrCreate([
            'attribute_type' => 'foo',
            'value'          => 'bar',
        ]);

        $this->assertNotEmpty($attribute);
        $this->assertEquals('foo', $attribute->attribute_type);
        $this->assertEquals('bar', $attribute->value);
        $this->assertEquals(MagentoProduct::class, $attribute->attributable_type);
        $this->assertEquals($product->id, $attribute->attributable_id);
    }

    public function test_can_update_instead_of_creating_row_custom_attributes()
    {
        $product = factory(MagentoProduct::class)->create();

        factory(MagentoCustomAttribute::class)->create([
            'attributable_type'   => MagentoProduct::class,
            'attributable_id'     => $product->id,
            'attribute_type'      => 'foo',
            'value'               => 'bar',
        ]);

        $attribute = $product->customAttributes()->updateOrCreate(['attribute_type' => 'foo'], [
            'value'=> 'baz',
        ]);

        $this->assertEquals(1, $product->customAttributes()->count());
        $this->assertEquals('baz', $attribute->value);
    }

    public function test_magento_product_can_get_single_category()
    {
        $product = factory(MagentoProduct::class)->create();

        $category = factory(MagentoProductCategory::class)->create([
            'magento_product_id' => $product->id,
        ]);

        $categories = $product->categories()->get();
        $this->assertNotEmpty($categories);
        $this->assertEquals(1, $categories->count());
        $this->assertInstanceOf(MagentoCategory::class, $categories->first());
        $this->assertEquals($category->magento_category_id, $categories->first()->id);
    }

    public function test_magento_product_can_get_categories()
    {
        $product = factory(MagentoProduct::class)->create();

        factory(MagentoProductCategory::class, 10)->create([
            'magento_product_id' => $product->id,
        ]);

        $categories = $product->categories()->get();
        $this->assertNotEmpty($categories);
        $this->assertEquals(10, $categories->count());
    }
}
