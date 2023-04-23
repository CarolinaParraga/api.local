<?php

namespace App\Controller\API;
use App\BLL\ReservationBLL;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationApiController extends BaseApiController
{
    private $reservationRepository;

    /**
     * @param $reservationRepository
     */
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }


    /**
     * @Route("/reservations/{id}.{_format}", name="get_reservation",
     * requirements={
     * "id": "\d+",
     * "_format": "json"
     * },
     * defaults={"_format": "json"},
     * methods={"GET"})
     */
    public function getOne(Reservation $reservation, ReservationBLL $reservationBLL)
    {
        //$motoBLL->checkAccessToActividad($moto);
        return $this->getResponse($reservationBLL->toArray($reservation));
    }

    /**
     * @Route("/reservations/{startdate}/{enddate}.{_format}", name="get_available",
     * requirements={
     * "_format": "json"
     * },
     * defaults={"_format": "json"},
     * methods={"GET"})
     */
    public function getAvailable(ReservationBLL $reservationBLL, string $startdate, string $enddate)
    {
        $reservations = $reservationBLL->getAvailability($startdate, $enddate);

        return $this->getResponse($reservations);
    }
    /**
     * @Route("/reservations.{_format}",
     *     name="post_reservations",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json"},
     *     methods={"POST"}
     * )
     */
    public function post(Request $request, ReservationBLL $reservationBLL)
    {
        $data = $this->getContent($request);

        $reservation = $reservationBLL->nueva($data);

        return $this->getResponse($reservation, Response:: HTTP_CREATED );
    }

    /**
     * @Route("/one_reservation/{id}", name="get_one_reservation", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $reservation = $this->reservationRepository->findOneBy(['id'=> $id]);
        $data = [
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

        //$motoBLL->checkAccessToActividad($moto);
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/reservations.{_format}",
     *     name="get_reservations",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json"},
     *     methods={"GET"}
     * )
     * @Route("/reservations/ordenados/{order}", name="get_reservations_ordenados")
     */
    public function getAll(
        Request $request, ReservationBLL $reservationBLL, string $order='startdate')
    {
        $moto = $request->query->get('moto');
        $customer = $request->query->get('customer');
        $pickuplocation = $request->query->get('pickuplocation');
        $returnlocation = $request->query->get('returnlocation');
        $startdate = $request->query->get('startdate');
        $enddate = $request->query->get('enddate');
        $starthour = $request->query->get('starthour');
        $endhour = $request->query->get('endhour');
        $state = $request->query->get('state');

        $reservations = $reservationBLL->getReservations($order, $moto , $customer, $pickuplocation,
            $returnlocation, $startdate, $enddate, $starthour, $endhour, $state);

        return $this->getResponse($reservations);
    }

    /**
     * @Route("/reservations/{id}.{_format}",
     *     name="update_reservation",
     *     requirements={"id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"PUT"}
     * )
     */
    public function update(Request $request, Reservation $reservation, ReservationBLL $reservationBLL)
    {

        $data = $this->getContent($request);

        $reservation = $reservationBLL->actualizaReservation($reservation, $data);

        return $this->getResponse($reservation, Response:: HTTP_OK );

    }

    /**
     * @Route("/reservations/{id}.{_format}",
     *     name="delete_reservation",
     *     requirements={ "id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"DELETE"}
     * )
     */
    public function delete(Reservation $reservation, ReservationBLL $reservationBLL)
    {
        $reservationBLL->delete($reservation);
        return $this->getResponse(null, Response:: HTTP_NO_CONTENT );
    }

}