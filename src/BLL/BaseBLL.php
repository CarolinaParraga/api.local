<?php

namespace App\BLL;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseBLL
{
    protected EntityManagerInterface $em;
    protected ValidatorInterface $validator;
    protected UserPasswordHasherInterface $encoder;
    protected TokenStorageInterface $tokenStorage;
    protected $images_directory;
    protected $images_url;
    protected RequestStack $requestStack;
    protected Security $security;

    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $encoder,
        TokenStorageInterface $tokenStorage,
        string $images_directory,
        string $images_url,
        RequestStack $requestStack,
        Security $security)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
        $this->images_directory = $images_directory;
        $this->images_url = $images_url;
        $this->requestStack = $requestStack;
        $this->security = $security;
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

    

}