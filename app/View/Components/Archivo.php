<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Archivo extends Component
{
    public $archivo;
    public $tipo;
    public $idPost;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($archivo,$tipo,$idPost)
    {
        $this->archivo = $archivo;
        $this->tipo = $tipo;
        $this->idPost = $idPost;
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
