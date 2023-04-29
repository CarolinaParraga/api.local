<?php

namespace App\Controller\API;

use App\BLL\UserBLL;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserApiController extends BaseApiController
{
    /**
     * @Route("/auth/register.{_format}",
     *     name="register",
     *     requirements={"_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"POST"}
     * )
     */
    public function register(Request $request, UserBLL $userBLL)
    {
        $data = $this->getContent($request);
        $user = $userBLL->nuevo($data);

        return $this->getResponse($user, Response:: HTTP_CREATED );
    }

    /**
     * @Route("/user/{id}.{_format}", name="get_user",
     * requirements={
     * "id": "\d+",
     * "_format": "json"
     * },
     * defaults={"_format": "json"},
     * methods={"GET"})
     */
    public function getOne(User $user, UserBLL $userBLL)
    {
        //$motoBLL->checkAccessToActividad($moto);
        return $this->getResponse($userBLL->toArray($user));
    }

    //datos de usuario logueado

    /**
     * @Route("/profile.{_format}",
     *     name="profile",
     *     requirements={"_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"GET"}
     * )
     */
    public function profile(UserBLL $userBLL)
    {
        $user = $userBLL->profile();

        return $this->getResponse($user);
    }

    /**
     * @Route("/users.{_format}",
     *     name="get_users",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json"},
     *     methods={"GET"}
     * )
     * @Route("/users/ordenados/{order}", name="get_users_ordenados")
     */
    public function getAll(
        Request $request, UserBLL $userBLL, string $order='email')
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'El usuario no está autorizado');
        $email = $request->query->get('email');
        $phone = $request->query->get('phone');
        $license = $request->query->get('license');
        $name = $request->query->get('name');


        $users = $userBLL->getUsers($order, $email , $phone, $license, $name);

        return $this->getResponse($users);
    }

    /**
     * @Route("/users/{id}.{_format}",
     *     name="update_user",
     *     requirements={"id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"PUT"}
     * )
     */
    public function update(Request $request, User $user, UserBLL $userBLL)
    {

        $data = $this->getContent($request);

        $user = $userBLL->actualizaUser($user, $data);

        return $this->getResponse($user, Response:: HTTP_OK );

    }

    /**
     * @Route("/users/{id}.{_format}",
     *     name="delete_user",
     *     requirements={ "id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"DELETE"}
     * )
     */
    public function delete(User $user, UserBLL $userBLL)
    {
        $userBLL->delete($user);
        return $this->getResponse(null, Response:: HTTP_NO_CONTENT );
    }

    /**
     * @Route("/profile/password.{_format}",
     *     name="cambia_password",
     *     requirements={"_format": "json"},
     *     defaults={"_format": "json"},
     *     methods={"PATCH"}
     * )
     */
    public function cambiaPassword(Request $request, UserBLL $userBLL)
    {
        $data = $this->getContent($request);
        if ( is_null ($data['password']) || !isset($data['password']) || empty($data['password']))
            throw new BadRequestHttpException('No se ha recibido el password');
        $user = $userBLL->cambiaPassword($data['password']);
        return $this->getResponse($user);
    }

}