<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Tests\Extension\Core\Type\CheckboxTypeTest;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\RepeatedTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
       $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $logedUser = $this->tokenStorage->getToken()->getUser();
        $usr_roles =  array(
            'User' => '3');
        if($logedUser->getRole()->getId() == 1) {
            $usr_roles = array('Globla_Admin' => 1,
                'Admin' => 2,
                'User' => 3);
            $builder
                ->add('storeId');
        }
        else
        {
            $builder->add('storeId',TextType::class,array('disabled'=> true,));
        }
        $builder
            ->add('username')
            ->add('password',RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                )
            )->add('givenName')
            ->add('surName')
            ->add('email')
            ->add('isActive', CheckboxType::class, array('data' => true,));
          //  ->add('role', ChoiceType::class, array('choices'=>$usr_roles,));
              if($logedUser->getRole()->getId()==1) {
                  $builder->add('role', EntityType::class, array(
                      'class' => 'AppBundle:Role', 'choice_label' => 'name'));
              }

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
