[![Build Status](https://travis-ci.org/dynamic/silverstripe-product-wishlist.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-product-wishlist)
[![codecov](https://codecov.io/gh/dynamic/silverstripe-product-wishlist/branch/master/graph/badge.svg)](https://codecov.io/gh/dynamic/silverstripe-product-wishlist)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-product-wishlist/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-product-wishlist/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-product-wishlist/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-product-wishlist/build-status/master)

# product-wishlist
Allows users to create and manage a wish list on a website.

## Requirements
- silverstripe/recipe-cms ^4.0
- dynamic/viewable-dataobject ^2.0
- dynamic/silverstripe-additional-formfields ^2.0
- dynamic/silverstripe-manageable-dataobject ^2.0

## Installation
`composer require dynamic/silverstripe-product-wishlist`


## Example usage
This module was not hooked up with any particular module that adds products to allow flexibility.
The examples here will use FoxyStripe.

### ProductWishList Extension
A product relation must be added to `Dynamic\Wishlist\Model\ProductWishList` through a DataExtension.
```yml
Dynamic\Wishlist\Model\ProductWishList:
  extensions:
    - Foo\Bar\ORM\WishListExtension
```

```php
<?php

namespace Foo\Bar\ORM;

use Dynamic\FoxyStripe\Page\ProductPage;
use SilverStripe\ORM\DataExtension;

class WishListExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'Products' => ProductPage::class,
    ];
}
```

### Product Relation
The Product must also have a reciprocal relation to wishlists.
```yml
Dynamic\FoxyStripe\Page\ProductPage:
  extensions:
    - Foo\Bar\ORM\ProductExtension
```

```php
<?php

namespace Foo\Bar\ORM;

use Dynamic\Wishlist\Model\ProductWishList;

class ProductExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $belongs_many_many = [
        'WishLists' => ProductWishList::class,
    ];
}
```

### WishList Form
The `ProductControllerExtension` should be applied to the controller that handles showing a product.
```yml
Dynamic\FoxyStripe\Page\ProductPageController:
  extensions:
    - Dynamic\Wishlist\Extensions\ProductControllerExtension
```

The form can be passed a product id to avoid using the current controller's page id.
The form will not show if the user is not logged in.

#### AddToWishListForm and RemoveFromWishListForm
The only real difference between these forms are the actions the forms call and an extra class.

##### updateWishLists
An extension point for updating the wishlists visible in the dropdown field.
It is passed a `DataList` of the wishlists associated with the current user.
```php
/**
 * @param SilverStripe\ORM\DataList $lists
 */
public function updateWishLists($lists)
{
    // Stuff here
}
```

##### updateFields
An extension point for updating the fields for the form.
It is passed a `FieldList` and an int.
```php
/**
 * @param SilverStripe\Forms\FieldList $fields
 * @param int $productID
 */
public function updateFields($fields, $productID)
{
    // Stuff here
}
```

##### updateActions
An extension point for updating the actions for the form.
It is passed a `FieldList` and an int.
```php
/**
 * @param SilverStripe\Forms\FieldList $actions
 * @param int $productID
 */
public function updateActions($actions, $productID)
{
    // Stuff here
}
```

### WishList Form Handling
Handling the `addToWishList` and `removeFromWishList` actions is not included by default.
The example implementations should be on a controller, or an extension applied to a controller.

#### addToWishList Example
```php
/**
 * @param $data
 * @param \SilverStripe\Forms\Form $form
 * @return \SilverStripe\Control\HTTPResponse
 * @throws \Exception
 */
public function addToWishList($data, Form $form)
{
    /** @var ProductWishList|\Foo\Bar\Extension\WishListExtension $list */
    $list = ProductWishList::get()->filter([
        'ID' => $data['List'],
    ])->first();

    $list->Products()->add($data['ProductID']);

    return $this->owner->redirectBack();
}
```

#### removeFromWishList Example
```php
/**
 * @param $data
 * @param \SilverStripe\Forms\Form $form
 * @return \SilverStripe\Control\HTTPResponse
 * @throws \Exception
 */
public function removeFromWishList($data, Form $form)
{
    /** @var ProductWishList|\Foo\Bar\Extension\WishListExtension $list */
    $list = ProductWishList::get()->filter([
        'ID' => $data['List'],
    ])->first();

    $list->Products()->removeByID($data['ProductID']);

    return $this->owner->redirectBack();
}
```

## Documentation
See the [docs/en](docs/en/index.md) folder.
