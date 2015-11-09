<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'pattern'     => '.{2,}' //minlength
                )
            ))
            ->add('company', 'text', array(
                'attr' => array(
                    'pattern'     => '.{3,}' //minlength
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                )
            ))
            ->add('subject', 'text', array(
                'attr' => array(
                    'pattern'     => '.{3,}' //minlength
                )
            ))
            ->add('phone', 'text', array(
                'attr' => array(
                    'pattern'     => '.{3,}' //minlength
                )
            ))
            ->add('comment', 'textarea', array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Name should not be blank.')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'subject' => array(
                new NotBlank(array('message' => 'Subject should not be blank.')),
                new Length(array('min' => 3))
            ),
            'company' => array(
                new NotBlank(array('message' => 'Company should not be blank.')),
                new Length(array('min' => 3))
            ),
            'phone' => array(
                new NotBlank(array('message' => 'Phone should not be blank.')),
                new Length(array('min' => 3))
            ),
            'comment' => array(
                new NotBlank(array('message' => 'Message should not be blank.')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}