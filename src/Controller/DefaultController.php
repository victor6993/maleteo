<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\UsuarioDemo;
use App\Entity\User;
use App\Form\OpinionForm;
use App\Form\RegisterForm;
use App\Form\UserForm;
use App\Security\FormAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class DefaultController extends AbstractController 
{

  /**
   * @Route("/", name="landing")
   */
  public function landing(Request $request, EntityManagerInterface $em, LoggerInterface $logger) 
  {
    $form = $this->createForm(UserForm::class);

    $form->handleRequest($request);

    try{
    $repo = $em->getRepository(Opinion::class);
    $opiniones = $repo->findAll();

    $codOpiniones = array_rand($opiniones, 3);

    for($i = 0; $i < 3; $i++) {
      $opinionesAleatorias[] = $opiniones[$codOpiniones[$i]];
    }

      $opinion1 = $opinionesAleatorias[0];
      $opinion2 = $opinionesAleatorias[1];
      $opinion3 = $opinionesAleatorias[2];
   
      return $this->render("maleteo/landing.html.twig", ['userForm' => $form->createView(), 'opinion1' => $opinion1, 'opinion2' => $opinion2, 'opinion3' => $opinion3 ]);
   
    } catch(\Exception $e) {
          
      $logger->error("Error cargando opiniones:: $e");
    }

  }

  /**
   * @Route("/newDemo", methods = {"POST"},  name = "new-demo")
   */
  public function saveNewDemo(Request $request, EntityManagerInterface $em,  LoggerInterface $logger) {
    $form = $this->createForm(UserForm::class);

    $form->handleRequest($request);

    $datos = json_decode($request->getContent(), true);

    try{
      $usuarioDemo = new UsuarioDemo();
      $usuarioDemo->setNombre($datos['nombre']);
      $usuarioDemo->setEmail($datos['email']);
      $usuarioDemo->setCiudad($datos['ciudad']);

      $em->persist($usuarioDemo);
      $em->flush();

      $this->addFlash('success', 'Solicitud enviada correctamente');
      $logger->info("Un usuario ha solicitado una demo");
          
    } catch(\Exception $e) {
          
      $logger->error("Error en el envío de datos:: $e");
      $this->addFlash('error', 'Error al enviar, vuelva a intentarlo');
    }

    return new JsonResponse(['msg'=> 'Solicitud enviada correctamente!']);

  }

  /**
   * @Route("/solicitudes", name="solicitudes")
   * @IsGranted("ROLE_ADMIN")
   */
  public function solicitud(EntityManagerInterface $em) 
  {
    $repo = $em->getRepository(UsuarioDemo::class);
    $solicitudesDemo = $repo->findAll();

    return $this->render("maleteo/solicitudes.html.twig", ['solicitudes' => $solicitudesDemo]);
  }

  /**
   * @Route("/solicitudes/{id}/borrar" , name = "borrarSolicitud")
   * @IsGranted("ROLE_ADMIN")
   */
  public function borrarSolicitud(UsuarioDemo $solicitudesDemo, EntityManagerInterface $em) {
    $em->remove($solicitudesDemo);
    $em->flush();

    return new RedirectResponse('/solicitudes');
  }

  /**
   * @Route("/comentar", name="comentar")
   * @IsGranted("ROLE_USER")
   */
  public function opiniones(EntityManagerInterface $em, Request $request, LoggerInterface $logger) 
  {

    $form = $this->createForm(OpinionForm::class);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      try{
        $dataOpinion = $form->getData();
        $opinion = new Opinion();
        $opinion->setComentario($dataOpinion['comentario']);
        $opinion->setAutor($dataOpinion['autor']);
        $opinion->setCiudad($dataOpinion['ciudad']);

        $em->persist($opinion);
        $em->flush($opinion);
        $logger->info("Un usuario ha solicitado una demo");
      } catch(\Exception $e) {
        $logger->error("Error en el envío de datos:: $e");
      }
      return $this->redirectToRoute('landing');
    }

    return $this->render("maleteo/comentar.html.twig", ['opinionForm' => $form->createView()]);
  }

    /**
   * @Route("/opiniones", name="listaOpiniones")
   * @IsGranted("ROLE_ADMIN")
   */
  public function listaSolicitudes(EntityManagerInterface $em) 
  {
    $repo = $em->getRepository(Opinion::class);
    $opiniones = $repo->findAll();

    return $this->render("maleteo/listaOpiniones.html.twig", ['opiniones' => $opiniones]);
  }

    /**
   * @Route("/opiniones/{id}/borrar" , name = "borrarOpinion")
   * @IsGranted("ROLE_ADMIN")
   */
  public function borrarOpinion(Opinion $opinion, EntityManagerInterface $em) {
    $em->remove($opinion);
    $em->flush();

    // return new RedirectResponse('/listaOpiniones');
    return $this->redirectToRoute('listaOpiniones');
  }

  
  /**
   * @Route("/register", name = "register")
   */
  public function register(Request $request, EntityManagerInterface $em, LoggerInterface $logger, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guard, FormAuthAuthenticator $formAuthenticator) 
  {
    
    $form = $this->createForm(RegisterForm::class);
    
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()) {
      try{
        $registroUsuario = $form->getData();
        $passwordCifrado = $passwordEncoder->encodePassword($registroUsuario, $registroUsuario->getPassword());
        $registroUsuario->setPassword($passwordCifrado);
        
        $em->persist($registroUsuario);
        $em->flush($registroUsuario);
        
        // $this->addFlash('success', 'Enviado correctamente');
        $logger->info("Un usuario se ha registrado");

        return $guard->authenticateUserAndHandleSuccess($registroUsuario, $request, $formAuthenticator, 'main');
        
      } catch(\Exception $e) {
        
        $logger->error("Error en el registro:: $e");
        $this->addFlash('error', 'El usuario ya existe!');
      }
      return $this->redirectToRoute('register');
    }

    return $this->render("maleteo/register.html.twig", ['registerForm' => $form->createView()]);
  }
  
  /**
   * @Route("/perfil/{user}", name = "perfil")
   */
  public function perfil(EntityManagerInterface $em, Request $request) 
  {
    $user = $request;
    $repo = $em->getRepository(User::class);
    $usuario = $repo->findOneBy(['username' => $user]);

    return $this->render("maleteo/perfil.html.twig");
  }

  /**
   * @Route("/politica-de-privacidad", name = "politica")
   */
  public function politica() 
  {
    return $this->render("maleteo/politica.html.twig");
  }

}
