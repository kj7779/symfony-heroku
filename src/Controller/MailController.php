<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController
{
    #[Route('/send', name: 'app_diary_send', methods: ['GET'])]
    public function create(MailerInterface $mailer): Response
    {
        $email = new Email();
        $email
            ->from('kojistill1017@gmail.com')
            ->to('kojistill1212@outlook.jp')
            ->text('メール文言')
            ->html('HTMLメール文言')
        ;
        $mailer->send($email);

        return new Response(
            '<html><body>Lucky number:</body></html>'
        );
    }
}







