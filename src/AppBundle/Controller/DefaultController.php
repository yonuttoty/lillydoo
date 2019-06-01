<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Form\AddressType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
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
     * @Route("/{id}/delete", name="address_delete")
     *
     * @param integer $id
     * @return Response
     */
    public function deleteAction(int $id): Response
    {
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->findOneBy(['id' => $id]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($address);
        $entityManager->flush();

        $this->addFlash('success', 'Address removed successfully.');

        return $this->redirectToRoute('address_homepage');
    }

    /**
     * @Route("/{id}/edit", name="address_edit")
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, int $id): Response
    {
        /** @var Address $address */
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->findOneBy([
                'id' => $id
            ]);

        if (!empty($address->getPicture())) {
            $address->setPicture(new File(
                $this->getParameter('address_directory') . '/' . $address->getPicture()
            ));
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->add('edit', SubmitType::class);

        //https://github.com/symfony/symfony/issues/16489
        // Hack used to submit the form manually without clearing the fields
        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()), false);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!empty($address->getPicture())) {
                    $file = new File($address->getPicture());
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    try {
                        $file->move($this->getParameter('address_directory'), $fileName);
                    } catch (FileException $exception) {
                        $fileName = '';
                    }
                    $address->setPicture($fileName);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($address);
                $entityManager->flush();

                $this->addFlash('success', 'Address updated successfully.');

                return $this->redirectToRoute('address_homepage');
            }
        }

        return $this->render('@App/address/edit.html.twig', [
            'form' => $form->createView()
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
        $form->add('create', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($request->files)) {
                if (!empty($address->getPicture())) {
                    $file = new File($address->getPicture());
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    try {
                        $file->move($this->getParameter('address_directory'), $fileName);
                    } catch (FileException $exception) {
                        $fileName = '';
                    }
                    $address->setPicture($fileName);
                }
            }

            // The Symfony Way but because of problems with xampp and temp files a hack was needed
//            if ($file instanceof UploadedFile) {
//                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
//                $file->move($this->getParameter('address_directory'), $file->getClientOriginalName());
//                $address->setPicture($fileName);
//            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();
            $this->addFlash('success', 'Address created successfully.');

            return $this->redirectToRoute('address_homepage');
        }

        return $this->render('@App/address/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
