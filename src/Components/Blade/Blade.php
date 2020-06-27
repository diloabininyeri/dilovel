<?php

namespace App\Components\Blade;

use Closure;

/**
 * Class Blade
 * @package App\Components\Blade
 */
class Blade extends AbstractBlade
{
    protected static array  $dynamicDirectives=[];
    /**
     * @var BladeDirectiveInterface[] $directives
     */
    protected array $directives = [

        CommentDirective::class,
        CsrfDirective::class,
        ExtendsDirective::class,
        YieldDirective::class,
        IncludeDirective::class,
        CurlBracesDirective::class,
        RemoveYields::class,
        RemoveSectionDirective::class,
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
        CurlBracesAllowedHtmlChars::class,
        AuthDirective::class,
        EndAuthDirective::class,
        MobileDirective::class,
        EndMobileDirective::class,
        CustomDirective::class,
        CompressBlade::class,
        JsEscapeDirective::class,

    ];


    /**
     * @return array
     */
    public function getDynamicDirectives(): array
    {
        return self::$dynamicDirectives;
    }

    /**
     * @param string $directive
     * @param Closure $closure
     */
    public static function directive(string $directive, Closure $closure):void
    {
        self::$dynamicDirectives[$directive]=$closure;
    }
}
