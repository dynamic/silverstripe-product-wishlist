<?php

class ProductWishList extends DataObject implements PermissionProvider, Dynamic\ViewableDataObject\VDOInterfaces\ViewableDataObjectInterface
{
    private static $db = [
        'Title' => 'Varchar(100)',
        'Private' => 'Boolean',
    ];

    private static $has_one = [
        'Member' => 'Member',
    ];

    /**
     * set ParentPage for ViewableDataobject
     *
     * @return string
     */
    public function getParentPage()
    {
        return ProductWishListPage::get()->first();
    }

    /**
     * set ViewAction for ViewableDataobject
     *
     * @return string
     */
    public function getViewAction()
    {
        return 'view';
    }

    /**
     * @return array
     */
    public function providePermissions()
    {
        return array(
            'WishList' => 'Edit a Wish List',
            'WishList_DELETE' => 'Delete a Wish List',
            'WishList_CREATE' => 'Create a Wish List',
            'WishList_VIEW' => 'View a Wish List',
        );
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('WishList_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('WishList_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null)
    {
        return Permission::check('WishList_CREATE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return Permission::check('WishList_VIEW', 'any', $member);
    }
}