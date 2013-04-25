<?php

namespace Miweb\MiwebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Miweb\MiwebBundle\Form\ProductoType;

use Miweb\MiwebBundle\Entity\Producto;

use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    public function verproductosAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $productos = $em->getRepository('MiwebBundle:Producto')->findAll();
                
        return $this->render('MiwebBundle:Producto:ver.html.twig', array('productos'=>$productos));
    }

    public function buscarAction($name)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $productos = $em->getRepository('MiwebBundle:Producto')->findByName($name);
        
        return $this->render('MiwebBundle:Producto:ver.html.twig', array('productos'=>$productos ));
    }


    public function showdetallesAction($id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $producto = $em->getRepository('MiwebBundle:Producto')->find($id);
        $idCategoria= $producto->getCategoria()->getid();
        //$em->remove($categoria);
        //$em->flush();
        //return $this->redirect($this->generateUrl('categoria_vertodos'));
        return $this->render('MiwebBundle:Producto:showdetalles.html.twig', array('producto'=>$producto,'idCategoria'=>$idCategoria));
    }

    public function deleteAction($id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $categoria = $em->getRepository('MiwebBundle:Producto')->find($id);
        $em->remove($categoria);
        $em->flush();
        return $this->redirect($this->generateUrl('producto_listar'));
        //return $this->render('MiwebBundle:Categoria:ver.html.twig', array('categorias'=>$categorias));
    }
    public function nuevoAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm(new ProductoType(), $producto); 

        //lo siguiente se ejecuta si viene con Post
       if ($request->isMethod('POST')) 
       {
            $form->bind($request);

            if ($form->isValid()) {

           // realiza alguna accion, tal como guardar la tarea en la base de datos
               $em = $this->getDoctrine()->getManager();
               $em->persist($producto);
               $em->flush();

            //    $response = $this->forward('MiwebBundle:Categoria:showdetalles', array(
            //        'id'  => $categoria->getId(),
            //     ));
            //return $response;

           return $this->redirect($this->generateUrl('producto_listar'));
           //return new Response('Categoria creado de id:'.$categoria->getId());              
           }
       }
       // fin post

       return $this->render('MiwebBundle:Producto:nuevo.html.twig', array('form' => $form->createView()));
    }

    public function editarAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $producto = $em->getRepository('MiwebBundle:Producto')->find($id);

        $form = $this->createForm(new ProductoType(), $producto); 
        //$form->setData($categoria);

        //cuando se envia el formulario
        $request = $this->getRequest();

        //lo siguiente se ejecuta si viene con Post
       if ($request->isMethod('POST')) 
       {
            $form->bind($request);

            if ($form->isValid()) {

           // realiza alguna accion, tal como guardar la tarea en la base de datos
               //$em = $this->getDoctrine()->getManager();
               $em->persist($producto);
               $em->flush();

       // $response = $this->forward('MiwebBundle:Categoria:showdetalles', array(
        //'id'  => $id,
        //         ));
        //  return $response;

            return $this->redirect($this->generateUrl('producto_listar'));
           //return new Response('Categoria creado de id:'.$categoria->getId());              
           }
       }
       // fin post

       return $this->render('MiwebBundle:Producto:editar.html.twig', array('producto'=>$producto,'form' => $form->createView()));
    }
}
