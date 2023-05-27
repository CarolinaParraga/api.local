<?php

namespace App\BLL;
use App\Entity\Moto;
use App\Entity\Reservation;
use App\Entity\User;
use DateTime;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ReservationBLL extends BaseBLL
{
    public function actualizaReservation(Reservation $reservation, array $data){
        //$urlImagen = $this->getImagenActividad( $data);
        //$customer = $this->em->getRepository(User::class)->find($data['customer']);
        $moto = $this->em->getRepository(Moto::class)->find($data['moto']);
        $user = $this->getUser();
        $startdate = DateTime::createFromFormat('Y-m-d', $data['startdate']);
        $enddate = DateTime::createFromFormat('Y-m-d', $data['enddate']);

        //$reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setMoto($moto);
        $reservation->setStartdate($startdate);
        $reservation->setStarthour($data['starthour']);
        $reservation->setEnddate($enddate);
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
            'moto' => $reservation->getMoto()->getModel(),
            'user' => $reservation->getUser()->getEmail(),
            'pickuplocation' => $reservation->getPickuplocation(),
            'returnlocation' => $reservation->getreturnlocation(),
            'startdate' => is_null($reservation->getStartdate()) ? '' :
                $reservation->getStartdate()->format('Y-m-d'),
            'starthour' => $reservation->getStarthour(),
            'enddate' => is_null($reservation->getEnddate()) ? '' :
                $reservation->getEnddate()->format('Y-m-d'),
            'endhour' => $reservation->getEndhour(),
            'status' => $reservation->isStatus(),
        ];
    }

    Public function getReservations(?string $order, ?string $moto,
                             ?string $pickuplocation, ?string $returnlocation, ?string $startdate,
    ?string $enddate, ?string $starthour, ?string $endhour, $user, ?bool $state)
    {
        //$user = $this->getUser();
        $reservations = $this->em->getRepository(Reservation::class)->findReservations
        ($order, $moto, $user, $pickuplocation, $returnlocation, $startdate, $enddate, $starthour, $endhour,
            $state);

        return $this->entitiesToArray($reservations);
    }

    Public function getAvailability(){
        $reservations = $this->em->getRepository(Reservation::class)->findAll();
        return $this->entitiesToArray($reservations);
    }

    public function checkAccessToReservation(Reservation $reservation)
    {
        if ($this->checkRoleAdmin() === false) {
            $user = $this->getUser();
            if ($user->getId() !== $reservation->getUser()->getId())
                throw new AccessDeniedHttpException();
        }
    }

}