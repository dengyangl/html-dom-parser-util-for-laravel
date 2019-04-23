<?php

namespace HtmlDomParser\Util\Facades;

use Illuminate\Support\Facades\Facade;

class HtmlDomParserUtil extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance('HtmlDomParserUtil');

        return 'HtmlDomParserUtil';
    }
}
