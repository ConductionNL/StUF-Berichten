<?php


namespace App\Subscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Entity\Payment;
use App\Entity\Service;
use App\Service\CommonGroundService;
use App\Service\MollieService;
use App\Service\SumUpService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Error;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Yaml;

use Twig\Environment as Environment;

class StufSubscriber implements EventSubscriberInterface
{
    private $params;
    private $em;
    private $serializer;
    private $client;
    private $templating;
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em, SerializerInterface $serializer, Environment $twig, CommonGroundService $commonGroundService)
    {

        $this->params = $params;
        $this->em = $em;
        $this->serializer = $serializer;
        $this->client = new Client();
        $this->templating = $twig;
        $this->commonGroundService = $commonGroundService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['stuf', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function stuf(RequestEvent $event)
    {
        //$result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $route = $event->getRequest()->attributes->get('_route');
        $contentType = $event->getRequest()->headers->get('accept');
        
        
        $encoder = new XmlEncoder();
        if($method != Request::METHOD_POST && $route != 'api_stuf_message_post_collection' && $route != 'api_stuf_message_post_stuf_collection'){
            return;
        }
        
        // Gettting the entity
        $request = $event->getControllerResult();
        
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
        
        //ipv dit
		/*
        $template = $this->templating->createTemplate('requests/'.$request->getTemplate());
        $message = $template->render($request->getData());
        
       //$proces = 'POST';
        $response = $this->client->request($request->getMethod(), $destination, ['headers'=>$headers, 'body'=> $message]);

        $respContentType = $response->getHeader('Content-Type');
        $statusCode = $response->getStatusCode();
        if(($statusCode == 200 || $statusCode == 201) && $respContentType == 'application/xml'){
            $xml = $response->getBody();
            $result = $encoder->decode($xml,'array');
        }elseif($statusCode == 200 || $statusCode == 201){
            throw new BadRequestHttpException();
        }
        else{
            http_response_code($statusCode);
            var_dump($proces.' returned:'.$statusCode);
            var_dump($headers);
            var_dump($message);
            var_dump(json_encode($destination));
            var_dump($response);
            die;
        }
        $json = $this->serializer->serialize(
            $result,
            $renderType, ['enable_max_depth' => true]
        );
		*/
 
        
        // Creating a response
        $response = new Response(
        	$request->getReponce(),
            Response::HTTP_CREATED,
            ['content-type' => $contentType]
        );
        $event->setResponse($response);
    }
}
