<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class Impersonation extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    
    $builder->add('usuario', TextType::class, [ 'attr' => ['placeholder' => 'Nombre del usuario', 'label'=> 'Usuario', 'required' => true]]);
   
  }

} 