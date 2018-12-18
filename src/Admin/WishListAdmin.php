<?php

namespace Dynamic\Wishlist\Admin;

use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class WishListAdmin
 */
class WishListAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = array(
        ProductWishList::class,
    );

    /**
     * @var string
     */
    private static $url_segment = 'wishlists';

    /**
     * @var string
     */
    private static $menu_title = 'Wish Lists';

}
