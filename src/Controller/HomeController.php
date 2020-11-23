<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Recette;
use App\Form\ContactType;
use App\Repository\RecetteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
     /**
        * @Route("/", name="home_index")
        */
        
    public function index(RecetteRepository $recetteRepository)
    {
        $recettes = $recetteRepository->findBy([], ['id' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'recettes' => $recettes,
            'menu' => 'home'
        ]);
    }

    /**
         * @Route("/contact", name="home_contact")
         */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->CreateForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('Bonjour le mail'))
                ->setFrom('exemple@gmail.fr')
                ->setTo($contact->getEmail())
                ->setBody(
                    $this->render('email/contact.html.twig', [
                        'contact' => $contact
                    ]),
                    'text/html'
                );
            $mailer->send($message);
        }

        return $this->render('home/contact.html.twig', [
            'formContact' => $form->CreateView()
        ]);
    }
}