<?php

namespace Dynamic\Wishlist\Extensions;

use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\ORM\DataExtension;

/**
 * Class WishListMemberDataExtension
 */
class WishListMemberDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = [
        'WishLists' => ProductWishList::class,
    ];

}
