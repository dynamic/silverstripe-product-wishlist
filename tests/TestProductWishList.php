<?php

/**
 * Class TestProductWishList
 */
class TestProductWishList extends ProductWishList implements TestOnly
{

    /**
     * @var array
     */
    private static $db = [
        'OtherField' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $extensions = [
        'TestProductWishListDataExtension',
        'Dynamic\\ViewableDataObject\\Extensions\\ViewableDataObject',
    ];

    /**
     * @var string
     */
    private static $listing_page_class = 'TestWishListPage';

}