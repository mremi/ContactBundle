<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\ContactBundle\Event;

use Mremi\ContactBundle\Model\ContactInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Filter contact response event class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class FilterContactResponseEvent extends ContactEvent
{
    /**
     * @var Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param ContactInterface $contact  A contact instance
     * @param Request          $request  A request instance
     * @param Response         $response A response instance
     */
    public function __construct(ContactInterface $contact, Request $request, Response $response)
    {
        parent::__construct($contact, $request);

        $this->response = $response;
    }

    /**
     * Gets the response.
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
