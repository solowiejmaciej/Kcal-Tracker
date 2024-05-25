<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;



class MealsController extends AbstractController
{
    private $mealRepository;

    public function __construct(MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    #[Route('/api/meals', name: 'meals', methods: ['GET'])]
    public function getMeals(Request $request): JsonResponse
    {
        $searchDate = $request->query->get('searchDate');

        $meals = $this->mealRepository->findAll();

        if ($searchDate) {
            $searchDate = (new DateTime($searchDate))->setTime(0, 0, 0);
            $meals = array_filter($meals, function(Meal $meal) use ($searchDate) {
                $consumptionDate = $meal->getConsumptionDate()->setTime(0, 0, 0);
                return $consumptionDate == $searchDate;
            });
        }

        $mealsArray = array_map(function (Meal $meal) {
            return [
                'id' => $meal->getId(),
                'kcal' => $meal->getKcal(),
                'protein' => $meal->getProtein(),
                'fat' => $meal->getFat(),
                'carbs' => $meal->getCarbs(),
                'section' => $meal->getSection(),
                'name' => $meal->getName(),
                'consumptionDate' => $meal->getConsumptionDate()->format('Y-m-d')
            ];
        }, $meals);

        return new JsonResponse(array_values($mealsArray));
    }

    #[Route('/api/meals', name: 'meals_create', methods: ['POST'])]
    public function createMeal(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $meal = new Meal();
        $meal->setKcal($data['kcal']);
        $meal->setProtein($data['protein']);
        $meal->setFat($data['fat']);
        $meal->setCarbs($data['carbs']);
        $meal->setSection($data['section']);
        $meal->setName($data['name']);
        $meal->setConsumptionDate(new DateTime($data['consumptionDate']));

        $em->persist($meal);
        $em->flush();

        return new JsonResponse(['status' => 'Meal created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/meals/{id}', name: 'meals_delete', methods: ['DELETE'])]
    public function deleteMeal(int $id, EntityManagerInterface $em): JsonResponse
    {
        $meal = $this->mealRepository->find($id);

        if ($meal) {
            $em->remove($meal);
            $em->flush();

            return new JsonResponse(['status' => 'Meal deleted!'], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['status' => 'Meal not found!'], JsonResponse::HTTP_NOT_FOUND);
    }
    
    //health check
    
    #[Route('/api/health', name: 'health', methods: ['GET'])]
    public function healthCheck(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }

}