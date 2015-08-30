<?php

namespace Bh\Lib;

class Html
{
    // {{{ tag
    static public function tag($name, $attributes = '', $content = '')
    {
        if ($name == false) {
            // @todo clean
            throw new Exception('unnamed html tag');
        }

        if ($content === '') {
            $markup = '<' . $name . self::renderAttributes($attributes) . '/>';
        } else {
            $markup = '<' . $name . self::renderAttributes($attributes) . '>' . $content . '</' . $name . '>';
        }

        return $markup;
    }
    // }}}
    // {{{ noEndTag
    static public function noEndTag($name, $attributes = '')
    {
        if ($name == false) {
            // @todo clean
            throw new Exception('unnamed html tag');
        }

        $markup = '<' . $name . self::renderAttributes($attributes) . '>';

        return $markup;
    }
    // }}}

    // {{{ renderAttributes
    static protected function renderAttributes($attributes) {
        if ($attributes === '') {
            $renderedAttributes = '';
        } else {
            $renderedAttributes = ' ' . $attributes;
        }

        return $renderedAttributes;
    }
    // }}}

    // {{{ html
    static public function html($attributes = '', $content = '')
    {
        return self::tag('html', $attributes, $content);
    }
    // }}}
    // {{{ title
    static public function title($attributes = '', $content = '')
    {
        return self::tag('title', $attributes, $content);
    }
    // }}}
    // {{{ head
    static public function head($attributes = '', $content = '')
    {
        return self::tag('head', $attributes, $content);
    }
    // }}}
    // {{{ body
    static public function body($attributes = '', $content = '')
    {
        return self::tag('body', $attributes, $content);
    }
    // }}}
    // {{{ a
    static public function a($attributes = '', $content = '')
    {
        return self::tag('a', $attributes, $content);
    }
    // }}}
    // {{{ p
    static public function p($attributes = '', $content = '')
    {
        return self::tag('p', $attributes, $content);
    }
    // }}}
    // {{{ label
    static public function label($attributes = '', $content = '')
    {
        return self::tag('label', $attributes, $content);
    }
    // }}}
    // {{{ img
    static public function img($attributes = '', $content = '')
    {
        return self::tag('img', $attributes, $content);
    }
    // }}}
    // {{{ div
    static public function div($attributes = '', $content = '')
    {
        return self::tag('div', $attributes, $content);
    }
    // }}}
    // {{{ span
    static public function span($attributes = '', $content = '')
    {
        return self::tag('span', $attributes, $content);
    }
    // }}}

    // {{{ meta
    static public function meta($attributes = '')
    {
        return self::noEndTag('meta', $attributes);
    }
    // }}}
    // {{{ link
    static public function link($attributes = '')
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
