<?php

use App\Core\BaseController;
use App\Core\Route;

class ViewsController extends BaseController
{
    #[Route("/", "GET")]
    public function index()
    {
        return $this->render('home');
    }
}
