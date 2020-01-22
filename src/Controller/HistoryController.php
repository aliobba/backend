<?php

namespace App\Controller;

use App\Entity\History;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HistoryController extends AbstractController
{

    // Get tout les liens par le plus récent
    /**
     * @Route("/findAll", name="display", methods={"GET"})
     */
    public function display(HistoryRepository $historyRepository)
    {
        return $this->json($historyRepository->findAllByRecent(),200,[],['groups' => 'history:read']);
    }

    //Ajout d'un lien youtube à la base des données
    /**
     * @Route("/ajout", name="ajouter", methods={"POST"})
     */
    public function insert(\Symfony\Component\HttpFoundation\Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRequest = $request->getContent();

        $history = $serializer->deserialize($jsonRequest, History::class,'json');

        $em->persist($history);
        $em->flush();

        return $this->json($history,201,[],['groups' => 'history:read']);
    }
}
