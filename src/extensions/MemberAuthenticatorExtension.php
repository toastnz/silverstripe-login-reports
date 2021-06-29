<?php
namespace Axllent\LoginReports\Extensions;

use SilverStripe\Core\Extension;

class MemberAuthenticatorExtension extends Extension
{
    /**
     * Update login attempt
     *
     * This ensures that the login email is actually stored despite the
     * v5 deprecation. We want to keep this to track failed login attempts.
     *
     * @param LoginAttempt $attempt LoginAttempt object
     * @param array        $data    Post Data
     * @param HTTPRequest  $request HTTP request
     *
     * @return void
     */
    public function updateLoginAttempt(&$attempt, $data, $request)
    {
        if (!empty($data['Email'])) {
            $attempt->setField('Email', $data['Email']);
        }
    }
}
