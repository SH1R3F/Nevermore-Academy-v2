<?php

namespace App\SpreadSheets;

use App\SpreadSheets\GoogleSheet;
use Illuminate\Support\Manager;

class SpreadSheetManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('sheet.default', 'google');
    }

    /**
     * Create an instance of the Google sheet Driver.
     *
     * @return \App\SpreadSheets\GoogleSheet
     */
    public function createGoogleDriver()
    {
        return new GoogleSheet($this->config->get('sheet.google'));
    }
}
