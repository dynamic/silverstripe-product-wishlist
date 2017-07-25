<?php

/**
 * Class ProductWishListControllerExtensionTest
 */
class ProductWishListControllerExtensionTest extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'product-wishlist/tests/fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'TestWishListPage',
        'TestProductWishList',
    ];

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        // Suppress themes
        //Config::inst()->remove('SSViewer', 'theme');
        //$config = Config::inst()->get('Director', 'rules');
        //$config = $config + ['test-wishlist-page-path' => 'TestWishListPage_Controller'];
        //Config::inst()->update('Director', 'rules', ['test-wishlist-page-path' => 'TestWishListPage_Controller']);//*
    }//*

    /**
     *
     */
    public function testView()
    {
        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $response = $this->get('/TestWishListPage_Controller/view/' . $wishList->ID);
        $this->assertEquals(200, $response->getStatusCode());
    }

}//*/