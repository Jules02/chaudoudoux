<?php


namespace App\Controller;


use App\Entity\Chaudoudoux;
use App\Entity\User;
use App\Form\ChaudoudouxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    const CLASSES = array(
        '2A', '2B', '2C', '2D', '2E', '2F', '2G',
        '1A', '1B', '1C', '1D', '1E', '1F',
        'TL', 'TS1', 'TS2', 'TS3', 'TES1', 'TES2', 'TES3'
    );

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->redirectToRoute('app_homepage_loggedin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if($error){
            $this->addFlash('error', "Une erreur est survenue lors de votre connexion");
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('content/homepage.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/accueil", name="app_homepage_loggedin")
     */
    public function homepage_loggedin(EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $em->getRepository(Chaudoudoux::class);

        $lastChaudoudoux= $repository->findLast();

        $username = $this->getUser()->getUsername();

        $chaudoudouxUnseen = $repository->findUnseen($username);
        $chaudoudouxUnseenLength = count($chaudoudouxUnseen);
        $chaudoudouxSeen = $repository->findSeen($username);
        $chaudoudouxSeenLength = count($chaudoudouxSeen);

        $chaudoudoux = $repository->findAll();
        $chaudoudouxLength = count($chaudoudoux);



        $classes = self::CLASSES;
        $classesLength = count($classes);
        $chaudoudouxClasseRank = array();
        for($i = 0; $i <=  $classesLength - 1; $i++){
            $classe =  $classes[$i];
            $chaudoudouxClasse = $repository->findByClasse($classe);
            $chaudoudouxClasseRank[$classes[$i]] = count($chaudoudouxClasse);
        }

        arsort($chaudoudouxClasseRank);
        $chaudoudouxClasseRanked = array_slice($chaudoudouxClasseRank, 0, 3);
        asort($chaudoudouxClasseRanked);
        $temp = array_slice($chaudoudouxClasseRanked, 1, 2);
        arsort($temp);
        $chaudoudouxClasseRankedFinal = array_merge(array_slice($chaudoudouxClasseRanked, 0, 1), $temp);


        return $this->render('content/homepage_loggedin.html.twig', [
            'lastChaudoudoux' => $lastChaudoudoux,
            'chaudoudouxUnseenLength' => $chaudoudouxUnseenLength,
            'chaudoudouxSeenLength' => $chaudoudouxSeenLength,
            'chaudoudouxLength' => $chaudoudouxLength,
            'chaudoudouxClasseRanked' => $chaudoudouxClasseRankedFinal,
        ]);
    }

    /**
     * @Route("/classement", name="app_classement")
     */
    public function classement(EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $em->getRepository(Chaudoudoux::class);

        $classes = self::CLASSES;
        $classesLength = count($classes);
        $chaudoudouxClasseRank = array();
        for($i = 0; $i <=  $classesLength - 1; $i++){
            $classe =  $classes[$i];
            $chaudoudouxClasse = $repository->findByClasse($classe);
            $chaudoudouxClasseRank[$classes[$i]] = count($chaudoudouxClasse);
        }

        arsort($chaudoudouxClasseRank);

        return $this->render('content/classement.html.twig', [
            'chaudoudouxClasseRank' => $chaudoudouxClasseRank,
        ]);
    }

    /**
     * @Route("/profil/{username}", name="app_profil")
     */
    public function profil($username, EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        if($user->getUsername() === $username){
            $repository = $em->getRepository(Chaudoudoux::class);
            $chaudoudoux = $repository->findByUser($username);

            return $this->render('content/profil.html.twig', array(
                'chaudoudoux' => $chaudoudoux
            ));
        }else{
            return $this->redirectToRoute('app_homepage_loggedin');
        }
    }

    /**
     * @Route("mes-chaudoudoux", name="app_meschaudoudoux")
     */
    public function mesChaudoudoux(EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $username = $this->getUser()->getUsername();

        $repository = $em->getRepository(Chaudoudoux::class);
        $chaudoudouxUnseen= $repository->findUnseen($username);
        $chaudoudouxSeen = $repository->findSeen($username);

        return $this->render("content/mes_chaudoudoux.html.twig", [
            'chaudoudouxUnseen' => $chaudoudouxUnseen,
            'chaudoudouxSeen' => $chaudoudouxSeen
        ]);
    }

    /**
     * @Route("/chaudoudoux/{id}", name="app_chaudoudoux")
     */
    public function chaudoudoux(EntityManagerInterface $em, $id){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $username = $this->getUser()->getUsername();

        $repository = $em->getRepository(Chaudoudoux::class);
        $chaudoudoux = $repository->find($id);

        if($chaudoudoux->getSeen() == 0){
            $chaudoudoux->setSeen(1);
        }

        $em->persist($chaudoudoux);
        $em->flush();

        if($username == $chaudoudoux->getToUser() or $chaudoudoux->getFromUser()){
            return $this->render("content/chaudoudoux.html.twig", [
                'chaudoudoux' => $chaudoudoux
            ]);
        }else{
            $this->addFlash('error', "Vous n'êtes pas le destinataire de ce chaudoudoux");
            return $this->redirectToRoute('app_homepage_loggedin');
        }
    }

    /**
     * @Route("/moderation", name="app_moderation")
     */
    public function moderation(){
        return $this->render("content/moderation.html.twig");
    }

    /**
     * @Route("/reversement-des-benefices", name="app_benefices")
     */
    public function benefices(){
        return $this->render("content/benefices.html.twig");
    }

    /**
     * @Route("/ecrire-chaudoudoux", name="app_newChaudoudoux")
     */
    public function newChaudoudoux(Request $request, EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        if($user->getCredits() == 0){
            $this->addFlash('error', "Vous n'avez plus de chaudoudoux :/");

            return $this->redirectToRoute('app_profil', array('username' => $user->getUsername()));
        }


        $repository = $em->getRepository(User::class);
        $users = $repository->findAll();
        $usersLength = count($users);
        $fullNames = array();
        for($i = 0; $i <=  $usersLength - 1; $i++){
            $firstName = $users[$i]->getFirstName();
            $lastName = $users[$i]->getLastName();
            $fullName = $firstName . ' ' . $lastName;
            array_push($fullNames, $fullName);
        }

        $chaudoudoux = new Chaudoudoux();

        $form = $this->createForm(ChaudoudouxType::class, $chaudoudoux);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chaudoudoux = $form->getData();

            $chaudoudoux->setFromUser($this->getUser()->getUsername());
            $chaudoudoux->setPublishedAt(new \DateTime());
            $chaudoudoux->setSeen(0);
            $chaudoudoux->setFromUserClasse($this->getUser()->getClasse());

            $firstName = $this->getUser()->getFirstName();
            $lastName = $this->getUser()->getLastName();
            $fullName = $firstName . ' ' . $lastName;
            $chaudoudoux->setFromUserFull($fullName);

            $credits = $user->getCredits();
            $user->setCredits($credits - 1);

            $em->persist($chaudoudoux);
            $em->flush();

            $this->addFlash('success', "Votre chaudoudoux a bien été envoyé. Merci !");

            return $this->redirectToRoute('app_homepage_loggedin');
        }

        return $this->render("content/new_chaudoudoux.html.twig",[
            'form' => $form->createView(),
            'users' => $fullNames
        ]);
    }
}