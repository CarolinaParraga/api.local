<?php

namespace App\BLL;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class BaseBLL
{
    protected EntityManagerInterface $em;
    protected ValidatorInterface $validator;
    protected UserPasswordHasherInterface $encoder;
    protected TokenStorageInterface $tokenStorage;
    protected SluggerInterface $sluggerInterface;
    protected RequestStack $requestStack;
    protected Security $security;
    protected $images_directory;
    protected $images_url;


    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $encoder,
        TokenStorageInterface $tokenStorage,
        SluggerInterface $sluggerInterface,
        RequestStack $requestStack,
        Security $security,
        string $images_directory,
        string $images_url)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->sluggerInterface = $sluggerInterface;
        $this->images_directory = $images_directory;
        $this->images_url = $images_url;


    }

    private function validate($entity)
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0)
        {
            $strError = '';
            foreach($errors as $error)
            {
                if (!empty($strError))
                    $strError .= '\n';
                $strError .= $error->getMessage();
            }
            //devuelve código 400
            throw new BadRequestHttpException($strError);
        }
    }
    //compueba validaciones de la entidad, guarda los datos y devuelve un array para obtener el json
    public function guardaValidando($entity) : array
    {
        $this->validate($entity);

        $this->em->persist($entity);
        $this->em->flush();

        return $this->toArray($entity);
    }

    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function entitiesToArray(array $entities)
    {
        if ( is_null ($entities))
            return null;

        $arr = [];
        foreach ($entities as $entity)
            $arr[] = $this->toArray($entity);

        return $arr;
    }

    /*protected function getUser() : User
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    protected function checkRoleAdmin() {
        $usuario = $this->getUser();

        if ($usuario->hasRole('ROLE_ADMIN') === true)
            return true;

        return false;
    }*/

    

}