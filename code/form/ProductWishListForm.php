<?php

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
    public function __construct(Controller $controller, $name)
    {
        $wishList = Injector::inst()->get('ProductWishList');

        $fields = $wishList->getFrontEndFields();
        $actions = $wishList->getFrontEndActions();
        $validator = $wishList->getFrontEndRequiredFields();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}