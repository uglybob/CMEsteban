<?php

namespace CMEsteban\Page\Module;

class Audio extends Module
{
    protected $sources;

    public function __construct($sources, $controls = true)
    {
        $this->sources = $sources;
        $this->controls = $controls;

        parent::__construct();
    }

    protected function render()
    {
        $sources = '';

        foreach ($this->sources as $src => $type) {
            $sources .= HTML::source([
                'src' => $src,
                'type' => $type,
            ]);
        }

        return HTML::div(['.caudio'],
            HTML::audio(['controls' => 'controls'], $sources)
        );
    }
}
