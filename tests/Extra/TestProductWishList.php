<?php

namespace Dynamic\Wishlist\Test\Extra;

use Dynamic\ViewableDataObject\Extensions\ViewableDataObject;
use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestProductWishList
 */
class TestProductWishList extends ProductWishList implements TestOnly
{

    private static $table_name = 'TestProductWishList';

    /**
     * @var array
     */
    private static $db = [
        'OtherField' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $extensions = [
        TestProductWishListDataExtension::class,
        ViewableDataObject::class,
    ];

    /**
     * @var string
     */
    private static $listing_page_class = TestWishListPage::class;
}
