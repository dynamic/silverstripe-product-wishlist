<?php

/**
 * Class TestWishListPage
 */
class TestWishListPage extends Page implements TestOnly
{

}

/**
 * Class TestWishListPage_Controller
 */
class TestWishListPage_Controller extends Page_Controller implements TestOnly
{

    /**
     * @var string
     */
    private static $managed_object = 'TestProductWishList';

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
        'ProductWishListControllerExtension',
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