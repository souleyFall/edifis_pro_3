<?php

namespace App\Controller\Admin;

use App\Entity\Affectation;
use App\Entity\Chantier;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\HttpFoundation\RequestStack;

class AffectationCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Affectation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $chantierId = $this->getSelectedChantierId();

        return [
            AssociationField::new('chantier')->setLabel('Chantier'),

            AssociationField::new('prestataire')
                ->setLabel('Prestataire affectée')
                ->setFormTypeOption('query_builder', function ($repo) use ($chantierId) {
                    if (!$chantierId) {
                        return $repo->createQueryBuilder('o');
                    }

                    // Récupération du chantier et des problèmes
                    $chantier = $this->entityManager->getRepository(Chantier::class)->find($chantierId);
                    $problemes = $chantier?->getProblemes() ?? [];

                    // Création du QueryBuilder
                    $qb = $repo->createQueryBuilder('o')
                        ->leftJoin('o.competences', 'comp');

                    // Si des problèmes sont définis, on filtre
                    if (!empty($problemes)) {
                        $expr = $qb->expr();
                        $orX = $expr->orX();

                        foreach ($problemes as $i => $probleme) {
                            if (is_array($probleme) && isset($probleme['nom'])) {
                                $orX->add($expr->like('LOWER(comp.nom)', ':pb_' . $i));
                                $qb->setParameter('pb_' . $i, strtolower($probleme['nom']));
                            } elseif (is_string($probleme)) {
                                $orX->add($expr->like('LOWER(comp.nom)', ':pb_' . $i));
                                $qb->setParameter('pb_' . $i, strtolower($probleme));
                            }
                        }

                        $qb->where($orX);
                    }

                    return $qb;
                }),

            CollectionField::new('taches')->setLabel('Tâches'),
        ];
    }

    private function getSelectedChantierId(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) return null;

        $formData = $request->get('crud');
        if (isset($formData['form']['chantier'])) {
            return (int) $formData['form']['chantier'];
        }

        return null;
    }
}
