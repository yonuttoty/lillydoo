<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Form\AddressType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="address_homepage")
     */
    public function viewAction(): Response
    {
        $addresses = $this->getDoctrine()
            ->getRepository(Address::class)
            ->findAll();

        return $this->render('@App/address/list.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="address_edit")
     *
     * @param Request $request
     * @param int     $id
     * @return Response
     */
    public function editAction(Request $request, $id): Response
    {
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->findOneBy([
                'id'    => $id
            ]);

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $address->getPicture();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            try {
                $file->move($this->getParameter('address_directory'), $fileName);
            } catch (FileException $exception) {
                $fileName = '';
            }
            $address->setPicture($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_homepage');
        }

        return $this->render('@App/address/edit.html.twig', [
            'form'  => $form->createView()
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
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($request->files)) {
                $file = new File($address->getPicture());
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('address_directory'), $fileName);
                $address->setPicture($fileName);
            }

            // Symfony way to do it but because of problems with xampp and temp files a hack was needed
//            if ($file instanceof UploadedFile) {
//                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
//                $file->move($this->getParameter('address_directory'), $file->getClientOriginalName());
//                $address->setPicture($fileName);
//            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_homepage');
        }

        return $this->render('@App/address/create.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
