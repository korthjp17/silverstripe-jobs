<?php

namespace Dynamic\Jobs\Model;

use Dynamic\Jobs\Page\Job;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

/**
 * Class JobCategory
 * @package Dynamic\Jobs\Model
 */
class JobCategory extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Category';

    /**
     * @var string
     */
    private static $plural_name = 'Categories';

    /**
     * @var string
     */
    private static $table_name = 'Dynamic_JobCategory';

    /**
     * @var array
     */
    private static $db = [
        'Name' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Jobs' => Job::class,
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Name' => 'Name',
        'Title' => 'Title',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Name',
        'Title',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Name')->setDescription('For internal reference only');

        if ($this->ID) {
            $fields->dataFieldByName('Jobs')->getConfig()
                ->removeComponentsByType(GridFieldAddNewButton::class);
        }

        return $fields;
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canEdit($member = null)
    {
        return Permission::check('Job_EDIT', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canDelete($member = null)
    {
        return Permission::check('Job_DELETE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool|int
     */
    public function canCreate($member = null, $context = [])
    {
        return Permission::check('Job_CREATE', 'any', $member);
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }
}
