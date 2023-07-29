<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
 
    private $passwordEncoder;
    private $entityManager;

    public function __construct(
                                UserPasswordEncoderInterface $passwordEncoder,
                                EntityManagerInterface $entityManager)
    {
        
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        
    }
    /**
     * @Route("/", name="app_home")
     */
    public function home()
    {
        return $this->render('security/landing.html.twig');
    }

//     /**
//      * @Route("/login", name="app_login")
//      */
//     public function login(AuthenticationUtils $authenticationUtils): Response
//     {

//         if ($this->getUser()) {
// /*
//             $testUser = $this->userRepository->findOneByEmail('coepme@gmail.com');
//             $user = $this->userRepository->findOneById(1);
//             $package = $this->packageRepository->findOneById(13);
//             $order = $this->orderRepository->findOneById(1);
//             $sub = $this->mpsRepository->findOneById(3);
//             $payout = $this->payoutRepository->findOneById(4);


//             $this->emailer->sendInviteConfirmation($testUser);
//             //$this->emailer->sendWelcomeEmail($testUser);
//             //$this->emailer->sendResetPasswordEmail($testUser, 'password');

//             $this->emailer->sendOrderSuggestedEmail($testUser, $user, $package, $order);

//             $this->emailer->sendNewOrderPlacedEmail($testUser, $order, $sub);
//             $this->emailer->sendSubscriptionOrderPlacedEmail($testUser, $order, $sub);

//             $this->emailer->sendOrderPaidEmail($testUser, $order);

//             $this->emailer->sendOrderPaymentFailedEmail($testUser, $order);
//             $this->emailer->sendOrderPaymentActionRequiredEmail($testUser, $order);

//             $this->emailer->sendPayoutPaidEmail($testUser, $payout);

//             $this->emailer->sendPayoutFailedEmail($testUser, $payout);
//             $this->emailer->sendPayoutReversedEmail($testUser, $payout);
// */

//             if($this->getUser()->isCustomer()){
//                 return $this->redirectToRoute('app_customer');
//             }else if($this->isGranted('ROLE_MANAGER')){
//                 if($this->getUser()->isMerchant()){

//                     if($this->getUser()->isOnboarded()){
//                         return $this->redirectToRoute('app_admin');
//                     } else {
//                         return $this->redirectToRoute('app_admin_merchant_welcome');
//                     }
                    
//                 } else {
//                     return $this->redirectToRoute('app_admin');
//                 }
//             }else {
//                return $this->redirectToRoute('app_login');
//             }
//         }else {

//             // get the login error if there is one
//             $error = $authenticationUtils->getLastAuthenticationError();
//             // last username entered by the user
//             $lastUsername = $authenticationUtils->getLastUsername();

//             $services = $this->categoryRepository->getAll(null);

//             return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 
//                 'error' => $error,
//                 'services' => $services,

//             ]);
//         }
//     }

//     /**
//      * @Route("/forgot", name="app_forgot")
//      */
//     public function forgotAction(Request $request)
//     {
//         $email = $request->request->get('email');
//         $_csrf_token = $request->request->get('_csrf_token');

//         if ($request->isMethod('POST') && $_csrf_token) {
//             $user = $this->userRepository->findOneByEmail($email);

//             if(!$user){
//               $this->get('session')->getFlashBag()->add('danger', 'User with this email doesn\'t exist.');
//               return $this->redirectToRoute('app_login');
//             } else if ($user->getStatus() == Status::ACTIVE){

//                 $newPassword = $this->randomStringGenerator->generate(8);
//                 $user->setPassword($this->passwordEncoder->encodePassword(
//                            $user,
//                            $newPassword
//                        ));

//                 $this->entityManager->persist($user);
//                 $this->entityManager->flush();

//                 $this->emailer->sendResetPasswordEmail($user, $newPassword);

//                 // set flash messages
//                 $this->get('session')->getFlashBag()->add('success', 'We have sent you temporary password to login. Please check your email.');
//                 return $this->redirectToRoute('app_login');
//             }else {
//               $this->get('session')->getFlashBag()->add('danger', 'User with this email is disabled/not active. Please contact administrator.');
//               return $this->redirectToRoute('app_login');
//             }
//         }     

//         return $this->render('security/forgot.html.twig',array(
//             'form' => $form->createView(),
//         ));
//     }

//     /**
//      * @Route("/logout", name="app_logout")
//      */
//     public function logout()
//     {
//         throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//     }
//     /**
//      * @Route("/privacy", name="app_privacy")
//      */
//     public function privacy()
//     {
//         return $this->render('security/privacy.html.twig');
//     }

//     /**
//      * @Route("/terms", name="app_terms")
//      */
//     public function terms()
//     {
//         return $this->render('security/terms.html.twig');
//     }

//     /**
//      * @Route("/register", name="app_register")
//      */
// /*    public function registerAction(Request $request)
//     {
//         $user = new User();

//         $form = $this->createForm(UserFormType::class, $user);
//         $form->handleRequest($request);


//         if ($form->isSubmitted() && $form->isValid()) {
//             $userExists = $userRepository->findOneByEmail($user->getEmail());


//             if($userExists && $userExists->getId()){
//               $this->get('session')->getFlashBag()->add('danger', 'User with this email already exists...');
//               return $this->redirectToRoute('app_register');
//             }else {
//               $user->setPassword($this->passwordEncoder->encodePassword(
//                            $user,
//                            $user->getPassword()
//                        ));

//               $user->setVerificationCode($this->randomStringGenerator->generate(16));
//               $user->setRoles(array(RoleType::USER));
              
//               $this->entityManager->persist($user);
//               $this->entityManager->flush();

//               if($user->getEmail()){
//                 $this->emailer->sendInviteConfirmation($user);
//               }
//                 // set flash messages
//               $this->get('session')->getFlashBag()->add('success', 'You have successfully Registered in our site. Please login to start with us...');
//               return $this->redirectToRoute('app_login');
//             }
//         }     

//         return $this->render('security/register.html.twig',array(
//             'form' => $form->createView(),
//         ));
//     }
//     */

}
