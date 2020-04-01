<?php


namespace App\Service;

use App\Entity\StufInterface;
use App\Service\CommonGroundService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Twig\Environment;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class StufService
{
    private $commonGroundService;
    private $templating;
    private $xmlEncoder;
    private $em;
    private $serializer;
    private $client;

    public function __construct(CommonGroundService $commonGroundService, Environment $twig, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->templating = $twig;
        $this->commonGroundService = $commonGroundService;
        $this->xmlEncoder = new XmlEncoder();
        $this->em = $em;
        $this->serializer = $serializer;
        $this->client = new Client();
    }

    public function request(StufInterface $request, $contentType, $renderType)
    {

        //To render the request
        $template = $this->templating->createTemplate('requests/' . $request->getRequestTemplate());
        $message = $template->render($request->getData());

        //To send the request
        if($username = $request->getUsername() && $password = $request->getPassword()){
            $auth = [$username, $password, $request->getDigest()];
            $this->client->
        }
        $response = $this->client->request($request->getRequestMethod(), $request->getDestination(), ['headers' => $request->getHeaders(), 'body' => $message]);

        //Get return data
        $respContentType = $response->getHeader('Content-Type');
        $statusCode = $response->getStatusCode();
        $response = $response->getBody();

        if($statusCode == 200 || $statusCode == 201) {
            try {
                //First, we assume that we are parsing XML, so lets try that first
                $result = $this->xmlEncoder->decode($response, 'array');
                $encodedResult = $response;
            }catch(NotEncodableValueException $e){
                //Else, let's check if the response if json
                $result = json_decode($response, true);
                if($result == null){
                    //The response is neither XML nor JSON, so we need to throw an error
                    throw new BadRequestHttpException();
                }
            }
        }
        else{
            http_response_code($statusCode);
            var_dump($request->getRequestMethod().' returned:'.$statusCode);
            var_dump($request->getHeaders());
            var_dump($message);
            var_dump(json_encode($request->getDestination()));
            var_dump($response);
            die;
        }
        //If a response template is set, render it
        if($responseTemplate = $request->getResponseTemplate() != null){
            $template = $this->templating->createTemplate('responses/'/$responseTemplate);
            $return = $template->render($result);
        }
        //Pass the result on if the accept header asks for XML and the response was XML
        elseif($contentType == 'application/xml' && isset($encodedResult)){
            $return = $encodedResult;
        }
        //Use the default serializer
        else{
            $return = $this->serializer->serialize(
                $result,
                $renderType, ['enable_max_depth' => true]
            );
        }
        $request->setResponse($return);
        $this->em->persist($request);
        $this->em->flush();
        return $request;
    }
}
