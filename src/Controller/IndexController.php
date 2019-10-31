<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Safe\Exceptions\JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use TweedeGolf\PrometheusClient\CollectorRegistry;
use TweedeGolf\PrometheusClient\PrometheusException;
use function Safe\json_encode;

final class IndexController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var CollectorRegistry */
    private $collectorRegistry;


    public function __construct(SerializerInterface $serializer, CollectorRegistry $collectorRegistry)
    {
        $this->serializer = $serializer;
        $this->collectorRegistry = $collectorRegistry;
    }

    /**
     * @throws JsonException
     *
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|_(profiler|wdt)|metrics).*"}, name="index")
     * @throws PrometheusException
     */
    public function indexAction(LoggerInterface $logger): Response
    {
        $logger->info('Call to index controller');

        $metric = $this->collectorRegistry->getCounter('http_requests_total');
        $metric->inc(1, ['handler' => 'home']);

        /** @var User|null $user */
        $user = $this->getUser();
        $data = null;
        if (!empty($user)) {
            $userClone = clone $user;
            $userClone->setPassword('');
            $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT);
        }

        return $this->render('base.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'user' => $data ?? json_encode($data),
        ]);
    }
}
