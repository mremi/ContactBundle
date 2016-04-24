<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Form\Type;

use Mremi\ContactBundle\Model\Contact;
use Mremi\ContactBundle\Provider\SubjectProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Contact type class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactType extends AbstractType
{
    /**
     * @var SubjectProviderInterface
     */
    private $subjectProvider;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $captchaType;

    /**
     * Constructor.
     *
     * @param SubjectProviderInterface $subjectProvider A subject provider instance
     * @param string                   $class           The Contact class namespace
     * @param string                   $captchaType     The captcha type
     */
    public function __construct(SubjectProviderInterface $subjectProvider, $class, $captchaType)
    {
        $this->subjectProvider = $subjectProvider;
        $this->class           = $class;
        $this->captchaType     = $captchaType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $titles = Contact::getTitles();
        if (version_compare(Kernel::VERSION, '3.0.0', '>=')) {
            $titles = array_flip($titles);
        }

        $builder
            ->add('title', ChoiceType::class, array(
                'choices'  => $titles,
                'expanded' => true,
                'label'    => 'mremi_contact.form.title',
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'mremi_contact.form.first_name',
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'mremi_contact.form.last_name',
            ))
            ->add('email', EmailType::class, array(
                'label' => 'mremi_contact.form.email',
            ));

        if ($subjects = $this->subjectProvider->getSubjects()) {
            if (version_compare(Kernel::VERSION, '3.0.0', '>=')) {
                $subjects = array_flip($subjects);
            }

            $builder->add('subject', ChoiceType::class, array(
                'choices' => $subjects,
                'label'   => 'mremi_contact.form.subject',
            ));
        } else {
            $builder->add('subject', TextType::class, array(
                'label' => 'mremi_contact.form.subject',
            ));
        }

        $builder->add('message', TextareaType::class, array(
            'label' => 'mremi_contact.form.message',
        ));

        if ($this->captchaType) {
            $builder->add('captcha', $this->captchaType, array(
                'label' => 'mremi_contact.form.captcha',
            ));
        }

        $builder->add('save', SubmitType::class, array(
            'label' => 'mremi_contact.form_submit',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => $this->class,
            'csrf_token_id'      => 'contact',
            'translation_domain' => 'MremiContactBundle',
        ));
    }
}
