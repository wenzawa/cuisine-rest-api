<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiRecetteController extends AbstractController
{

    #[Route('/recettes', name: 'api_recettes_list', methods: 'GET')]
    public function getRecettesAction(RecetteRepository $repository): JsonResponse
    {
        $recettes = $repository->findAll();
        $formatted = [];
        foreach ($recettes as $recette) {
            $formatted[] = [
                'id' => $recette->getId(),
                'titre' =>  $recette->getTitre(),
                'sous_titre' => $recette->getSousTitre(),
                'ingrediens' => $recette->getIngrediens()
            ];
        }
        return $this->json($formatted, Response::HTTP_OK);
    }

    #[Route('/recettes', name: 'api_recettes_new', methods: 'POST')]
    public function postRecettesAction(
        Request $request,
        RecetteRepository $repository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $titre = $data['titre'] ?? '';
        $sousTitre = $data['sous_titre'] ?? '';
        $ingrediens = $data['ingrediens'] ?? '';

        if (empty($titre) || empty($sousTitre) || empty($ingrediens)) {
            throw new NotFoundHttpException('Attendre des paramètres obligatoires!');
        }
        $recette = new Recette;
        $recette->setTitre($titre)
            ->setSousTitre($sousTitre)
            ->setIngrediens($ingrediens);
        $repository->saveRecette($recette);

        return $this->json(
            ['status' => 'Recette a été créé!'],
            Response::HTTP_CREATED
        );
    }

    #[Route('/recettes/{id}', name: 'api_recettes_one', methods: 'GET')]
    public function getRecetteAction(Request $request, RecetteRepository $repository): JsonResponse
    {
        $recette = $repository->find($request->get('id'));
        if (empty($recette)) {
            return $this->json(
                ['message' => 'Recette not found'],
                Response::HTTP_NOT_FOUND
            );
        }
        $formatted = [
            'id' => $recette->getId(),
            'titre' =>  $recette->getTitre(),
            'sous_titre' => $recette->getSousTitre(),
            'ingrediens' => $recette->getIngrediens()
        ];
        return $this->json($formatted,   Response::HTTP_OK);
    }

    #[Route('/recettes/{id}', name: 'api_recettes_update', methods: 'PUT')]
    public function putRecetteAction(Request $request, RecetteRepository $repository): JsonResponse
    {
        $recette = $repository->find($request->get('id'));
        $data = json_decode($request->getContent(), true);

        empty($data['titre']) ? true : $recette->setTitre($data['titre']);
        empty($data['sous_titre']) ? true : $recette->setSousTitre($data['sous_titre']);
        empty($data['ingrediens']) ? true : $recette->setIngrediens($data['ingrediens']);

        $updatedRecette = $repository->updateRecette($recette);

        return $this->json($updatedRecette->toArray(), Response::HTTP_OK);
    }


    #[Route('/recettes/{id}', name: 'api_recettes_delete', methods: 'DELETE')]
    public function deleteRecetteAction(Request $request, RecetteRepository $repository): JsonResponse
    {
        $id = $request->get('id');
        $recette = $repository->findOneBy(['id' => $id]);
        $repository->removeRecette($recette);

        return $this->json(
            ['status' => 'Recette supprimé '],
            Response::HTTP_NO_CONTENT
        );
    }
}
