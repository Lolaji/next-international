<?php

namespace App\Policies;

use App\SiteSettings;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteSettingsPolicy
{
    use HandlesAuthorization;

    public function before ($user, $ability) {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view (SiteSettings $siteSettings) {
        if ($siteSettings->in_maintenance()) {
            return false;
        }
        return true;
    }
}
