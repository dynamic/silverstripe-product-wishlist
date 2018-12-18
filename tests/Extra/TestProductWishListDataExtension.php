<?php

namespace Dynamic\Wishlist\Test\Extra;

use SilverStripe\Core\Extension;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;

/**
 * Class TestProductWishListDataExtension
 */
class TestProductWishListDataExtension extends Extension implements TestOnly
{

    /**
     * @param RequiredFields $fields
     */
    public function updateFrontEndRequiredFields(RequiredFields $fields)
    {
        $fields->addRequiredField('OtherField');
    }

    /**
     * @param FieldList $actions
     */
    public function updateFrontEndActions(FieldList $actions)
    {
        $actions->push(FormAction::create('OtherAction')->setTitle('Other Action'));
    }

    /**
     * @param FieldList $fields
     */
    public function updateFrontEndFields(FieldList $fields)
    {
        $fields->replaceField('OtherField', TextareaField::create('OtherField'));
    }

}
