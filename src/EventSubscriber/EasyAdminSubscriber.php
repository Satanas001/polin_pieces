<?php
namespace App\EventSubscriber ;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $hash)
    {
    }
    
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['hashPassword']
        ] ;
    }

    public function hashPassword(BeforeEntityPersistedEvent $event) 
    {

        $entityInstance = $event->getEntityInstance();
        
        if (!$entityInstance instanceof User) {
            return ;
        }

        $hashed = $this->hash->hashPassword($entityInstance, $entityInstance->getPassword());
        $entityInstance->setPassword($hashed);
    }
}