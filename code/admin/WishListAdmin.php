<?php

class WishListAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = array(
        'ProductWishList',
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