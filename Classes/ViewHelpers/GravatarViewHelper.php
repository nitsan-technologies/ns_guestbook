<?php

namespace Nitsan\NsGuestbook\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $versionNumber =  VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getCurrentTypo3Version());
        if ($versionNumber['version_main'] <= '13') {
            // @extensionScannerIgnoreLine
            $this->registerUniversalTagAttributes();
        }
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
    }

    public function render(): string
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($this->arguments['emailAddress'])));
        $url .= "?s=80&d=404&r=g";
        $file_headers = @get_headers($url);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $url = "";
        }
        return $url;
    }
}
