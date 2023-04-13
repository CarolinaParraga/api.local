<?php

namespace App\BLL;

use App\Entity\Moto;

class MotoBLL
{
    public function actualizaMoto($moto, array $data){
        //$urlImagen = $this->getImagenActividad( $data);
        //$categoria = $this->em->getRepository(Categoria::class)->find($data['categoria']);
        //$user = $this->getUsuario();
        //$moto = new Moto();
        $moto->setCarregistration($data['carregistration']);
        $moto->setModel($data['model']);
        $moto->setColor($data['color']);
        $moto->setBrand($data['brand']);
        $moto->setPrice($data['price']);

        return $this->guardaValidando($moto);
    }
    public function nueva(array $data) {
        $moto = new Moto();
        return $this->actualizaMoto($moto, $data);
    }

}