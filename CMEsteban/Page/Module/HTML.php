<?php

namespace CMEsteban\Page\Module;

class HTML
{
    protected static $voidTags = [
        'br',
        'img',
        'link',
        'meta',
    ];
    protected static $nonVoidTags = [
        'a',
        'body',
        'div',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'head',
        'html',
        'iframe',
        'label',
        'li',
        'nav',
        'p',
        'script',
        'span',
        'title',
        'ul',
    ];

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
            throw new \Exception("Call to undefined method CMEsteban\Page\HTML::$name()");
        }

        return $result;
    }

    protected static function tag($name, bool $void, $first = null, $second = null)
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
    protected static function formatArgument($argument)
    {
        if (is_array($argument) || is_null($argument)) {
            $result = $argument;
        } else {
            $result = (string) $argument;
        }

        return $result;
    }
}
