<?php

namespace Bh\Page;

class HTML
{
    // {{{ variables
    protected static $voidTags = ['img', 'meta', 'link'];
    protected static $nonVoidTags = ['html', 'title', 'head', 'body', 'a', 'p', 'label', 'div', 'span'];
    // }}}
    // {{{ tag
    static protected function tag($name, $void, $first = null, $second = null)
    {
        if (empty($name)) {
            // @todo clean
            throw new \Exception('unnamed html tag');
        }

        $first = self::formatArgument($first);
        $second = self::formatArgument($second);

        if (is_array($first) && (is_string($second) || is_null($second))) {
            $attributes = $first;
            $content = $second;
        } else if (is_null($second) && (is_string($first) || is_null($first))) {
            $content = $first;
            $attributes = $second;
        } else {
            // @todo clean
            throw new \Exception('invalid tag signature');
        }

        if (empty($content) && $void) {
            $markup = '<' . $name . self::renderAttributes($attributes) . ' />';
        } else {
            $markup = '<' . $name . self::renderAttributes($attributes) . '>' . $content . '</' . $name . '>';
        }

        return $markup;
    }
    // }}}

    // {{{ renderAttributes
    static protected function renderAttributes($attributes) {
        $renderedAttributes = '';

        if (!empty($attributes)) {
            foreach ($attributes as $name => $value) {
                $renderedAttributes .= " $name=\"$value\"";
            }
        }

        return $renderedAttributes;
    }
    // }}}
    // {{{ formatArgument
    static protected function formatArgument($argument) {
        if (is_array($argument) || is_null($argument)) {
            $result = $argument;
        } else {
            $result = (string) $argument;
        }

        return $result;
    }
    // }}}

    // {{{ callStatic
    public static function __callStatic($name, $arguments)
    {
        $result = null;
        $first = (isset($arguments[0])) ? $arguments[0] : null;
        $second = (isset($arguments[1])) ? $arguments[1] : null;

        if (in_array($name, self::$nonVoidTags)) {
            $result = self::tag($name, false, $first, $second);
        } else if (in_array($name, self::$voidTags)) {
            $result = self::tag($name, true, $first, $second);
        } else {
            throw new \Exception("Call to undefined method Bh\Page\HTML::$name()");
        }

        return $result;
    }
    // }}}
    // {{{ menu
    static public function menu($links)
    {
        $menu = '';
        foreach ($links as $title => $link) {
            $menu .= Html::a(['href' => $link], $title);
        }

        return Html::div(['class' => 'menu'], $menu);
    }
    // }}}
}
