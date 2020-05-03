<?php

namespace App\Components\Blade;

/**
 * Class Blade
 * @package App\Components\Blade
 */
class Blade
{
    /**
     * @var BladeDirectiveInterface[] $directives
     */
    private array $directives = [

        CurlBracesDirective::class,
        IfDirective::class,
        EndifDirective::class,
        ForDirective::class,
        EndForDirective::class,
        PhpDirective::class,
        EndPhpDirective::class,
        ElseDirective::class,
        ElseIfDirective::class,
        ForeachDirective::class,
        EndforeachDirective::class,
        IncludeDirective::class,
        CurlBracesAllowedHtmlChars::class,
        CompressBlade::class,
        JsEscapeDirective::class,
        CommentDirective::class

    ];


    /**
     *
     * @param $template
     * @return mixed
     *
     */
    public function render($template)
    {
        return array_reduce($this->directives, static function ($template, $class) {
            /**
             * @var BladeDirectiveInterface $object
             */
            $object = new $class();
            return $object->replaceTemplate($template);
        }, $template);
    }
}
