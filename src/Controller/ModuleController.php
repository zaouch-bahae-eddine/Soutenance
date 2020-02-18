<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Entity\Module;
use App\Form\FiliereFormType;
use App\Form\ModuleFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * FiliereController constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/module", name="module_show")
     *  @Route("/module/set/{id}", name="module_set")
     */
    public function showModuleAction(Module $module = null)
    {
        $formVide = $this->createForm(ModuleFormType::class);
        $form = $this->createForm(ModuleFormType::class,$module);
        $repository  = $this->em->getRepository(Module::class);
        $modules = $repository->findAll();
        if(!$module)
            return $this->render('module/showModule.html.twig', [
                'modules' => $modules,
                'moduleForm' => $formVide->createView(),
                'moduleFormSet' =>$form->createView(),
                'idModule' => 0,
            ]);
        return $this->render('module/showModule.html.twig', [
            'modules' => $modules,
            'moduleForm' => $formVide->createView(),
            'moduleFormSet' =>$form->createView(),
            'idModule' => $module->getId(),
        ]);

    }
    /**
     * @Route("/module/add", name="module_add")
     * @Route("/module/add/{id}", name="module_add_set")
     */
    public function addModuleAction(Request $request, Module $module = null)
    {
        $form = $this->createForm(ModuleFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$module){
                $module = $form->getData();
                $msg = "ajouté";
            }
            else{
                $module
                    ->setNom($form->getData()->getNom())
                    ->setFiliere($form->getData()->getFiliere())
                ;
                $msg = "modifié";
            }
            if(!$module->getNom())
                throw new NotFoundHttpException('Nom ne peut pas être null');

            $this->em->persist($module);
            $this->em->flush();
            $this->addFlash('success', 'Module '.$msg);
        }
        return $this->redirectToRoute('module_show');
    }

    /**
     * @Route("/module/remove/{id}", name="module_remove")
     */
    public function removeModuleAction(Module $module)
    {
        if(!$module)
            throw new NotFoundHttpException('Auccune filière a supprimer');
        $this->em->remove($module);
        $this->em->flush();

        $this->addFlash('success', 'Modume supprimé');
        return $this->redirectToRoute('module_show');
    }
}
