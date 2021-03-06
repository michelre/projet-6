<?php

namespace Projet6\Controller;

use Projet6\dao\AnnonceDao;
use Projet6\dao\MemberDao;
use Projet6\Services\SessionService;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class FrontendController
{
    private $annonceDao;
    private $memberDao;
    private $sessionService;
    private $template;

    function __construct()
    {
        $this->annonceDao = new AnnonceDao();
        $this->sessionService = new SessionService();
        $this->memberDao = new MemberDao();
        $this->template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/../view'), array('debug' => true));
        $this->template->addExtension(new Twig_Extension_Debug());
    }

    /**Home*/
    function listAnnonces()
    {
        echo $this->template->render('frontend/list-annonces-view.html.twig');
    }

    /**Toutes les annonces */
    function listAnnoncesAll()
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        echo $this->template->render('frontend/list-annonces-all.html.twig', array('annonces' => $annonces));
    }

    /**Annonce je recherche */
    function listAnnoncesSearch()
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getTypeOfAnnoncesSearch();
        echo $this->template->render('frontend/list-annonces-search-view.html.twig', array('annonces' => $annonces));
    }

    /**Annonce je propose */
    function listAnnoncesGive()
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getTypeOfAnnoncesGive();
        echo $this->template->render('frontend/list-annonces-give-view.html.twig', array('annonces' => $annonces));
    }

    /**Retoune la page pour selectionner une annonce par ville disponible*/
    function listAnnoncesCity()
    {
        $annonceDao = new AnnonceDao();
        $annonces = $annonceDao->getCity();
        echo $this->template->render('frontend/list-annonces-city.html.twig', array('annonces' =>$annonces));
    }

    /** Retourne une annonce */
    function annonce($annonceId)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        $annonce = $this->annonceDao->getAnnonceById($annonceId);
        echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }
    /**retourne l'annonce séléctionné */
    function city ($annonceId)
    {
        $annonces = $this->annonceDao->getCity();
        $annonce = $this->annonceDao->getAnnonceById($annonceId);
        echo $this->template->render('frontend/annonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }


    /** permet d'éditer un motif de signalement pour signaler une annonce */
    function spamEditAnnonce($annonceId)
    {
        $annonces = $this->annonceDao->getAllAnnonces();
        $annonce = $this->annonceDao->getAnnonceById($annonceId);
        echo $this->template->render('frontend/spamannonce-view.html.twig', array('annonce' => $annonce, 'annonces' => $annonces));
    }

    /** permet d'envoyer le motif de signalement */
    function spamAnnonce($annonceId, $spam)
    {$annonces = $this->annonceDao->getAllAnnonces();
        $affectedLines = $this->annonceDao->signalAnnonce($annonceId, $spam);
        if ($affectedLines === false) {
            throw new \Exception('Impossible de signaler l\annonce !');
        } else {
            echo $this->template->render('frontend/list-annonces-all.html.twig', array( 'annonces' => $annonces));

        }
    }







}
