<?php

namespace Miweb\MiwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Miweb\MiwebBundle\Form\CategoriaType;

use Miweb\MiwebBundle\Entity\Categoria;

use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends Controller
{
    public function vercategoriasAction()
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $categorias = $em->getRepository('MiwebBundle:Categoria')->findAll();
        
        //inicio paginador
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $categorias,
            $this->get('request')->query->get('page', 1)/*page number*/,
            4/*limit per page*/
            );

      return $this->render('MiwebBundle:Categoria:ver.html.twig', array('pagination' => $pagination));
      //return compact('pagination'); 
      //fin paginador
      //return $this->render('MiwebBundle:Categoria:ver.html.twig', array('categorias'=>$categorias));
    }

    public function deleteAction($id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $categoria = $em->getRepository('MiwebBundle:Categoria')->find($id);
        $em->remove($categoria);
        $em->flush();
        return $this->redirect($this->generateUrl('categoria_listar'));
        //return $this->render('MiwebBundle:Categoria:ver.html.twig', array('categorias'=>$categorias));
    }

    public function showdetallesAction($id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $categoria_verproductos = $em->getRepository('MiwebBundle:Categoria')->find($id);
        //$em->remove($categoria);
        //$em->flush();
        //return $this->redirect($this->generateUrl('categoria_vertodos'));
        return $this->render('MiwebBundle:Categoria:showdetalles.html.twig', array('categoria'=>$categoria_verproductos));
    }
 	
 	public function verproductosporcategoriaAction($id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $categoria = $em->getRepository('MiwebBundle:Categoria')->find($id);
        return $this->render('MiwebBundle:Categoria:verproductosporcategoria.html.twig', array('categoria'=>$categoria));
    }

    public function nuevoAction(Request $request)
    {   
        $categoria= new Categoria();
        $form = $this->createForm(new CategoriaType(), $categoria); 

        //lo siguiente se ejecuta si viene con Post
       if ($request->isMethod('POST')) 
       {
            $form->bind($request);

            if ($form->isValid()) {

           // realiza alguna accion, tal como guardar la tarea en la base de datos
               $em = $this->getDoctrine()->getManager();
            //para guardar la imagen
               $categoria->upload();
               $em->persist($categoria);
               $em->flush();

                $response = $this->forward('MiwebBundle:Categoria:showdetalles', array(
                    'id'  => $categoria->getId(),
                 ));
            return $response;

           //return $this->redirect($this->generateUrl('categoria_vertodos'));
           //return new Response('Categoria creado de id:'.$categoria->getId());              
           }
       }
       // fin post

       return $this->render('MiwebBundle:Categoria:nuevo.html.twig', array('form' => $form->createView()));
    }




    public function nuevopopupAction(Request $request)
    {   
        $categoria= new Categoria();
        $form = $this->createForm(new CategoriaType(), $categoria); 

        //lo siguiente se ejecuta si viene con Post
       if ($request->isMethod('POST')) 
       {
            $form->bind($request);

            if ($form->isValid()) {

           // realiza alguna accion, tal como guardar la tarea en la base de datos
               $em = $this->getDoctrine()->getManager();
               //para guardar la imagen
               //$categoria->upload();para sin retrollamdas al momento de subir images
               $em->persist($categoria);
               $em->flush();

               $response = $this->forward('MiwebBundle:Categoria:showdetalles', array(
                    'id'  => $categoria->getId(),
                 ));
            return $response;

            //return $this->redirect($this->generateUrl('categoria_vertodos'));
           //return new Response('Categoria creado de id:'.$categoria->getId());              
           }
       }
       // fin post

       return $this->render('MiwebBundle:Categoria:nuevopopup.html.twig', array('form' => $form->createView()));
    }



    public function editarAction($id)
    {   
        //$categoria= new Categoria();
        

        $em = $this->getDoctrine()->getEntityManager();
        $categoria = $em->getRepository('MiwebBundle:Categoria')->find($id);
        $form = $this->createForm(new CategoriaType(), $categoria); 
        //$form->setData($categoria); //opcional 

        //cuando se envia el formulario
        $request = $this->getRequest();

        //lo siguiente se ejecuta si viene con Post
       if ($request->isMethod('POST')) 
       {
            $form->bind($request);

            if ($form->isValid()) {

           // realiza alguna accion, tal como guardar la tarea en la base de datos
              //para guardar la imagen
              // $categoria->upload();  para sin retrollamdas al momento de subir images
               $em->persist($categoria);
               $em->flush();

        $response = $this->forward('MiwebBundle:Categoria:showdetalles', array(
        'id'  => $id,
                 ));
          return $response;
           //return $this->redirect($this->generateUrl('categoria_vertodos'));
           //return new Response('Categoria creado de id:'.$categoria->getId());              
           }
       }
       // fin post

       return $this->render('MiwebBundle:Categoria:editar.html.twig', array('categoria'=>$categoria,'form' => $form->createView()));
    }

    public function orderbynameAction ()
    {
      $em = $this->getDoctrine()->getManager();
      $categorias = $em->getRepository('MiwebBundle:Categoria')->findAllOrderedByName();

              //inicio paginador
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $categorias,
            $this->get('request')->query->get('page', 1)/*page number*/,
            4/*limit per page*/
            );

      return $this->render('MiwebBundle:Categoria:ver.html.twig', array('pagination' => $pagination));
    }
 
}
