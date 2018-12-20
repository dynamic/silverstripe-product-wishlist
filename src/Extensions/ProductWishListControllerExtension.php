<?php

namespace Dynamic\Wishlist\Extensions;

use Dynamic\Wishlist\Model\ProductWishList;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Security;

/**
 * Class ProductWishListControllerExtension
 */
class ProductWishListControllerExtension extends Extension
{

    /**
     * @var array
     */
    private static $allowed_actions = [
        'view',
    ];

    /**
     * @return \SilverStripe\CMS\Controllers\ContentController|Object
     */
    protected function getController()
    {
        return $this->owner;
    }

    /**
     * @param HTTPRequest|null $request
     *
     * @return \SilverStripe\View\ViewableData_Customised|\SilverStripe\Control\HTTPResponse
     * @throws \SilverStripe\Control\HTTPResponse_Exception
     */
    public function view(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->getController()->getRequest();
        }
        $id = $request->param('ID');

        /** @var ProductWishList $record */
        $record = ProductWishList::get()->filter([
            'URLSegment' => $id,
        ])->first();
        
        if ($record) {
            if ($record->canView(Security::getCurrentUser())) {
                return $this->getController()->customise([
                    'WishList' => $record,
                    'Breadcrumbs' => $record->Breadcrumbs(),
                    'ProductWishListForm' => false,
                ]);
            }

            return Security::permissionFailure($this->owner, "You don't have permission to view this record.");
        }

        return $this->getController()->httpError(404);
    }

    /**
     * @param \SilverStripe\ORM\ArrayList $collection
     * @param $searchCriteria
     */
    public function updateCollectionItems(&$collection, $searchCriteria)
    {
        $collection = $collection->filter(['MemberID' => Security::getCurrentUser()->ID]);
    }
}
