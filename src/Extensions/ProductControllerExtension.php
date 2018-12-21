<?php

namespace Dynamic\Wishlist\Extensions;

use Dynamic\Wishlist\Form\AddToWishListForm;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Security;

/**
 * Class ProductExtension
 * @package Dynamic\Wishlist\Extensions
 *
 * @property-read \SilverStripe\Control\Controller $owner
 */
class ProductControllerExtension extends Extension
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'WishListForm',
    ];

    /**
     * @return \Dynamic\Wishlist\Form\AddToWishListForm|bool
     */
    public function WishListForm()
    {
        if (!Security::getCurrentUser()) {
            return false;
        }

        return AddToWishListForm::create($this->owner, 'WishListForm');
    }
}
