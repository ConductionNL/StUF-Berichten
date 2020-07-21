<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\StufService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StufSubscriber implements EventSubscriberInterface
{
    private $params;
    private $em;
    private $stufService;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em, StufService $stufService)
    {
        $this->params = $params;
        $this->em = $em;
        $this->stufService = $stufService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['stuf', EventPriorities::PRE_SERIALIZE],
        ];
    }

    public function stuf(RequestEvent $event)
    {
        $request = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');
        $contentType = $event->getRequest()->headers->get('accept');


        if ($method != Request::METHOD_POST && !strpos($route, 'stuf_interfaces')) {
            return;
        }

        // Gettting the entity
//        $request = $event->getControllerResult();

        if (!$contentType) {
            $contentType = $event->getRequest()->headers->get('Accept');
        }
        switch ($contentType) {
            case 'application/xml':
                $renderType = 'json';
                break;
            case 'application/json':
                $renderType = 'json';
                break;
            case 'application/ld+json':
                $renderType = 'jsonld';
                break;
            case 'application/hal+json':
                $renderType = 'jsonhal';
                break;
            default:
                $contentType = 'application/ld+json';
                $renderType = 'jsonld';
        }

        // stuf service
        $request = $this->stufService->request($request, $contentType, $renderType);

        // Creating a response
        $response = new Response(
            $request->getReponse(),
            Response::HTTP_CREATED,
            ['content-type' => $contentType]
        );
        $event->setResponse($response);
    }
}
