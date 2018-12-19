<?php

namespace Dynamic\Wishlist\Test\Model;

use Dynamic\AdditionalFormFields\Form\CancelFormAction;
use Dynamic\Wishlist\Model\ProductWishList;
use Dynamic\Wishlist\Test\Extra\TestProductWishList;
use Dynamic\Wishlist\Test\Extra\TestWishListPage;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Security\Member;

/**
 * Class TestProductWishListTest
 */
class ProductWishListTest extends SapphireTest
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
    public function testCanCreate()
    {
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $canAccess = $this->objFromFixture(Member::class, 'cancreate');
        $cantAccess = $this->objFromFixture(Member::class, 'cantcreate');

        $this->assertTrue($wishList->canCreate($canAccess));
        $this->assertFalse($wishList->canCreate($cantAccess));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $canAccess = $this->objFromFixture(Member::class, 'cancreate');
        $cantAccess = $this->objFromFixture(Member::class, 'cantcreate');

        $this->assertTrue($wishList->canEdit($canAccess));
        //$this->assertFalse($wishList->canEdit($cantAccess));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $canAccess = $this->objFromFixture(Member::class, 'cancreate');
        $cantAccess = $this->objFromFixture(Member::class, 'cantcreate');

        $this->assertTrue($wishList->canDelete($canAccess));
        //$this->assertFalse($wishList->canDelete($cantAccess));
    }

    /**
     *
     */
    public function testCanView()
    {
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $canAccess = $this->objFromFixture(Member::class, 'cancreate');
        $cantAccess = $this->objFromFixture(Member::class, 'cantcreate');

        $this->assertTrue($wishList->canView($canAccess));
        //todo fix following assertion
        //$this->assertFalse($wishList->canView($cantAccess));

        $viewableWishList = $this->objFromFixture(TestProductWishList::class, 'three');

        $this->assertTrue($viewableWishList->canView($cantAccess));
    }

    /**
     *
     */
    public function testProvidePermissions()
    {
        $expected = [
            'WishList_EDIT' => [
                'name' => 'Edit a Wish List',
                'category' => 'Wish List Permissions',
            ],
            'WishList_DELETE' => [
                'name' => 'Delete a Wish List',
                'category' => 'Wish List Permissions',
            ],
            'WishList_CREATE' => [
                'name' => 'Create a Wish List',
                'category' => 'Wish List Permissions',
            ],
            'WishList_VIEW' => [
                'name' => 'View a Wish List',
                'category' => 'Wish List Permissions',
            ],
        ];

        $this->assertEquals($expected, Injector::inst()->get(ProductWishList::class)->providePermissions());
    }

    /**
     *
     */
    public function testGetViewAction()
    {
        $this->assertEquals('view', Injector::inst()->get(ProductWishList::class)->getViewAction());
    }

    /**
     *
     */
    public function testGetFrontEndRequiredFields()
    {
        $this->assertInstanceOf(
            RequiredFields::class,
            Injector::inst()->get(ProductWishList::class)->getFrontEndRequiredFields()
        );

        /** @var TestProductWishList $wishList */
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $this->assertTrue($wishList->getFrontEndRequiredFields()->fieldIsRequired('OtherField'));
    }

    /**
     *
     */
    public function testGetFrontEndActions()
    {
        $this->assertInstanceOf(
            FieldList::class,
            Injector::inst()->get(ProductWishList::class)->getFrontEndActions()
        );

        /** @var TestProductWishList $wishList */
        $wishList = $this->objFromFixture(TestProductWishList::class, 'one');
        $this->assertNull($wishList->getFrontEndActions()->dataFieldByName('action_CancelFormAction'));
        $this->assertInstanceOf(CancelFormAction::class,
            $wishList->getFrontEndActions(true)->dataFieldByName('action_CancelFormAction'));

        $this->assertInstanceOf(FormAction::class, $wishList->getFrontEndActions()->dataFieldByName('action_OtherAction'));
    }

    /**
     *
     */
    public function testGetFrontEndFields()
    {
        /** @var ProductWishList $baseWishList */
        $baseWishList = Injector::inst()->get(ProductWishList::class);
        $baseFields = $baseWishList->getFrontEndFields();
        $this->assertInstanceOf(FieldList::class, $baseFields);
        $this->assertNull($baseFields->fieldByName('MemberID'));

        /** @var TestProductWishList $wishList */
        $wishList = $this->objFromFixture(TestProductWishList::class, 'four');
        $updatedFields = $wishList->getFrontEndFields();
        $this->assertInstanceOf(FieldList::class, $updatedFields);
        $this->assertInstanceOf(TextareaField::class, $updatedFields->dataFieldByName('OtherField'));
    }

}
