<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Archivo extends Component
{
    public $archivo;
    public $tipo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($archivo,$tipo)
    {
        $this->archivo = $archivo;
        $this->tipo = $tipo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.archivo');
    }
}
