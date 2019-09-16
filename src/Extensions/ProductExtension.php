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
        /** @var \SilverStripe\CMS\Model\SiteTree $page */
        $page = $page = $wishListPage::get()->first();

        if (!$page) {
            return false;
        }

        if (!$this->canRemoveFromWishList()) {
            return false;
        }

        return Controller::join_links(
            $page->Link('remove'),
            Controller::curr()->getRequest()->param('ID'),
            $this->owner->ID
        );
    }

    /**
     * @return bool
     */
    protected function canRemoveFromWishList()
    {
        $request = Controller::curr()->getRequest();
        $list = ProductWishList::get()->filter([
            'URLSegment' => $request->param('ID'),
        ])->first();

        if (!$list) {
            $list = ProductWishList::get()->filter([
                'MemberID' => Security::getCurrentUser()->ID,
            ])->first();
        }

        if (!$list) {
            return false;
        }

        return $list->canEdit(Security::getCurrentUser());
    }
}
