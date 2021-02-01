<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UsuarioRepository;


use App\Entity\Usuario;

/**
 * @Rest\Route("/prueba")
 */

 class cursoController extends AbstractFOSRestController

 {
   
    /**
     * @Rest\Get("/ingreso", name="ingreso")
     */
    public function ingreso(Request $request){
        return $this->render("login.html.twig");      
    }

    /**
     * @Rest\Post("/login_curso", name="login_curso_symfony")
     * @Rest\RequestParam(name="email", description="email del usuario", strict=false, nullable=true)
     * @Rest\RequestParam(name="password", description="password del usuario", strict=false, nullable=true)
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function login(Request $request, ParamFetcherInterface $paramFetcher){
        //Obtengo los parametros del Request (Del formulario)
        $email = $paramFetcher->get('email');
        $password = $paramFetcher->get('password');
        //Obtengo el entity Manager
        $em = $this->getDoctrine()->getManager();
        //Obtengo el repositorio de usuario
        $repositorio = $this->getDoctrine()->getRepository(Usuario::class);
        //Busco el usuario con los datos ingresados por el formulario
        $usuarioLogueado = $repositorio->findOneBy([
            "email" => $email,
            "password" => $password
        ]);
        if(!empty($usuarioLogueado)){
            $respuesta = ["mensaje" => 'El usuario se conecto al sistema'];
        }else{
            $respuesta = ["mensaje" => 'Las credenciales ingresadas son incorrectas'];
        }
        return $this->render("respuesta.html.twig", $respuesta);
    }
    

   

    
}