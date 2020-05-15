<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('username', TextType::class, ['attr'=> ['placeholder' => 'Nombre de usuario', 'required' => true]]);
    $builder->add('password', PasswordType::class, [ 'attr' => ['placeholder' => 'Contraseña', 'required' => true]]);
    $builder->add('nombre', TextType::class, [ 'attr' => ['placeholder' => 'Nombre y apellidos', 'required' => true]]);
    $builder->add('email', EmailType::class, [ 'attr' => ['placeholder' => 'Dirección de email', 'required' => true]]);
    $builder->add('telefono', TextType::class, ['attr' => ['placeholder' => 'Teléfono (opcional)', 'required' => false]]);
    $builder->add('direccion', TextType::class, ['attr' => ['placeholder' => 'Dirección (opcional)', 'required' => false]]);
    $builder->add('ciudad', ChoiceType::class, [
      'choices' => [
      'Madrid' => 'Madrid',
      'Barcelona' => 'Barcelona',
      'Sevilla' => 'Sevilla'
      ],
      'placeholder' => 'Elige tu ciudad', 'required' => true
    ]);
    $builder->add('politica', CheckboxType::class, [
      'label'    => 'Acepto la ',
      'required' => true,
    ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(['data_class'=> User::class]);
  }

} 