<?php

namespace Dynamic\Wishlist\Extensions;


use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Security;

/**
 * Class ProductExtension
 * @package Dynamic\Wishlist\Extensions
 */
class ProductExtension extends Extension
{

    /**
     * @return bool|String
     */
    public function getRemoveLink()
    {
        $wishListPage = Config::inst()->get(ProductWishList::class, 'listing_page_class');
        if ($this->canRemoveFromWishList()) {
            /** @var \SilverStripe\CMS\Model\SiteTree $page */
            if ($page = $wishListPage::get()->first()) {
                return Controller::join_links(
                    $page->Link('remove'),
                    Controller::curr()->getRequest()->param('ID'),
                    $this->owner->ID
                );
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function canRemoveFromWishList()
    {
        $request = Controller::curr()->getRequest();
        if ($request->param('Action') != 'view') {
            return false;
        }

        $list = ProductWishList::get()->filter([
            'URLSegment' => $request->param('ID'),
        ])->first();

        if (!$list) {
            return false;
        }

        return $list->canEdit(Security::getCurrentUser());
    }
}
