<?php

namespace Dynamic\Wishlist\Test\Extra;

use Dynamic\Wishlist\Extensions\ProductWishListControllerExtension;
use SilverStripe\Dev\TestOnly;
use SilverStripe\View\Requirements;

/**
 * Class TestWishListPage_Controller
 */
class TestWishListPageController extends \PageController implements TestOnly
{

    /**
     * @var string
     */
    private static $managed_object = TestProductWishList::class;

    /**
     * @var array
     */
    private static $url_handler = [
        'test-wishlist-page-path' => 'index'
    ];

    /**
     * @var array
     */
    private static $extensions = [
        ProductWishListControllerExtension::class,
    ];

    /**
     * empty init
     */
    public function init()
    {
        parent::init();
        Requirements::clear();
    }
}
