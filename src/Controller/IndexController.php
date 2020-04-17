<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){
        return $this->render('content/homepage.html.twig');
    }

    /**
     * @Route("/loggedin", name="app_homepage_loggedin")
     */
    public function homepage_loggedin(){
        return $this->render('content/homepage_loggedin.html.twig');
    }

    /**
     * @Route("profil", name="app_profil")
     */
    public function profil(){
        return $this->render('content/profil.html.twig');
    }
}