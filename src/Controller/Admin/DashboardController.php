<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Doctrine\ORM\EntityManagerInterface;

use App\Controller\Admin\UserCrudController;

use App\Repository\UserRepository;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    private $userRepository;
    private $adminUrlGenerator;
    private $urlGenerator;
    private $adminContextProvider;
    private $entityManager;

    public function __construct(UserRepository $userRepository, 
                                AdminUrlGenerator $adminUrlGenerator, 
                                UrlGeneratorInterface $urlGenerator,
                                AdminContextProvider $adminContextProvider,
                                EntityManagerInterface $entityManager
    )
    {
        $this->userRepository = $userRepository;
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->urlGenerator = $urlGenerator;
        $this->adminContextProvider = $adminContextProvider;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Project');
    }



    public function configureMenuItems(): iterable
    {
        $menu = [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
        ];
        $menu[] = MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
                            ->setController(UserCrudController::class);

        return $menu;
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $profileMenu = null;
        $profileMenu = MenuItem::linkToUrl('Profile', 'fa fa-user-plus', 
                $this->get(AdminUrlGenerator::class)
                    ->setController(UserCrudController::class)
                    ->setAction('edit')
                    ->includeReferrer()
                    ->setEntityId($this->getUser()->getId()));

        $menu = UserMenu::new()
            ->setName($user->name())
            ->addMenuItems(
                [
                    $profileMenu,
                    MenuItem::section(''),
                    MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
                ]
            );
 
        return $menu;
        
    }
}
