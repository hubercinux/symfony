<?php

namespace Miweb\MiwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuarioController extends Controller
{
    public function loginAction()
    {
        return $this->render('MiwebBundle:Usuario:login.html.twig');
    }

}
