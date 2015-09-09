<?php

namespace Bh\Page;

class HTML
{
    // {{{ tag
    static public function tag($name, $first = null, $second = null)
    {
        if (empty($name)) {
            // @todo clean
            throw new \Exception('unnamed html tag');
        }

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

        if (empty($content)) {
            $markup = '<' . $name . self::renderAttributes($attributes) . '/>';
        } else {
            $markup = '<' . $name . self::renderAttributes($attributes) . '>' . $content . '</' . $name . '>';
        }

        return $markup;
    }
    // }}}
    // {{{ noEndTag
    static public function noEndTag($name, $attributes = [])
    {
        if (empty($name)) {
            // @todo clean
            throw new \Exception('unnamed html tag');
        }

        $markup = '<' . $name . self::renderAttributes($attributes) . '>';

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

    // {{{ html
    static public function html($first = null, $second = null)
    {
        return self::tag('html', $first, $second);
    }
    // }}}
    // {{{ title
    static public function title($first = null, $second = null)
    {
        return self::tag('title', $first, $second);
    }
    // }}}
    // {{{ head
    static public function head($first = null, $second = null)
    {
        return self::tag('head', $first, $second);
    }
    // }}}
    // {{{ body
    static public function body($first = null, $second = null)
    {
        return self::tag('body', $first, $second);
    }
    // }}}
    // {{{ a
    static public function a($first = null, $second = null)
    {
        return self::tag('a', $first, $second);
    }
    // }}}
    // {{{ p
    static public function p($first = null, $second = null)
    {
        return self::tag('p', $first, $second);
    }
    // }}}
    // {{{ label
    static public function label($first = null, $second = null)
    {
        return self::tag('label', $first, $second);
    }
    // }}}
    // {{{ img
    static public function img($first = null, $second = null)
    {
        return self::tag('img', $first, $second);
    }
    // }}}
    // {{{ div
    static public function div($first = null, $second = null)
    {
        return self::tag('div', $first, $second);
    }
    // }}}
    // {{{ span
    static public function span($first = null, $second = null)
    {
        return self::tag('span', $first, $second);
    }
    // }}}

    // {{{ meta
    static public function meta($attributes = null)
    {
        return self::noEndTag('meta', $attributes);
    }
    // }}}
    // {{{ link
    static public function link($attributes = null)
    {
        return self::noEndTag('link', $attributes);
    }
    // }}}

    // {{{ menu
    static public function menu($links)
    {
        $menu = '';
        foreach ($links as $title => $link) {
            $menu .= Html::a('href="' . $link . '"', $title);
        }

        return Html::div('id="menu"', $menu);
    }
    // }}}
}
