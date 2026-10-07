<?php

namespace App\Controller\Admin;

use App\Entity\UserProfile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserProfile::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            NumberField::new('source_gold'),
            AssociationField::new('user')
            // TextEditorField::new('description'),
        ];
    }
    
}
