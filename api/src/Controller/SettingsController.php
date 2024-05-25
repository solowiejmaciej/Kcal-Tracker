<?php

namespace App\Controller;

use App\Entity\Settings; 
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class SettingsController extends AbstractController
{
    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    #[Route('/api/settings', name: 'settings', methods: ['GET'])]
    public function getSettings(): JsonResponse
    {
        $settings = $this->settingsRepository->find(1); // Assuming the settings you want to fetch have an ID of 1

        if (!$settings) {
            throw $this->createNotFoundException('Settings not found');
        }

        return new JsonResponse(
            [
                'maxKcal' => $settings->getMaxKcal(),
                'maxProtein' => $settings->getMaxProtein(),
                'maxCarbs' => $settings->getMaxCarbs(),
                'maxFat' => $settings->getMaxFat()
            ]
        );
    }


    #[Route('/api/settings', name: 'settings_update', methods: ['POST'])]
    public function updateSettings(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $settings = $this->settingsRepository->find(1); // Assuming the settings you want to update have an ID of 1

        if ($settings) {
            // Update the existing settings entity
            $settings->setMaxKcal($data['maxKcal']);
            $settings->setMaxProtein($data['maxProtein']);
            $settings->setMaxCarbs($data['maxCarbs']);
            $settings->setMaxFat($data['maxFat']);
        } else {
            // Create a new settings entity
            $settings = new Settings();
            $settings->setMaxKcal($data['maxKcal']);
            $settings->setMaxProtein($data['maxProtein']);
            $settings->setMaxCarbs($data['maxCarbs']);
            $settings->setMaxFat($data['maxFat']);

            $em->persist($settings);
        }

        $em->flush();

        return new JsonResponse(['status' => 'Settings updated!'], JsonResponse::HTTP_CREATED);
    }
}