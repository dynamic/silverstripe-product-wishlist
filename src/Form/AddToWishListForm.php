<?php

namespace Dynamic\Wishlist\Form;


use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Security\Security;

/**
 * Class AddToWishListForm
 * @package Dynamic\Wishlist\Form
 */
class AddToWishListForm extends Form
{
    /**
     * AddToWishListForm constructor.
     * @param \SilverStripe\Control\Controller|\Dynamic\FoxyStripe\Page\ProductPage $controller
     * @param string $name
     */
    public function __construct(Controller $controller, $name = 'AddToWishListForm')
    {
        $lists = ProductWishList::get()->filter([
            'MemberID' => Security::getCurrentUser()->ID,
        ]);
        $this->extend('updateWishLists', $lists);

        $fields = FieldList::create(
            HiddenField::create('ProductID', 'ProductID', $controller->ID),
            DropdownField::create('List', 'Wish List', $lists->map('ID', 'Title'))
        );
        $this->extend('updateFields', $fields);

        $actions = FieldList::create(
            FormAction::create('addToWishList', 'Add To List')
        );
        $this->extend('updateActions', $actions);

        parent::__construct($controller, $name, $fields, $actions);
    }
}
