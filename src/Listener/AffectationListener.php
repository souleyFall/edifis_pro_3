<?php

namespace App\Listener;

use App\Entity\Affectation;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs as EventLifecycleEventArgs;

class AffectationListener
{
    public function preRemove(Affectation $affectation, EventLifecycleEventArgs $args): void
    {
        $prestataire = $affectation->getPrestataire();
        if ($prestataire !== null) {
            $prestataire->setDisponible(true);
        }
    }
}
