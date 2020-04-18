<?php


namespace App\Controller;


use App\Entity\Chaudoudoux;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){
        return $this->render('content/homepage.html.twig');
    }

    /**
     * @Route("/loggedin", name="app_homepage_loggedin")
     */
    public function homepage_loggedin(){
        return $this->render('content/homepage_loggedin.html.twig');
    }

    /**
     * @Route("/profil", name="app_profil")
     */
    public function profil(){
        return $this->render('content/profil.html.twig');
    }

    /**
     * @Route("mes-chaudoudoux", name="app_meschaudoudoux")
     */
    public function mesChaudoudoux(EntityManagerInterface $em){
        $repository = $em->getRepository(Chaudoudoux::class);
        $chaudoudouxUnseen= $repository->findUnseen();
        $chaudoudouxSeen = $repository->findSeen();

        return $this->render("content/mes_chaudoudoux.html.twig", [
            'chaudoudouxUnseen' => $chaudoudouxUnseen,
            'chaudoudouxSeen' => $chaudoudouxSeen
        ]);
    }

    /**
     * @Route("chaudoudoux/{id}", name="app_chaudoudoux")
     */
    public function chaudoudoux(EntityManagerInterface $em, $id){
        $repository = $em->getRepository(Chaudoudoux::class);
        $chaudoudoux = $repository->find($id);

        return $this->render("content/chaudoudoux.html.twig", [
            'chaudoudoux' => $chaudoudoux
        ]);
    }

    /**
     * @Route("/newChaudoudoux", name="app_newChaudoudoux")
     */
    public function newChaudoudoux(EntityManagerInterface $em){
        $chaudoudoux = new Chaudoudoux();
        $chaudoudoux->setImage("lycee.jpg")
            ->setFromUser("sebastien.dupont")
            ->setToUser("theo.clement")
            ->setText("Vestibulum quis rhoncus ligula, vitae lacinia tellus. Ut vulputate quam vel imperdiet semper. Sed velit metus, tincidunt vitae sapien a, facilisis ultrices purus. Aenean nunc tortor, tincidunt vel faucibus non, pellentesque nec ipsum. Mauris convallis faucibus ex, et consequat mi accumsan a. ")
            ->setPublishedAt(new \DateTime())
            ->setSeen(0);

        $em->persist($chaudoudoux);
        $em->flush();

        return new Response(sprintf(
            'Voilà ! Nouveau chaudoudoux id: #%d nom: %s',
            $chaudoudoux->getId(),
            $chaudoudoux->getText()
        ));
    }
}