<?php


namespace App\Controller;


use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AddCreditsController extends AbstractController
{
    /**
     * @Route("/obtenir-credit", name="app_addCredit")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function addCredit(EntityManagerInterface $em, MailerInterface $mailer){
        $user = $this->getUser();
        $credits = $user->getCredits();
        $user->setCredits($credits + 1);

        $em->persist($user);
        $em->flush();

        $username = $user->getUsername();
        $datetime = new \DateTime();
        $datetime->setTimezone(new DateTimeZone('Europe/Paris'));
        $stringDatetime = $datetime->format('H:i:s');

        $email = (new Email())
            ->from('contact@itinr.fr')
            ->to('julesdupont02@gmail.com')
            ->subject('Nouveau chaudoudoux obtenu')
            ->text($username . ' a obtenu un nouveau chaudoudoux')
            ->html('<p>' . $username . ' a obtenu un nouveau chaudoudoux à ' . $stringDatetime . '</p>');

        $mailer->send($email);

        $this->addFlash('success', "Voilà ! Vous pouvez désormais écrire votre chaudoudoux");

        return new Response($this->redirectToRoute('app_homepage_loggedin'));
    }

    /**
     * @Route("/obtenir-credits-5", name="app_addCredits5")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function addCredits5(EntityManagerInterface $em, MailerInterface $mailer){
        $user = $this->getUser();
        $credits = $user->getCredits();
        $user->setCredits($credits + 5);

        $em->persist($user);
        $em->flush();

        $username = $user->getUsername();
        $datetime = new \DateTime();
        $datetime->setTimezone(new DateTimeZone('Europe/Paris'));
        $stringDatetime = $datetime->format('H:i:s');

        $email = (new Email())
            ->from('contact@itinr.fr')
            ->to('julesdupont02@gmail.com')
            ->subject('Nouveaux chaudoudoux obtenus')
        ->text($username . ' a obtenu 5 nouveaux chaudoudoux')
            ->html('<p>' . $username . ' a obtenu 5 nouveaux chaudoudoux à ' . $stringDatetime . '</p>');

        $mailer->send($email);

        $this->addFlash('success', "Voilà ! Vous pouvez désormais écrire vos chaudoudoux");

        return new Response($this->redirectToRoute('app_homepage_loggedin'));
    }

    /**
     * @Route("/obtenir-credits-20", name="app_addCredits20")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function addCredits20(EntityManagerInterface $em, MailerInterface $mailer){
        $user = $this->getUser();
        $credits = $user->getCredits();
        $user->setCredits($credits + 20);

        $em->persist($user);
        $em->flush();

        $username = $user->getUsername();
        $datetime = new \DateTime();
        $datetime->setTimezone(new DateTimeZone('Europe/Paris'));
        $stringDatetime = $datetime->format('H:i:s');

        $email = (new Email())
            ->from('contact@itinr.fr')
            ->to('julesdupont02@gmail.com')
            ->subject('Nouveaux chaudoudoux obtenus')
            ->text($username . ' a obtenu 20 nouveaux chaudoudoux')
            ->html('<p>' . $username . ' a obtenu 20 nouveaux chaudoudoux à ' . $stringDatetime . '</p>');

        $mailer->send($email);

        $this->addFlash('success', "Voilà ! Vous pouvez désormais écrire vos chaudoudoux");

        return new Response($this->redirectToRoute('app_homepage_loggedin'));
    }
}