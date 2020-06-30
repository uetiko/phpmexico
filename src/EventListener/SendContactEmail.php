<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Contact;
use App\Entity\Job;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SendContactEmail implements EventSubscriber
{
    /** @var Swift_Mailer */
    protected $mailer;

    /** @var Environment */
    protected $twig;

    /**
     * SendContactEmail constructor.
     */
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var Contact $user */
        $contact = $args->getObject();

        if (!$contact instanceof Contact) {
            return;
        }

        $this->mailer
            ->send($this->message(
                $contact->getDeveloper()->getEmail(),
                $contact->getUser()->getEmail(),
                $contact->getJob()
            ));
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function message(string $email, string $replay, Job $job): Swift_Message
    {
        return (new Swift_Message('Te han enviado una propuesta de trabajo en PHP México'))
            ->setFrom(['no-replay@phpmexico.mx' => 'David Flores de PHPMx'])
            ->setTo($email)
            ->setReplyTo($replay)
            ->setBody(
                $this->twig->render('emails/contact.html.twig', [
                    'description' => $job->getDescription(),
                ]),
                'text/html'
            );
    }
}
