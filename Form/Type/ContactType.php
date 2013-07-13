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
     * @var boolean
     */
    private $captchaDisabled;

    /**
     * Constructor
     *
     * @param string  $class           The Contact class namespace
     * @param boolean $captchaDisabled TRUE whether you want disable the captcha
     */
    public function __construct($class, $captchaDisabled)
    {
        $this->class           = $class;
        $this->captchaDisabled = $captchaDisabled;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'choice', array(
                'choices'            => Contact::getTitles(),
                'expanded'           => true,
                'label'              => 'mremi_contact.form.title',
                'translation_domain' => 'MremiContactBundle',
            ))
            ->add('firstName', 'text',     array('label' => 'mremi_contact.form.first_name', 'translation_domain' => 'MremiContactBundle'))
            ->add('lastName',  'text',     array('label' => 'mremi_contact.form.last_name',  'translation_domain' => 'MremiContactBundle'))
            ->add('email',     'email',    array('label' => 'mremi_contact.form.email',      'translation_domain' => 'MremiContactBundle'))
            ->add('subject',   'text',     array('label' => 'mremi_contact.form.subject',    'translation_domain' => 'MremiContactBundle'))
            ->add('message',   'textarea', array('label' => 'mremi_contact.form.message',    'translation_domain' => 'MremiContactBundle'));

        if (!$this->captchaDisabled) {
            $builder->add('captcha', 'genemu_captcha', array(
                'label'              => 'mremi_contact.form.captcha',
                'translation_domain' => 'MremiContactBundle',
                'mapped'             => false,
            ));
        }
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
