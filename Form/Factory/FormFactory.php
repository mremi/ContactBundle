<?php

namespace Mremi\ContactBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Form factory class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class FormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var string|integer
     */
    private $name;

    /**
     * @var string|\Symfony\Component\Form\FormTypeInterface
     */
    private $type;

    /**
     * @var array
     */
    private $validationGroups;

    /**
     * Constructor
     *
     * @param FormFactoryInterface                             $formFactory      A form factory instance
     * @param string|integer                                   $name             The name of the form
     * @param string|\Symfony\Component\Form\FormTypeInterface $type             The type of the form
     * @param array                                            $validationGroups An array of validation groups
     */
    public function __construct(FormFactoryInterface $formFactory, $name, $type, array $validationGroups)
    {
        $this->formFactory      = $formFactory;
        $this->name             = $name;
        $this->type             = $type;
        $this->validationGroups = $validationGroups;
    }

    /**
     * Creates a form and returns it
     *
     * @param mixed $data The initial data, optional
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm($data = null)
    {
        return $this->formFactory->createNamed($this->name, $this->type, $data, array(
            'validation_groups' => $this->validationGroups
        ));
    }
}
