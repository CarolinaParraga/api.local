<?php

namespace App\Controller\API;
use App\BLL\MotoBLL;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotoApiContoller extends BaseApiController
{
    /**
     * @Route("/motos.{_format}",
     *     name="post_motos",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json"},
     *     methods={"POST"}
     * )
     */
    public function post(Request $request, MotoBLL $motoBLL)
    {
        $data = $this->getContent($request);

        $moto = $motoBLL->nueva($data);

        return $this->getResponse($moto, Response:: HTTP_CREATED );
    }

}