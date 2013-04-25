<?php

namespace Miweb\MiwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MiwebBundle:Default:index.html.twig');
    }

    public function vercategoriaAction()
    {
        return $this->render('MiwebBundle:Default:categoria.html.twig');
    }
    public function verproductoAction()
    {
        return $this->render('MiwebBundle:Default:producto.html.twig');
    }

}
