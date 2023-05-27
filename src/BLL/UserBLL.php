<?php

namespace App\BLL;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserBLL extends BaseBLL
{
    /*public function nuevo(string $email, string $password, int $phone, string $license, string $name)
    {
        $usuario = new User();
        //guarda en password introducido encriptado
        $usuario->setPassword($this->encoder->hashPassword($usuario, $password));
        $usuario->setEmail($email);
        $usuario->setRoles(['ROLE_USER']);
        $usuario->setPhone($phone);
        $usuario->setLicense($license);
        $usuario->setName($name);

        return $this->guardaValidando($usuario);
    }*/

    public function actualizaUser(User $user, array $data){
        //$user = $this->getUsuario();
        //$moto = new Moto();
        $user->setPassword($this->encoder->hashPassword($user, $data['password']));
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setPhone($data['phone']);
        $user->setLicense($data['license']);
        $user->setName($data['name']);

        return $this->guardaValidando($user);
    }
    public function nuevo(array $data) {
        $user = new User();
        return $this->actualizaUser($user, $data);
    }

    public function profile()
    {
        $user = $this->getUser();

        return $this->toArray($user);
    }

    public function cambiaPassword(string $nuevoPassword) : array
    {
        $user = $this->getUser();
        $user->setPassword($this->encoder->hashPassword($user, $nuevoPassword));
        return $this->guardaValidando($user);
    }
    //método para devolver el usuario
    public function toArray(User $usuario) : array
    {
        if ( is_null ($usuario))
            throw new \Exception("No existe el usuario");
        if (!($usuario instanceof User))
            throw new \Exception("La entidad no es un User");

        return [
            'id' => $usuario->getId(),
            'email' => $usuario->getEmail(),
            'roles' => $usuario->getRoles(),
            'license' => $usuario->getLicense(),
            'name' => $usuario->getName(),
            'phone' => $usuario->getPhone(),
        ];
    }

    Public function getUsers(?string $order, ?string $email , ?int $phone,
                             ?string $license, ?string $name)
    {
        //$user = $this->getUser();
        $users = $this->em->getRepository(User::class)->findUsers($order, $email, $phone,
            $license, $name);

        return $this->entitiesToArray($users);
    }


}