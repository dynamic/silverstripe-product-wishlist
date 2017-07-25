<?php

/**
 * Class TestProductWishListTest
 */
class ProductWishListTest extends SapphireTest
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
    public function testCanCreate()
    {
        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $canAccess = $this->objFromFixture('Member', 'cancreate');
        $cantAccess = $this->objFromFixture('Member', 'cantcreate');

        $this->assertTrue($wishList->canCreate($canAccess));
        $this->assertFalse($wishList->canCreate($cantAccess));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $canAccess = $this->objFromFixture('Member', 'cancreate');
        $cantAccess = $this->objFromFixture('Member', 'cantcreate');

        $this->assertTrue($wishList->canEdit($canAccess));
        //$this->assertFalse($wishList->canEdit($cantAccess));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $canAccess = $this->objFromFixture('Member', 'cancreate');
        $cantAccess = $this->objFromFixture('Member', 'cantcreate');

        $this->assertTrue($wishList->canDelete($canAccess));
        //$this->assertFalse($wishList->canDelete($cantAccess));
    }

    /**
     *
     */
    public function testCanView()
    {
        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $canAccess = $this->objFromFixture('Member', 'cancreate');
        $cantAccess = $this->objFromFixture('Member', 'cantcreate');

        $this->assertTrue($wishList->canView($canAccess));
        //todo fix following assertion
        //$this->assertFalse($wishList->canView($cantAccess));

        $viewableWishList = $this->objFromFixture('TestProductWishList', 'three');

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

        $this->assertEquals($expected, Injector::inst()->get('ProductWishList')->providePermissions());
    }

    /**
     *
     */
    public function testGetViewAction()
    {
        $this->assertEquals('view', Injector::inst()->get('ProductWishList')->getViewAction());
    }

    /**
     *
     */
    public function testGetFrontEndRequiredFields()
    {
        $this->assertInstanceOf('RequiredFields',
            Injector::inst()->get('ProductWishList')->getFrontEndRequiredFields());

        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $this->assertTrue($wishList->getFrontEndRequiredFields()->fieldIsRequired('OtherField'));
    }

    /**
     *
     */
    public function testGetFrontEndActions()
    {
        $this->assertInstanceOf('FieldList', Injector::inst()->get('ProductWishList')->getFrontEndActions());

        $wishList = $this->objFromFixture('TestProductWishList', 'one');
        $this->assertNull($wishList->getFrontEndActions()->dataFieldByName('action_CancelFormAction'));
        $this->assertInstanceOf('CancelFormAction',
            $wishList->getFrontEndActions(true)->dataFieldByName('action_CancelFormAction'));

        $this->assertInstanceOf('FormAction', $wishList->getFrontEndActions()->dataFieldByName('action_OtherAction'));
    }

    /**
     *
     */
    public function testGetFrontEndFields()
    {
        $baseFields = Injector::inst()->get('ProductWishList')->getFrontEndFields();
        $this->assertInstanceOf('FieldList', $baseFields);
        $this->assertNull($baseFields->fieldByName('MemberID'));

        $wishList = $this->objFromFixture('TestProductWishList', 'four');
        $updatedFields = $wishList->getFrontEndFields();
        $this->assertInstanceOf('FieldList', $updatedFields);
        $this->assertInstanceOf('TextareaField', $updatedFields->dataFieldByName('OtherField'));
    }

}