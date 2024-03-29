<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
// use App\Entity\UsuarioDemo;
// use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('nombre', TextType::class, [ 'attr' => ['placeholder' => 'Nombre y apellidos', 'label'=> 'Nombre', 'required' => true,]]);
    $builder->add('email', EmailType::class, [ 'attr' => ['placeholder' => 'Dirección de email', 'label'=> 'Email', 'required' => true,]]);
    $builder->add('ciudad', ChoiceType::class, [
      'choices' => [
      'Madrid' => 'Madrid',
      'Barcelona' => 'Barcelona',
      'Sevilla' => 'Sevilla'
      ],
      'placeholder' => 'Elige tu ciudad', 'label'=> 'Ciudad', 'required' => true,
      ]);
      $builder->add('politica', CheckboxType::class, [
        'label'    => 'Acepto la ',
        'required' => true,
    ]);
  }

  // public function configureOptions(OptionsResolver $resolver)
  // {
  //   $resolver->setDefaults(['data_class'=> UsuarioDemo::class]);
  // }

} 