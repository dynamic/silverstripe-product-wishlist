<?php

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
     * @return ContentController|Object
     */
    protected function getController()
    {
        return ($this->owner->hasMethod('getCurrentPage'))
            ? $this->owner->getCurrentPage()
            : $this->owner;
    }

    /**
     * @param SS_HTTPRequest|null $request
     *
     * @return ViewableData_Customised|SS_HTTPResponse
     */
    public function view(SS_HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->getController()->getRequest();
        }
        $id = $request->param('ID');

        if ($record = ProductWishList::get()->byID($id)) {
            if ($record->canView(Member::currentUser())) {
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
     * @param $collection
     * @param $searchCriteria
     */
    public function updateCollectionItems(&$collection, $searchCriteria)
    {
        $collection = $collection->filter(['MemberID' => Member::currentUserID()]);
    }

}