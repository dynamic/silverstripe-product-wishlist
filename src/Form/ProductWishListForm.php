<?php

namespace Dynamic\Wishlist\Form;

use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Form;

/**
 * Class ProductWishListForm
 */
class ProductWishListForm extends Form
{

    /**
     * ProductWishListForm constructor.
     *
     * @param Controller $controller
     * @param string $name
     */
    public function __construct(Controller $controller, $name = 'WishListForm')
    {
        $wishList = Injector::inst()->get(ProductWishList::class);

        $fields = $wishList->getFrontEndFields();
        $actions = $wishList->getFrontEndActions();
        $validator = $wishList->getFrontEndRequiredFields();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}
