<?php

namespace App\Controller;

use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $user = new User;
        $jsonUser = json_decode($request->getContent(), true);
        $error = null;

        if (!array_key_exists('username', $jsonUser) || !array_key_exists('password', $jsonUser)) {
            $error = [
                'type'    => 'format',
                'message' => 'json request must have username and password fields'
            ];
        } else {
            try {
                $user->setUsername($jsonUser['username']);
                $user->setPassword($encoder->encodePassword($user, $jsonUser['password']));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            } catch(Exception $e) {
                $error = [
                    'type'    => 'database',
                    'message' => $e->getMessage()
                ];
            }
        }

        if ($error !== null) {
            return new JsonResponse($error, 400);
        }

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
}
