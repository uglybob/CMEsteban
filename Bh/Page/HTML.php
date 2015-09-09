<?php

namespace Bh\Page;

class HTML
{
    // {{{ tag
    static public function tag($name, $void, $first = null, $second = null)
    {
        if (empty($name)) {
            // @todo clean
            throw new \Exception('unnamed html tag');
        }

        $first = self::formatArgument($first);
        $escond = self::formatArgument($second);

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
        if (is_object($argument)) {
            $result = $argument->__toString();
        } else if (
            is_string($argument)
            || is_array($argument)
            || is_null($argument)
        ) {
            $result = $argument;
        } else {
            $result = (string) $argument;
        }

        return $result;
    }
    // }}}

    // {{{ html
    static public function html($first = null, $second = null)
    {
        return self::tag('html', false, $first, $second);
    }
    // }}}
    // {{{ title
    static public function title($first = null, $second = null)
    {
        return self::tag('title', false, $first, $second);
    }
    // }}}
    // {{{ head
    static public function head($first = null, $second = null)
    {
        return self::tag('head', false, $first, $second);
    }
    // }}}
    // {{{ body
    static public function body($first = null, $second = null)
    {
        return self::tag('body', false, $first, $second);
    }
    // }}}
    // {{{ a
    static public function a($first = null, $second = null)
    {
        return self::tag('a', false, $first, $second);
    }
    // }}}
    // {{{ p
    static public function p($first = null, $second = null)
    {
        return self::tag('p', false, $first, $second);
    }
    // }}}
    // {{{ label
    static public function label($first = null, $second = null)
    {
        return self::tag('label', false, $first, $second);
    }
    // }}}
    // {{{ div
    static public function div($first = null, $second = null)
    {
        return self::tag('div', false, $first, $second);
    }
    // }}}
    // {{{ span
    static public function span($first = null, $second = null)
    {
        return self::tag('span', false, $first, $second);
    }
    // }}}

    // {{{ img
    static public function img($first = null, $second = null)
    {
        return self::tag('img', true, $first, $second);
    }
    // }}}
    // {{{ meta
    static public function meta($attributes = null)
    {
        return self::tag('meta', true, $attributes);
    }
    // }}}
    // {{{ link
    static public function link($attributes = null)
    {
        return self::tag('link', true, $attributes);
    }
    // }}}

    // {{{ menu
    static public function menu($links)
    {
        $menu = '';
        foreach ($links as $title => $link) {
            $menu .= Html::a(['href' => $link], $title);
        }

        return Html::div(['id' => 'menu'], $menu);
    }
    // }}}
}
