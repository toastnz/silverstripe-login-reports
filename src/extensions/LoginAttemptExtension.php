<?php
namespace Axllent\LoginReports\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLVarchar;

class LoginAttemptExtension extends Extension
{
    /**
     * Database field definitions.
     *
     * @var    array
     * @config
     */
    private static $db = [
        // This is set to be removed in 5 but it is very handy
        // to have for reporting of failed login attempts
        'Email' => 'Varchar(200)',
    ];

    /**
     * Searchable fields
     *
     * @var array
     */
    private static $searchable_fields = [
        'Status',
        'IP',
    ];

    /**
     * Get GridField status - returns coloured values
     *
     * @return DBHTMLVarchar
     */
    public function getGridFieldStatus()
    {
        $colour = $this->owner->Status == 'Success'
        ? 'text-success' : 'text-danger';

        return DBHTMLVarchar::create()
            ->setValue(
                '<span class="' . $colour . '">' .
                htmlspecialchars($this->owner->Status) . '</span>'
            );
    }

    /**
     * Get GridField email
     *
     * @return string
     */
    public function getGridFieldUser()
    {
        $user   = '[ unknown ]';
        $member = $this->owner->Member();

        if ($member->exists()) {
            $user = $member->Email;
        } elseif ($this->owner->Email) {
            $user = $this->owner->Email;
        }

        return $user;
    }

}
