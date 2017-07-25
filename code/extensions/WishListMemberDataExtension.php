<?php

/**
 * Class WishListMemberDataExtension
 */
class WishListMemberDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = [
        'WishLists' => 'ProductWishList',
    ];

}