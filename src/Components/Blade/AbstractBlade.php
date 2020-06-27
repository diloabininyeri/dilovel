<?php


namespace App\Components\Blade;

/**
 * Class AbstractBlade
 * @package App\Components\Blade
 */
abstract class AbstractBlade
{
    private ?string $template=null;
    /**
     * @param $template
     * @return mixed|null
     */
    final public function render($template)
    {
        return $this->template=array_reduce($this->directives, static function ($template, $class) {
            /**
             * @var BladeDirectiveInterface $object
             */
            $object = new $class();
            return $object->replaceTemplate($template);
        }, $template);
    }


    /**
     * @return string
     */
    final public function renderWithCustomDirective():string
    {
        foreach ($this->getDynamicDirectives() as $directive=>$closure) {
            $this->template= preg_replace_callback("/@$directive\((.*)\)/", $closure, $this->template);
        }
        return $this->template;
    }
}
