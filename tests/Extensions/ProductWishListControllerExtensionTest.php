<?php

namespace Dynamic\Wishlist\Test\Extensions;

use Dynamic\Wishlist\Test\Extra\TestProductWishList;
use Dynamic\Wishlist\Test\Extra\TestWishListPage;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\FunctionalTest;

/**
 * Class ProductWishListControllerExtensionTest
 */
class ProductWishListControllerExtensionTest extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        TestWishListPage::class,
        TestProductWishList::class,
    ];

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->session()->set('readingMode', 'Stage.Stage');
        $this->session()->set('unsecuredDraftSite', true);
    }

    /**
     *
     */
    public function testView()
    {
        /** @var TestProductWishList $wishList */
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        /** @var TestWishListPage $wishListPage */
        $wishListPage = $this->objFromFixture(TestWishListPage::class, 'one');

        $response = $this->get(Controller::join_links(
            $wishListPage->Link(),
            'view',
            $wishList->URLSegment
        ));
        $this->assertEquals(200, $response->getStatusCode());
    }

}//*/
