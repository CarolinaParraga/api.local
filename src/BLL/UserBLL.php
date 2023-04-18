<?php

namespace App\BLL;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserBLL extends BaseBLL
{
    public function nuevo(string $email, string $password, int $phone, string $license, string $name)
    {
        $usuario = new User();
        $usuario->setPassword($this->encoder->hashPassword($usuario, $password));
        $usuario->setEmail($email);
        $usuario->setRoles(['ROLE_USER']);
        $usuario->setPhone($phone);
        $usuario->setLicense($license);
        $usuario->setName($name);

        return $this->guardaValidando($usuario);
    }

    /*public function profile()
    {
        $usuario = $this->getUser();

        return $this->toArray($usuario);
    }

    public function cambiaPassword(string $nuevoPassword) : array
    {
        $usuario = $this->getUser();
        $usuario->setPassword($this->encoder->hashPassword($usuario, $nuevoPassword));
        return $this->guardaValidando($usuario);
    }*/

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


}