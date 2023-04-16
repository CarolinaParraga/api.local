<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseApiController extends AbstractController
{
    public function getContent(Request $request)
    {
        //convertir json respuesta en array asociativo
        $data = json_decode($request->getContent(), true);
        if (is_null($data ))
            //devuelve codigo 400
            throw new BadRequestHttpException('No se han recibido los datos');
        return $data;
    }
    //metodo que devuelve la respuesta qu está guardada en el atributo data del json
    protected function getResponse(array $data=null, $statusCode = Response::HTTP_OK)
    {
        $response = new JsonResponse();
        if (!is_null($data))
        {
            $result['data'] = $data;
            $response->setContent(json_encode($result));
        }
        $response->setStatusCode($statusCode);
        return $response;
    }

}