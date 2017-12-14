<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $p_rep; //portfolio repository
    protected $s_rep; //slider repository
    protected $a_rep; //articles repository
    protected $m_rep; // menu repository

    protected $template; //имя шаблона

    protected $vars = array(); //передаваемые переменные

    protected $bar = false; //sidebar

    protected $contentRigtBar = false;
    protected $contentLeftBar = false;

    public function __construct()
    {

    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->vars);
    }

}
