<?php


namespace App\service;


use App\Entity\Articles;
use Twig\Environment;

class MailTestServices
{
    private $mailer;
    private $renderer;
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;$this->renderer = $renderer;
    }

    public function notify(Articles $produit)
    {
        $message = (new \Swift_Message('Mail Automatique: '))
            ->setFrom('contact@cesi.fr')
            ->setTo('contact@cesi.fr')
            ->setReplyTo('contact@cesi.fr')
            ->setBody($this->renderer->render('mail.html.twig', ['produit' => $produit]), 'text/html');
        $this->mailer->send($message);}
}