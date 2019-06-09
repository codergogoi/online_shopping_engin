<?php
/**
 * Created by PhpStorm.
 * User: jmccloskey
 * Date: 2019-06-09
 * Time: 09:07
 */

namespace App\Controller;

use App\Entity\AppUsers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * Class Index
 * @Route("/")
 */
class Index extends AbstractController
{


    /**
     * @Route("/", name="default_index")
     */
    public function index(){

        return $this->json("Default End point", 200);

    }

    /**
     * @Route("/user/api", name="api")
     */

    public function api(){

        return $this->json("Some response Data in JSON Way");
    }


    /**
     * @Route("/user/add", name="add_user", methods={"POST"})
     */

    public function add(Request $request){


        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $appUser = $serializer->deserialize($request->getContent(), AppUsers::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($appUser);
        $em->flush();

        return $this->json($appUser);


    }


    /**
     * @Route("/user/view/{email}", name="view_user")
     */
    public function view($email){

        return $this->json([
            $this->getDoctrine()->getRepository(AppUsers::class)->findBy(['email_id' => $email])
        ]);


    }






}