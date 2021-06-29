<?php
namespace Axllent\LoginReports\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Security\LoginAttempt;

class MemberExtension extends Extension
{
    /**
     * Update CMS fields
     *
     * @param FieldList $fields Fields
     *
     * @return FieldList
     */
    public function updateCMSFields(\SilverStripe\Forms\FieldList $fields)
    {
        $config = GridFieldConfig_Base::create(50);

        $config->getComponentByType(GridFieldDataColumns::class)
            ->setDisplayFields(
                [
                    'Created'         => 'Date',
                    'GridFieldStatus' => 'Status',
                    'IP'              => 'IP Address',
                ]
            );

        $fields->addFieldsToTab(
            'Root.LoginReports',
            [
                GridField::create(
                    'LoginReports',
                    'Login attempts',
                    LoginAttempt::get()
                        ->filter('MemberID', $this->owner->ID)
                        ->sort('Created', 'DESC'),
                    $config
                ),
            ]
        );

        return $fields;
    }

}
