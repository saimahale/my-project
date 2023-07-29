<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use App\Repository\UserRepository;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name');
        $office = TextField::new('office');
        $age = NumberField::new('age');
        $salary = MoneyField::new('salary')->setCurrency('USD');
        // $startDate = DateTimeField::new('startDate');
        $email = EmailField::new('email');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $email, $office, $age, $salary];
        } elseif(Crud::PAGE_DETAIL === $pageName) {
            return parent::configureFields($pageName);
        } else {

            $fields = [
                FormField::addPanel('User Details'),
                $name->setColumns(6),
                $email->setColumns(6),
                $office->setColumns(6),
                $age->setColumns(6),
                $salary->setColumns(6),
                // $startDate->addCssClass('col-md-6')

            ];
            
            return $fields;
        }
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ;
    }

}
