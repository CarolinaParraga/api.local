<?php

namespace App\Controller\API;
use App\BLL\MotoBLL;
use App\Entity\Moto;
use App\Repository\MotoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotoApiContoller extends BaseApiController
{
    private $motoRepository;

    /**
     * @param $motoRepository
     */
    public function __construct(MotoRepository $motoRepository)
    {
        $this->motoRepository = $motoRepository;
    }


    /**
     * @Route("/motos/{id}.{_format}", name="get_moto",
     * requirements={
     * "id": "\d+",
     * "_format": "json"
     * },
     * defaults={"_format": "json"},
     * methods={"GET"})
     */
    public function getOne(Moto $moto, MotoBLL $motoBLL)
    {
        //$motoBLL->checkAccessToActividad($moto);
        return $this->getResponse($motoBLL->toArray($moto));
    }
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

    /**
     * @Route("/one_moto/{id}", name="get_one_moto", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $moto = $this->motoRepository->findOneBy(['id'=> $id]);
        $data = [
            'id' => $moto->getId(),
            'brand' => $moto->getBrand(),
            'carregistration' => $moto->getCarregistration(),
            'color' => $moto->getColor(),
            'model' => $moto->getModel(),
            'price' => $moto->getPrice(),
        ];

        //$motoBLL->checkAccessToActividad($moto);
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/motos.{_format}",
     *     name="get_motos",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json"},
     *     methods={"GET"}
     * )
     * @Route("/motos/ordenados/{order}", name="get_motos_ordenados")
     */
    public function getAll(
        Request $request, MotoBLL $motoBLL, string $order='brand')
    {
        $carregistration = $request->query->get('carregistration');
        $model = $request->query->get('model');
        $color = $request->query->get('color');
        $brand = $request->query->get('brand');
        $price = $request->query->get('price');

        $motos = $motoBLL->getMotos($order, $carregistration , $model, $color, $brand, $price);

        return $this->getResponse($motos);
    }

    /**
     * @Route("/motos/{id}.{_format}",
     *     name="update_moto",
     *     requirements={"id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"PUT"}
     * )
     */
    public function update(Request $request, Moto $moto, MotoBLL $motoBLL)
    {

        $data = $this->getContent($request);

        $moto = $motoBLL->actualizaMoto($moto, $data);

        return $this->getResponse($moto, Response:: HTTP_OK );

    }

    /**
     * @Route("/motos/{id}.{_format}",
     *     name="delete_moto",
     *     requirements={ "id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"DELETE"}
     * )
     */
    public function delete(Moto $moto, MotoBLL $motoBLL)
    {
        $motoBLL->delete($moto);
        return $this->getResponse(null, Response:: HTTP_NO_CONTENT );
    }

}