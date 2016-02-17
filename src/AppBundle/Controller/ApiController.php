<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Images;
use AppBundle\Form\Type\CreateImagesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api/images", name="images_create", methods="POST")
     */
    public function createAction(Request $request)
    {
        $images = new Images;

        $form = $this->createApiForm(CreateImagesType::class, $images);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $filenames = $this->get('app.manager.images')->save($images);

            return new JsonResponse($filenames);
        }

        throw new \Exception('Unable to save images');
    }

    /**
     * @Route("/api/images", name="images_get_all", methods="GET")
     */
    public function getAllAction()
    {
        $uris = $this->get('app.manager.images')->getAll();

        return new JsonResponse(array_map(function($uri) {
            return $this->url($uri);
        }, $uris));
    }

    /**
     * @Route("/api/images/{filename}", name="images_get", methods="GET")
     */
    public function getAction(Request $request, $filename)
    {
        $uri = $this->get('app.manager.images')->get($filename);

        return new JsonResponse(array($this->url($uri)));
    }

    protected function url($uri)
    {
        return $this->get('request_stack')->getMasterRequest()->getSchemeAndHttpHost().$uri;
    }

    protected function createApiForm($type, $data, array $options = array())
    {
        $options = array_merge(
            array(
                'csrf_protection'     => false
            ),
            $options
        );

        return $this->get('form.factory')->createNamed('', $type, $data, $options);
    }

}
