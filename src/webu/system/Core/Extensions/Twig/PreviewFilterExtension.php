<?php declare(strict_types=1);

namespace webu\system\Core\Extensions\Twig;


use webu\system\Core\Base\Extensions\Twig\FilterExtension;
use webu\system\Core\Contents\Modules\Module;
use webu\system\Core\Contents\Modules\ModuleAction;
use webu\system\Core\Contents\Modules\ModuleCollection;
use webu\system\Core\Contents\Modules\ModuleController;
use webu\system\Core\Helper\FrameworkHelper\CUriConverter;
use webu\system\Core\Helper\RoutingHelper;

class PreviewFilterExtension extends FilterExtension
{

    /**
     * @return string
     */
    protected function getFilterName(): string
    {
        return "preview";
    }

    /**
     * @return callable
     */
    protected function getFilterFunction(): callable
    {
        return function($text, int $length) {

            $trimmedText = trim(substr($text, 0, $length));

            if(strlen($text) > $length) {
                $trimmedText .= "...";
            }

            return $trimmedText;
        };
    }

    /**
     * @return array
     */
    protected function getFilterOptions(): array
    {
        return [];
    }
}