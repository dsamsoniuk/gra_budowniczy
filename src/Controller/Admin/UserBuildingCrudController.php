<?php

namespace App\Controller\Admin;

use App\Entity\UserBuilding;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserBuildingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserBuilding::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('building'),
            AssociationField::new('user'),
            ChoiceField::new('status')
                ->setChoices(UserBuilding::getStatusList()),
            DateTimeField::new('create_time'),
            DateTimeField::new('finish_time'),
        ];
    }
    
}
