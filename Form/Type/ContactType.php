<?php

namespace Mremi\ContactBundle\Form\Type;

use Mremi\ContactBundle\Model\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Contact type class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * Constructor
     *
     * @param string $class The Contact class namespace
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // todo: handle it better (translation)
        $titles = Contact::getTitles();

        $builder
            ->add('title',     'choice', array(
                'choices'  => array_combine($titles, array_map('ucfirst', $titles)),
                'expanded' => true,
            ))
            ->add('firstName', 'text')
            ->add('lastName',  'text')
            ->add('email',     'email')
            ->add('subject',   'text')
            ->add('message',   'textarea')
            ->add('captcha',   'genemu_captcha', array('mapped' => false));
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'contact',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'mremi_contact_contact_form';
    }
}
