<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\Usuario;
use App\Entity\UsuarioDemo;
use App\Form\LoginForm;
use App\Form\OpinionForm;
use App\Form\RegisterForm;
use App\Form\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController 
{

  /**
   * @Route("/", name="landing")
   */
  public function landing(Request $request, EntityManagerInterface $em, LoggerInterface $logger) 
  {
    $form = $this->createForm(UserForm::class);

    $form->handleRequest($request);

    $repo = $em->getRepository(Opinion::class);
    $opiniones = $repo->findAll();

    $codOpiniones = array_rand($opiniones, 3);

    for($i = 0; $i < 3; $i++) {
      $opinionesAleatorias[] = $opiniones[$codOpiniones[$i]];
    }

      $opinion1 = $opinionesAleatorias[0];
      $opinion2 = $opinionesAleatorias[1];
      $opinion3 = $opinionesAleatorias[2];
    
    if($form->isSubmitted() && $form->isValid()) {
      try{
        $dataUsuarioDemo = $form->getData();

        $usuarioDemo = new UsuarioDemo();
        $usuarioDemo->setNombre($dataUsuarioDemo['nombre']);
        $usuarioDemo->setEmail($dataUsuarioDemo['email']);
        $usuarioDemo->setCiudad($dataUsuarioDemo['ciudad']);

        $em->persist($usuarioDemo);
        $em->flush($usuarioDemo);
        $this->addFlash('success', 'Enviado correctamente');
        $logger->info("Un usuario ha solicitado una demo");

        return $this->redirectToRoute('success');
      } catch(\Exception $e) {
        $logger->error("Error en el envío de datos:: $e");
        $this->addFlash('error', 'Error al enviar los datos, vuelva a intentarlo');
      }
    }

    return $this->render("maleteo/landing.html.twig", ['userForm' => $form->createView(), 'opinion1' => $opinion1, 'opinion2' => $opinion2, 'opinion3' => $opinion3 ]);
  }

  /**
   * @Route("/solicitudes", name="solicitudes")
   */
  public function solicitud(EntityManagerInterface $em) 
  {
    $repo = $em->getRepository(UsuarioDemo::class);
    $solicitudesDemo = $repo->findAll();

    return $this->render("maleteo/solicitudes.html.twig", ['solicitudes' => $solicitudesDemo]);
  }

  /**
   * @Route("/opiniones", name="opiniones")
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
        $this->addFlash('success', 'Enviado correctamente');
        $logger->info("Un usuario ha solicitado una demo");
      } catch(\Exception $e) {
        $logger->error("Error en el envío de datos:: $e");
        $this->addFlash('error', 'Error al enviar los datos, vuelva a intentarlo');
      }
      return $this->redirectToRoute('landing');
    }

    return $this->render("maleteo/opinion.html.twig", ['opinionForm' => $form->createView()]);
  }

  /**
   * @Route("/maleteo/login", name="login")
   */
  public function login(EntityManagerInterface $em, Request $request, LoggerInterface $logger) 
  {

    $form = $this->createForm(LoginForm::class);

    $form->handleRequest($request);

    
    if($form->isSubmitted() && $form->isValid()) {
      $dataUsuario = $form->getData();
      
      $repo = $em->getRepository(Usuario::class);

      $dataUsuario1 = $repo->findOneBy(['email'=> $dataUsuario['username'], 'password' => $dataUsuario['password']]);

      $dataUsuario2 = $repo->findOneBy(['username'=> $dataUsuario['username'], 'password' => $dataUsuario['password']]);

      if($dataUsuario1 !== null || $dataUsuario2 !== null) {
        return $this->redirectToRoute('landing');
      } else {
        return $this->redirectToRoute('register');
      }
    }
        return $this->render("maleteo/login.html.twig", ['loginForm' => $form->createView()]); //, 'usuarioActual' => $datosUsuario]);

  }

  /**
   * @Route("/register", name = "register")
   */
  public function register(Request $request, EntityManagerInterface $em, LoggerInterface $logger) 
  {
    
    $form = $this->createForm(RegisterForm::class);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      try{
        $registroUsuario = $form->getData();

        $em->persist($registroUsuario);
        $em->flush($registroUsuario);

        $this->addFlash('success', 'Enviado correctamente');
        $logger->info("Un usuario ha solicitado una demo");

      } catch(\Exception $e) {

        $logger->error("Error en el envío de datos:: $e");
        $this->addFlash('error', 'Error al enviar los datos, vuelva a intentarlo');
      }
      return $this->redirectToRoute('landing');
    }

    return $this->render("maleteo/register.html.twig", ['registerForm' => $form->createView()]);
  }

  /**
   * @Route("/politica-de-privacidad", name = "politica")
   */
  public function politica() 
  {
    return $this->render("maleteo/politica.html.twig");
  }

  /**
   * @Route("/success", name = "success")
   */
  public function success() 
  {
    return $this->render('maleteo/success.html.twig');
  }
}