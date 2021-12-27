<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\EventListener;

/**
 * Description of UserVerificationNotifier
 *
 * @author hinso
 */

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserVerificationNotifier
{
	public function postUpdate(User $user, MailerInterface $mailer, LifecycleEventArgs $event, LoggerInterface $logger): void
    {
        // Send email here.
		$logger->info("Made it to the UserVerification Notifier");
		$email = (new Email())
			->from("info@chadhambythesea.org")
			->to($user->getEmailAddress())
			->subject("Finish your Registration for Chadham By The Sea")
			->htmlTemplate('email/newUser.html.twig')
			->context([
				'username' => $user->getEmailAddress(),
				'name' => $user->getName()
			]);
		// ...
		try {
			$mailer->send($email);
		} catch (TransportExceptionInterface $e) {
			
		}		
		
    }
}
