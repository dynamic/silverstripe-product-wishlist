<?php

namespace Dynamic\Wishlist\Extensions;

use Dynamic\Wishlist\Form\AddToWishListForm;
use Dynamic\Wishlist\Form\RemoveFromWishListForm;
use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Control\HTTPRequest;
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
     * @param int|HTTPRequest $productID
     * @return \Dynamic\Wishlist\Form\AddToWishListForm|\Dynamic\Wishlist\Form\RemoveFromWishListForm|bool
     */
    public function WishListForm($productID = 0)
    {
        if (!Security::getCurrentUser()) {
            return false;
        }

        if (!$productID) {
            $productID = $this->owner->ID;
        } else if ($productID instanceof HTTPRequest) {
            $productID = $productID->postVar('ProductID');
        }

        /** @var ProductWishList $list */
        $list = ProductWishList::get()->filter([
            'MemberID' => Security::getCurrentUser()->ID,
        ])->first();

        if (!$list || !$list->Products()->byID($productID)) {
            return AddToWishListForm::create($this->owner, __FUNCTION__, $productID);
        }

        return RemoveFromWishListForm::create($this->owner, __FUNCTION__, $productID);
    }
}
