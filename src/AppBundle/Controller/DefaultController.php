<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $number = rand(0, 100);
        echo "Lucky number: $number";

        // replace this example code with whatever you need
        return $this->render(
            'default/index.html.twig',
            [
            'number'   => $number,
//            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }

    public function redirectAction()
    {
        return $this->render('AppBundle/formMail.html.twig');
    }


    public function sendMailAction(Request $request)
    {
        $messageData = [];
        if ('POST' === $request->getMethod()) {
            $messageData['to']      = "vesna@example.com";
            $messageData['from']    = [$request->get('name') => $request->get('email')];
            $messageData['subject'] = 'Contact form submission';
            $messageData['alt']     = true;

            $body = "$request->get('name') \n $request->get('company') \n $request->get('phone') \n $request->get('comment')";

            $messageData['body'] = $body;

//            You can move the business above into a testable class
//              - decide what to do with empty message data
//              - decide what kind of object the converter returns
//              - maybe move the business right to a Swift_Message factory?
//            $converter   = $this->get('message_data_converter');
//            $messageData = $converter->convert($request->get('from'));
        }

        $mailer = $this->get("my_mailer");
        $mailer->send($messageData);

        return $this->render('AppBundle/formMail.html.twig');
    }
    /**
    * @Route("/contact", _name="contact")
    * @Template()
    */
   public function contactAction(Request $request)
   {
       $messageData = [];
       $form = $this->createForm(new ContactType());

       if ($request->isMethod('POST')) {
           $form->bind($request);

           if ($form->isValid()) {
                $messageData['to']      = "admin@example.com";
                $messageData['from']    = [$form->get('name')->getData() => $form->get('email')->getData()];
                $messageData['subject'] = $form->get('subject')->getData();
                $messageData['alt']     = true;

                $body = "$form->get('company')->getData() \n $form->get('phone')->getData() \n $form->get('comment')->getData()";

                $messageData['body'] = $body;

                $mailer = $this->get("my_mailer");
                $mailer->send($messageData);

               $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

               return $this->redirect($this->generateUrl('contact'));
           }
       }

       return array(
           'form' => $form->createView()
       );
   }
}
