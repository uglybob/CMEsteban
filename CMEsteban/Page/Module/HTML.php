<?php

namespace Bh\Page\Module;

class HTML
{
    // {{{ variables
    protected static $voidTags = [
        'img',
        'meta',
        'link',
        'br',
    ];
    protected static $nonVoidTags = [
        'html',
        'title',
        'head',
        'body',
        'a',
        'p',
        'label',
        'div',
        'span',
        'script',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'iframe',
    ];
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
            // @todo custom exception
            throw new \Exception("Call to undefined method Bh\Page\HTML::$name()");
        }

        return $result;
    }
    // }}}

    // {{{ tag
    protected static function tag($name, $void, $first = null, $second = null)
    {
        if (empty($name)) {
            // @todo custom exception
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
            // @todo custom exception
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
    protected static function renderAttributes($attributes)
    {
        $list = [];

        if (!empty($attributes)) {
            foreach ($attributes as $name => $value) {
                if (is_int($name) && strlen($value) > 1) {
                    if ($value[0] == '.') {
                        $list['class'][] = substr($value, 1);
                    } else if ($value[0] == '#') {
                        $list['id'][] = substr($value, 1);
                    } else {
                        throw new \Exception('unknown selector');
                    }
                } else if (is_string($name) && is_string($value)) {
                    $list[$name][] = $value;
                } else {
                    throw new \Exception('invalid attributes');
                }
            }
        }

        $renderedAttributes = '';

        foreach ($list as $name => $attributes) {
            $renderedAttributes .= ' ' . $name . '="' . implode(' ', $attributes) . '"';
        }

        return $renderedAttributes;
    }
    // }}}
    // {{{ formatArgument
    protected static function formatArgument($argument)
    {
        if (is_array($argument) || is_null($argument)) {
            $result = $argument;
        } else {
            $result = (string) $argument;
        }

        return $result;
    }
    // }}}

    // {{{ menu
    public static function menu($links)
    {
        $menu = '';

        foreach ($links as $title => $link) {
            $menu .= Html::a(['href' => $link], $title);
        }

        return Html::div(['class' => 'menu'], $menu);
    }
    // }}}
}
