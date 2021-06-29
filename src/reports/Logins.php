<?php
namespace Axllent\LoginReports\Reports;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\TextField;
use SilverStripe\Reports\Report;
use SilverStripe\Security\LoginAttempt;

class Logins extends Report
{
    /**
     * This is the title of the report,
     * used by the ReportAdmin templates.
     *
     * @var string
     */
    protected $title = 'Login report';

    /**
     * This is a description about what this
     * report does. Used by the ReportAdmin
     * templates.
     *
     * @var string
     */
    protected $description = 'View website login attempts';

    /**
     * The class of object being managed by this report.
     * Set by overriding in your subclass.
     */
    protected $dataClass = LoginAttempt::class;

    /**
     * Source records
     *
     * @param array $params URL parameters
     *
     * @return DataList
     */
    public function sourceRecords($params = null)
    {
        $attempts = LoginAttempt::get()->sort('Created', 'DESC');

        if (!empty($params['Status'])) {
            $attempts = $attempts->filter('Status', $params['Status']);
        }

        if (!empty($params['IP'])) {
            $attempts = $attempts->filter('IP:PartialMatch', $params['IP']);
        }

        return $attempts;
    }

    /**
     * Get report columns
     *
     * @return array
     */
    public function columns()
    {
        $fields = [
            'Created'         => 'Date',
            'GridFieldUser'   => 'User',
            'GridFieldStatus' => 'Status',
            'IP'              => 'IP Address',
        ];

        return $fields;
    }

    /**
     * Modify export fields
     *
     * @return GridField
     */
    public function getReportField()
    {
        $gridfield = parent::getReportField();

        $exportbtn = $gridfield
            ->getConfig()
            ->getComponentByType(GridFieldExportButton::class);

        if ($exportbtn) {
            $exportbtn->setExportColumns(
                [
                    'Created'       => 'Date',
                    'GridfieldUser' => 'User',
                    'Status'        => 'Status',
                    'IP'            => 'IP',
                ]
            );
        }

        return $gridfield;
    }

    /**
     * Add search parameters
     *
     * @return FieldList
     */
    public function parameterFields()
    {
        return FieldList::create(
            DropdownField::create(
                'Status',
                'Login status',
                [
                    'Success' => 'Success',
                    'Failure' => 'Failure',
                ]
            )->setEmptyString('All'),
            TextField::create(
                'IP',
                'IP address'
            )
        );
    }
}
