<?php

namespace Dynamic\Wishlist\Extensions;

use Dynamic\Wishlist\Form\AddToWishListForm;
use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;

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
        'AddToWishListForm',
    ];

    /**
     * @return \Dynamic\Wishlist\Form\AddToWishListForm
     */
    public function WishListForm()
    {
        return AddToWishListForm::create($this->owner, 'WishListForm');
    }

    /**
     * @param $data
     * @param \SilverStripe\Forms\Form $form
     * @return \SilverStripe\Control\HTTPResponse
     * @throws \Exception
     */
    public function addToWishList($data, Form $form)
    {
        /** @var ProductWishList|\Dynamic\Nucu\Extension\WishListExtension $list */
        $list = ProductWishList::get()->filter([
            'ID' => $data['List'],
        ])->first();
        $list->Products()->add($data['ProductID']);

        return $this->owner->redirectBack();
    }
}
