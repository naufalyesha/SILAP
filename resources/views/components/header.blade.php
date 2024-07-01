// File: app/View/Components/Header.php
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.header');
    }
}
