<?php


namespace App\Components\Flash;

use App\Components\Traits\Singleton;

/**
 * Class HtmlFormValuesStorage
 * @package App\Components\Flash
 */
class HtmlFormValuesStorage
{
    use FlashSessionTrait,Singleton;

    /**
     * @var string $prefix
     */
    private string $prefix = 'html_form_values_';
}
