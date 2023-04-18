<?php

namespace App\BLL;
use App\Entity\Moto;
use App\Entity\Reservation;
use App\Entity\User;

class ReservationBLL extends BaseBLL
{
    public function actualizaReservation(Reservation $reservation, array $data){
        //$urlImagen = $this->getImagenActividad( $data);
        $customer = $this->em->getRepository(User::class)->find($data['customer']);
        $moto = $this->em->getRepository(moto::class)->find($data['moto']);
        //$user = $this->getUsuario();
        //$reservation = new Reservation();
        $reservation->setCustomer($customer);
        $reservation->setCustomer($moto);
        $reservation->setStartdate($data['startdate']);
        $reservation->setStarthour($data['starthour']);
        $reservation->setEnddate($data['enddate']);
        $reservation->setEndhour($data['endhour']);
        $reservation->setPickuplocation($data['pickuplocation']);
        $reservation->setReturnlocation($data['returnlocation']);
        $reservation->setStatus(true);


        return $this->guardaValidando($reservation);
    }
    public function nueva(array $data) {
        $reservation = new Reservation();
        return $this->actualizaReservation($reservation, $data);
    }


    public function toArray(Reservation $reservation)
    {
        if ( is_null ($reservation))
            return null;

        return [
            'id' => $reservation->getId(),
            'moto' => $reservation->getMoto(),
            'customer' => $reservation->getCustomer(),
            'pickuplocation' => $reservation->getPickuplocation(),
            'returnlocation' => $reservation->getreturnlocation(),
            'startdate' => $reservation->getStartdate(),
            'starthour' => $reservation->getStarthour(),
            'enddate' => $reservation->getEnddate(),
            'endhour' => $reservation->getEndhour(),
            'status' => $reservation->isStatus(),
        ];
    }

    Public function getReservations(?string $order, ?string $moto , ?string $customer,
                             ?string $pickuplocation, ?string $returnlocation, ?string $startdate,
    ?string $enddate, ?string $starthour, ?string $endhour, ?bool $state)
    {
        //$user = $this->getUser();
        $reservations = $this->em->getRepository(Reservation::class)->findReservations
        ($order, $moto, $customer, $pickuplocation, $returnlocation, $startdate, $enddate, $starthour, $endhour,
            $state);

        return $this->entitiesToArray($reservations);
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