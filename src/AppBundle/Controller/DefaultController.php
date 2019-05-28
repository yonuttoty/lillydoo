<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="adress_homepage")
     */
    public function viewAction(Request $request): Response
    {
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->find(1);

        return $this->render('@App/base.html.twig', [
            'email' => $address->getEmail(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adress_edit")
     *
     * @param Request $request
     * @param int     $id
     * @return Response
     */
    public function editAction(Request $request, $id): Response
    {
        return $this->render('@App/address/edit.html.twig', [
            'id'    => $id
        ]);
    }

    /**
     * @Route("/create", name="address_create")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $address = new Address();
        $address->setFirstName('Ioan');
        $address->setLastName('Totalca');
        $address->setStreet('street');
        $address->setStreetNumber(12);
        $address->setZip(12345);
        $address->setCountry('Romania');
        $address->setPhoneNumber(123456789);
        $address->setBirthday(\DateTime::createFromFormat('Y-m-d', '2019-01-01'));
        $address->setEmail('ioan@c.b');
        $address->setPicture('adress.jpeg');

        $entityManager->persist($address);
        $entityManager->flush();

        return $this->render('base.html.twig');
    }
}
