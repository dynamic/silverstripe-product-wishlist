<?php

/**
 * Class TestProductWishListDataExtension
 */
class TestProductWishListDataExtension extends DataExtension implements TestOnly
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