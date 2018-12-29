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
     * @param \SilverStripe\Control\Controller $controller
     * @param string $name Defaults to AddToWishListForm
     * @param int $productID An easy way to override the id of the product to be added. If one is not provided the current page id will be used instead.
     */
    public function __construct(Controller $controller, $name = 'AddToWishListForm', $productID = 0)
    {
        if ($productID < 1) {
            $productID = $controller->ID;
        }

        $lists = ProductWishList::get()->filter([
            'MemberID' => Security::getCurrentUser()->ID,
        ]);
        $this->extend('updateWishLists', $lists);

        $fields = FieldList::create(
            HiddenField::create('ProductID', 'ProductID', $productID),
            DropdownField::create('List', 'Wish List', $lists->map('ID', 'Title'))
        );
        $this->extend('updateFields', $fields, $productID);

        $actions = FieldList::create(
            FormAction::create('addToWishList')->setTitle('Add To List')
        );
        $this->extend('updateActions', $actions, $productID);

        parent::__construct($controller, $name, $fields, $actions);

        // makes a unique id for each wishlist form
        $reflection = new \ReflectionClass($this);
        $shortName = str_replace(array('.', '/'), '', $this->getName());
        $this->setHTMLID($reflection->getShortName() . '_' . $shortName . '_' . $productID);
    }
}
