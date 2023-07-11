<?php

namespace Nitsan\NsGuestbook\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
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
