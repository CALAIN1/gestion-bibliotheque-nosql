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

    #[Route("/add_livre", "GET")]
    public function addLivre()
    {
        return $this->render('add_livre');
    }

    #[Route("/emprunt", "GET")]
    public function emprunt()
    {
        return $this->render('emprunt');
    }
}
