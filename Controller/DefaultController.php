<?php

namespace Jan\MOCDemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $uploadFolder = __DIR__ . "/../../../../web/uploaded-music/";

        $form = $this->makeUploadForm();
        $form->handleRequest($request);

        /**@var $cache CacheProvider */
        $cache = $this->get('ctors.cache');
        if ($form->isValid()) {
            /**
             * @var $file UploadedFile
             */
            $form['song']->getData()->move($uploadFolder, "test");

        }

        return $this->render(
            'JanMOCDemoBundle:Default:index.html.twig',
            array(
                'form' => $form->createView(),
                'cache' => $cache,
                'timestamp' => time(),
                'token' => md5('unique_salt' . time())
            )
        );
    }

    private function makeUploadForm()
    {
        return $this->createFormBuilder()->add('song', 'text')->getForm();

    }
}
