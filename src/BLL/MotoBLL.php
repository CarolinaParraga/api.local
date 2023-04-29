<?php

namespace App\BLL;

use App\Entity\Moto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Security;

class MotoBLL extends BaseBLL
{
    public function actualizaMoto(Moto $moto, array $data){
        //$urlImagen = $this->getImagenMoto( $data);
        //$categoria = $this->em->getRepository(Categoria::class)->find($data['categoria']);
        //$user = $this->getUsuario();
        //$moto = new Moto();
        $moto->setCarregistration($data['carregistration']);
        $moto->setModel($data['model']);
        $moto->setColor($data['color']);
        $moto->setBrand($data['brand']);
        $moto->setPrice($data['price']);
        $moto->setPhoto($data['photo']);
        $moto->setDescription($data['description']);

        return $this->guardaValidando($moto);
    }

    private function getImagenMoto(Request $request, array $data)
    {
        $arr_imagen = explode (',', $data['imagen']);
        if ( count ($arr_imagen) < 2)
            throw new BadRequestHttpException('formato de imagen incorrecto');

        $imagen = base64_decode ($arr_imagen[1]);
        if (is_null($imagen))
            throw new BadRequestHttpException('No se ha recibido la imagen');

        $fileName = $data['nombre'].'.jpg';
        $filePath = $this->images_directory . $fileName;
        $urlImagen = $request->getUriForPath($filePath);
        //$urlImagen = $this->images_url . $fileName;
        $ifp = fopen ($filePath, "wb");
        if (!$ifp)
            throw new BadRequestHttpException('No se ha podido guardar la imagen');

        $ok = fwrite ($ifp, $imagen);
        if ($ok === false)
            throw new BadRequestHttpException('No se ha podido guardar la imagen');

        fclose ($ifp);

        return $urlImagen;
    }
    public function nueva(array $data) {
        $moto = new Moto();
        return $this->actualizaMoto($moto, $data);
    }


    public function toArray(Moto $moto)
    {
        if ( is_null ($moto))
            return null;

        return [
            'id' => $moto->getId(),
            'brand' => $moto->getBrand(),
            'carregistration' => $moto->getCarregistration(),
            'color' => $moto->getColor(),
            'model' => $moto->getModel(),
            'price' => $moto->getPrice(),
            'photo' => $moto->getPhoto(),
            'description' => $moto->getDescription(),
        ];
    }

    Public function getMotos(?string $order, ?string $carregistration , ?string $model,
                             ?string $color, ?string $brand, ?int $price, ?string $photo, ?string $description)
    {
        //$user = $this->getUser();
        $motos = $this->em->getRepository(Moto::class)->findMotos($order, $carregistration, $model,
            $color, $brand, $price, $photo, $description);

        return $this->entitiesToArray($motos);
    }

    /*public function checkAccessToMoto(Moto $moto)
    {
        if ($this->checkRoleAdmin() === false) {
            $usuario = $this->getUser();
            if ($usuario->getId() !== $moto->getUsuario()->getId())
                throw new AccessDeniedHttpException();
        }
    }*/
}