<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TweedeGolf\PrometheusClient\CollectorRegistry;
use TweedeGolf\PrometheusClient\Format\TextFormatter;
use TweedeGolf\PrometheusClient\PrometheusException;

class MetricsController
{
    /** @var CollectorRegistry */
    private $collectorRegistry;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(CollectorRegistry $collectorRegistry, EntityManagerInterface $entityManager)
    {
        $this->collectorRegistry = $collectorRegistry;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/metrics", name="metrics", methods={"GET"})
     * @return Response
     * @throws PrometheusException
     */
    public function index(): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $this->collectorRegistry->getGauge('users_registered')->set($userRepository->count([]));

        $postRepository = $this->entityManager->getRepository(Post::class);
        $this->collectorRegistry->getGauge('post_count')->set($postRepository->count([]));

        $formatter = new TextFormatter();
        return new Response($formatter->format($this->collectorRegistry->collect()), 200, [
            'Content-Type' => $formatter->getMimeType(),
        ]);
    }
}