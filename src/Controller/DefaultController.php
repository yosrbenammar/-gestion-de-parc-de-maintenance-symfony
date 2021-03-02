<?php

namespace App\Controller;

use App\Entity\Curative;
use App\Entity\Emplacement;
use App\Entity\Entree;
use App\Entity\FicheDemontage;
use App\Entity\Fournisseur;
use App\Entity\Machine;
use App\Entity\Famille;
use App\Entity\HistoriqueEmplacement;
use App\Entity\DemandeIntervention;
use App\Entity\Magasinier;
use App\Entity\PiecePourinterventionPrevtive;
use App\Entity\PieceRechange;
use App\Entity\PiecesPourIntervention;
use App\Entity\Preventive;
use App\Entity\Sortie;
use App\Entity\SousFamille;
use App\Entity\SousTraitant;
use App\Entity\Technicien;
use App\Entity\Vehicule;
use App\Form\CurativeType;
use App\Form\DemandeInterventionType;
use App\Form\FicheDemontageType;
use App\Form\PreventiveType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OC\PlatformBundle\Form\AdvertType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use OC\PlatformBundle\Form\CollectionType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class DefaultController extends Controller
{
    // page index
    /**
     * @Route("/", name="home_index")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('index.html.twig', ["user"=>$user]);
    }

    //class  employé technicien
    /**
     * @Route("/technicien_ajouter_modifier/{id}", defaults={"id" = null}, name="technicien_ajouter_modifier")
     */
    public function postEdit(Request $request, Technicien $tc = null)
    {
        $manager = $this->getDoctrine()->getManager();

        $isNew = false;
        if ($tc === null){
            $isNew = true;
            $tc = new Technicien();
        }

        $form = $this->createFormBuilder($tc)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)

            ->add('adresse')
            ->add('tel',NumberType::class ,['invalid_message' => 'numéro  non valide'])
            ->add('date_naissance', BirthdayType::class)
            ->add('date_recrutement', DateType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $manager->persist($tc);
                $manager->flush();}
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d\'ajout d"employé  !');}
            $this->addFlash('success'," 'Employé Bien Ajouter  !.");
            return $this->redirectToRoute('list_employes', ['id' => $tc->getId()]);
        }

        return $this->render('ajouter_employe.html.twig',
            ['formEmp' => $form->createView(),
                'editMode' => $tc->getId()  !== null
            ]);


    }
    /**
     * @Route("/list_employes" , name="list_employes")
     */
    public function getAllEmployes(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();

        $tous_employe = $repo->getRepository(Technicien::class)->findAll();

        if ($request->isMethod("POST")) {
            $nom = $request->get('nom');
            $tous_employe = $repo->getRepository(Technicien::class)->findBy(array('nom' => $nom));
        }
        return $this->render('/list_employes.html.twig', ['controller_name' => 'DefaultController', 'tous_employe' => $tous_employe]);
    }
    /**
     * @Route("/Technicien_delete/{id}" , name="delete")
     */
    public function delete(Technicien $employe)
    {

        $repo = $this->getDoctrine()->getManager();
        $tous_employe = $repo->getRepository(Technicien::class)->findAll();
        if($employe->getDemandeInterventions()==null||$employe->getPreventives()==null){

        $repo->remove($employe);
        $repo->flush();
        $this->addFlash('success', 'Technicien Bien supprimer !');}
        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
        }
        return $this->redirectToRoute('list_employes');
    }
    //class  employé technicien
    /**
     * @Route("/magasinier_ajouter_modifier/{id}", defaults={"id" = null}, name="magasinier_ajouter_modifier")
     */
    public function postEditMAG(Request $request, Magasinier $mag = null)
    {
        $manager = $this->getDoctrine()->getManager();

        $isNew = false;
        if ($mag === null){
            $isNew = true;
            $mag = new Magasinier();
        }

        $form = $this->createFormBuilder($mag)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)->add('adresse')
            ->add('tel',NumberType::class ,['invalid_message' => 'numéro non valide'])
            ->add('date_naissance', BirthdayType::class)
            ->add('date_recrutement', DateType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $manager->persist($mag);
                $manager->flush();}
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d\'ajout d"un magasinier  !');}
            $this->addFlash('success'," 'Magasinier Bien Ajouter  !.");
            return $this->redirectToRoute('list_magasinier', ['id' => $mag->getId()]);
        }

        return $this->render('ajouter_employe.html.twig',
            ['formEmp' => $form->createView(),
                'editMode' => $mag->getId()  !== null
            ]);


    }
    /**
     * @Route("/list_magasinier" , name="list_magasinier")
     */
    public function getAllMaggasiner(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();

        $tous_employe = $repo->getRepository(Magasinier::class)->findAll();

        if ($request->isMethod("POST")) {
            $nom = $request->get('nom');
            $tous_employe = $repo->getRepository(Magasinier::class)->findBy(array('nom' => $nom));
        }
        return $this->render('/list_magasinier.html.twig', ['controller_name' => 'DefaultController', 'tous_employe' => $tous_employe]);
    }
    /**
     * @Route("/magasinier_delete/{id}" , name="deletemag")
     */
    public function deletemag(Magasinier $employe)
    {

        $repo = $this->getDoctrine()->getManager();

        $repo->remove($employe);
        $repo->flush();
        $this->addFlash('success', 'Magasinier Bien supprimer !');
        $tous_employe = $repo->getRepository(Magasinier::class)->findAll();

        return $this->redirectToRoute('list_magasinier');
    }
    // famille

    /**
     * @Route("/ajouter_famille ", name="ajouter_famille")
     //* @Route("/famille/{id}/edit" , name="editfam")
     */
    public function formfamille(Famille $famille = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$famille) {
            $famille = new Famille();
        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($famille)
            ->add('libelle', TextType::class)
            ->add('dimension', TextType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
           try{
            $manager->persist($famille);
            $manager->flush();}

           catch (\Doctrine\ORM\EntityNotFoundException $ex) {
               $this->addFlash('error', ' Echec d\'ajout   !');}

            $this->addFlash('success', 'famille Bien Ajouter !');
            return $this->redirectToRoute('familles');

        }


        return $this->render('ajouter_famille.html.twig',
            ['formfam' => $form->createView(),
                'editMode' =>$famille->getId() !== null
            ]);


    }
    /**
     * @Route("/famille/{id}/edit", name="editfam")
     */
    public function modifyfam(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $famille  = $entityManager->getRepository(Famille::class)->find($id);
        $form = $this->createFormBuilder($famille)
            ->add('libelle', TextType::class)
            ->add('dimension', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' Echec d\'ajout  !');}
            $this->addFlash('success', 'Famille Bien  modifier !');
            return $this->redirectToRoute('familles', ['id' => $famille->getId()]);

        }

        return $this->render('ajouter_famille.html.twig', [

            "formfam" => $form->createView(),
            'editMode' => $famille->getId()  !== null
        ]);
    }

    /**
     * @Route("/familles" , name="familles")
     */
    public function getAllfamille(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $famille = $repo->getRepository(Famille::class)->findAll();

        $sousfamilles = $repo->getRepository(SousFamille::class)->findAll();

        $machines = $repo->getRepository(machine::class)->findall($sousfamilles);

        return $this->render('familles.html.twig', ['controller_name' => 'DefaultController', 'familles' => $famille, 'machines' => $machines, 'sousfamilles' => $sousfamilles]);
    }

    /**
     * @Route("/famille_delete/{id}" , name="deletefam")
     */
    public function deletefamille(Famille $fam)
    {

        $repo = $this->getDoctrine()->getManager();
        $famille= $repo->getRepository(Famille::class)->findAll();
        if($fam->getSousfamille()==null){
        $repo->remove($fam);
        $repo->flush();
        $this->addFlash('success', 'famille Bien supprimer !');}
        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
            }
        return $this->redirectToRoute('familles');
    }
    // famille

    /**
     * @Route("/ajouter_sousfamille", name="ajouter_sousfamille")
     */
    public function formsousfamille(Famille $famille = null, SousFamille $sf = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$sf) {
            $sf = new SousFamille();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($sf)
            ->add('libelle', TextType::class)
            ->add('marque', TextType::class)
            ->add('fam', EntityType::class, ['class' => Famille::class, 'choice_label' => 'libelle','placeholder' => '---- Aucune ----' ,
                ])
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
             try {
                $manager->persist($sf);
                $manager->flush();

                  }
                catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                    $this->addFlash('error', ' Echec d\'ajout   !');
                }
            $this->addFlash('success', ' sous machine Bien Ajouter !');
            return $this->redirectToRoute('sousfamilles');


        }
        return $this->render('ajouter_sousfamille.html.twig',
            ['formsf' => $form->createView(),
                'editMode' => $sf->getId() !== null
            ]);


    }
    /**
     * @Route("/sousfamille/{id}/edit", name="editsf")
     */
    public function modifysf(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sf  = $entityManager->getRepository(SousFamille::class)->find($id);
        $form = $this->createFormBuilder($sf)
            ->add('libelle', TextType::class)
            ->add('marque', TextType::class)
            ->add('fam', EntityType::class, ['class' => Famille::class, 'choice_label' => 'libelle'])
            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' Echec d\'ajout   !');
            $this->generateUrl('erreur400');}
            $this->addFlash('success', 'Sous_Famille Bien  modifier !');
            return $this->redirectToRoute('sousfamilles', ['id' => $sf->getId()]);

        }

        return $this->render('ajouter_sousfamille.html.twig', [

            "formsf" => $form->createView(),
            'editMode' => $sf->getId()  !== null
        ]);
    }


    /**
     * @Route("/sousfamilles" , name="sousfamilles")
     */
    public function getAllsousfamille(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $famille = $repo->getRepository(Famille::class)->findAll();

        $sousfamilles = $repo->getRepository(SousFamille::class)->findAll();

        $machines = $repo->getRepository(machine::class)->findall($sousfamilles);

        return $this->render('sousfamilles.html.twig', ['controller_name' => 'DefaultController', 'familles' => $famille, 'machines' => $machines, 'sousfamilles' => $sousfamilles]);
    }
    /**
     * @Route("/Sousfamille_delete/{id}" , name="deletesf")
     */
    public function deleteSousfamille(SousFamille $sf)
    {

        $repo = $this->getDoctrine()->getManager();
        $sousfamille= $repo->getRepository(SousFamille::class)->findAll();
        if($sf->getFam()==null ){
            $repo->remove($sf);
            $repo->flush();
            $this->addFlash('success', ' sous famille Bien supprimer !');}
        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
        }
        return $this->redirectToRoute('sousfamilles');
    }

    // class machine

    /**
     * @Route("/machines" , name="machines")
     */
    public function getAllMachine(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $machines = $repo->getRepository(Machine::class)->findAll();
        $sousfamilles = $repo->getRepository(SousFamille::class)->findAll();
        $machine=$repo->getRepository(Machine::class)->findBy(array('etat' => 'fonctionnelle'));

        return $this->render('tout_machines.html.twig', ['controller_name' => 'DefaultController', 'machines' => $machines, 'sousfamilles' => $sousfamilles]);
    }

    /**
     * @Route("/ajouter_machine ", name="ajouter_machine")
  //  * @Route("/machine/{id}/edit" , name="editmachine")
     */
    public function formMachine(Machine $machine = null, Emplacement $empl = null, HistoriqueEmplacement $histo = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$machine) {
            $machine = new Machine();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($machine)
            ->add('libelle', TextType::class)
            ->add('numero_serie', NumberType::class ,['invalid_message' => 'numéro de série non valide'])
            ->add('dateInstalation', BirthdayType::class)
            ->add('sous_famille', EntityType::class, ['class' => SousFamille::class, 'choice_label' => 'libelle','placeholder' => '---- Aucune ----'])
            ->add('emplacement', EntityType::class, ['class' => Emplacement::class, 'choice_label' => 'libelle','placeholder' => '---- Aucun ----'])
            ->getForm();
        $form->handleRequest($request);

        $histo = new HistoriqueEmplacement();

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $machine->setetat('fonctionnelle');
                $machine->setDatePrchaineEntretient(new \DateTime('+1 month'));

            $manager->persist($machine);
            $manager->flush();

            $histo->setDateChangement(new \DateTime());

            $histo->setMachine($machine);

            $empl = $machine->getEmplacement();
            $histo->setEmplacement($empl);
            $manager->persist($histo);
            $manager->flush();}
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d\'ajout   !');}

            $this->addFlash('success', 'machine Bien Ajouter !');
            return $this->redirectToRoute('machines');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_machine.html.twig',
            ['formmachine' => $form->createView(), 'editMode' => $machine->getId() !== null,'f ' => $machine->getEtat()=='fonctionnelle'
            ]);


    }
    /**
     * @Route("/machine/{id}/edit", name="editmachine")
     */
    public function modifymachine(Request $request, int $id, EntityManagerInterface $manager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $machine = $entityManager->getRepository(Machine::class)->find($id);
        $form = $this->createFormBuilder($machine)
            ->add('libelle', TextType::class)
            ->add('numero_serie',NumberType::class ,['invalid_message' => 'numéro de série non valide'])

            ->add('dateInstalation', BirthdayType::class)
            ->add('sous_famille', EntityType::class, ['class' => SousFamille::class, 'choice_label' => 'libelle'])
            ->add('emplacement', EntityType::class, ['class' => Emplacement::class, 'choice_label' => 'libelle'])
            ->getForm();


        $form->handleRequest($request);
        $histo = new HistoriqueEmplacement();
        if($form->isSubmitted() && $form->isValid())
        { try{

            $histo->setDateChangement(new \DateTime());
            $machine->setDatePrchaineEntretient(new \DateTime('+1 month'));

            $histo->setMachine($machine);
            $empl = $machine->getEmplacement();
            $histo->setEmplacement($empl);

            $manager->persist($histo);

            $manager->persist($machine);
            $manager->flush();

            $this->addFlash('success', 'Machine Bien  modifier !');
            return $this->redirectToRoute('machines', ['id' => $machine->getId()]);

          }
        catch (\Doctrine\ORM\EntityNotFoundException $ex)
       { $this->addFlash('error', ' un erreur se porduit lors de la modification   !');
       }
        }

        return$this->render('ajouter_machine.html.twig',
        ['formmachine' => $form->createView(), 'editMode' => $machine->getId() !== null,
        ]);
    }
    /**
     * @Route("/machine/{id}/delete " , name="deletemachine")
     */
    public function deletemachine(Machine $m)
    {
        $repo = $this->getDoctrine()->getManager();
        if ($m->getPreventives()==null || $m->getDemandeInterventions()==null  ) {
            $repo->remove($m);
            $repo->flush();

            $this->addFlash('success', 'machine Bien supprimer !');
        }

        else{

            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
            }

        return $this->redirectToRoute('machines');

    }


    //calss emplacement

    /**
     * @Route("/emplacements" , name="emplacements")
     */
    public function getAllEmlacement(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $emplacements = $repo->getRepository(Emplacement::class)->findAll();

        foreach ($emplacements as $emplacement) {
            $machine = $repo->getRepository(machine::class)->find($emplacement);

        }
        return $this->render('tous_emplacement.html.twig', ['controller_name' => 'DefaultController', 'emplacements' => $emplacements, 'machine' => $machine]);
    }

    //  ajout et modification d'une emplacement

    /**
     * @Route("/ajouter_emplacement ", name="ajouter_emplacement")
     //* @Route("/emplacement/{id}/edit" , name="ed")
     */
    public function formEmplacement(Emplacement $empl = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$empl) {
            $empl = new Emplacement();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($empl)
            ->add('libelle', TextType::class)
            ->add('ville', TextType::class)
            ->add('batiment', TextType::class)
            ->add('description', TextareaType::class, [
                'required'   => false])
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
      try{
            $manager->persist($empl);
            $manager->flush();}
         catch (\Doctrine\ORM\EntityNotFoundException $ex) {
               $this->addFlash('error', ' Echec d\'ajout   !');}



            $this->addFlash('success', 'emplacement Bien Ajouter  !');
            return $this->redirectToRoute('emplacements');

        }
        return $this->render('ajouter_emplacement.html.twig', ['formempl' => $form->createView(), 'editMode' => $empl->getId() !== null]);


    }
    /**
     *  @Route("/emplacement/{id}/edit" , name="ed")
     */
    public function modifemp(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $emp = $entityManager->getRepository(Emplacement::class)->find($id);
        $form = $this->createFormBuilder($emp)
            ->add('libelle', TextType::class)
            ->add('ville', TextType::class)
            ->add('batiment', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', '  un erreur se porduit lors de la modification  !');}
            $this->addFlash('success', 'Emplacement Bien  modifier !');
            return $this->redirectToRoute('emplacements', ['id' => $emp->getId()]);

        }

        return $this->render('ajouter_emplacement.html.twig', [
            "formempl" => $form->createView(),
            'editMode' => $emp->getId()  !== null
        ]);
    }
    /**
     * @Route("/emplacement/{id}/delete " , name="deleteempla")
     */
    public function deleteemp(Emplacement $emp)
    {
        $repo = $this->getDoctrine()->getManager();
        if ( $emp->getMachines()==null ) {
            $repo->remove($emp);
            $repo->flush();
            $this->addFlash('success', 'Emplacement  Bien supprimer !');
        }

        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
        }

        return $this->redirectToRoute('emplacements');

    }



    //list d'historique par

    /**
     * @Route("/historique/{id}", name="historique")
     */
    public function historique(Request $request, $id)

    {

        $repo = $this->getDoctrine()->getManager();
        $machine = $repo->getRepository(Machine::class)->find($id);
        $tous_hist = $repo->getRepository(HistoriqueEmplacement::class)->findByMachine($machine);
        //$emplacement = $repo->getRepository(Emplacement::class)->findall();
        $emplacement = $machine->getEmplacement();
        return $this->render('historiqueEmplacement.html.twig', ['tous_hist' => $tous_hist, 'emlpacement' => $emplacement, 'machine' => $machine
        ]);
    }
    //class piece rechange

    /**
     * @Route("/piecesRechange" , name="piecesRechange")
     */
    public function getAllpiece(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $pieces = $repo->getRepository(PieceRechange::class)->findAll();

        return $this->render('piecesRechange.html.twig', ['controller_name' => 'DefaultController', 'pieces' => $pieces]);
    }

    //  ajout et modification d'une piece

    /**
     * @Route("/ajouter_pieceRechange ", name="ajouter_pieceRechange")

     */
    public function formpiece(PieceRechange $pr = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$pr) {
            $pr = new PieceRechange();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($pr)
            ->add('designation', TextType::class)
            ->add('quantite', TextType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $manager->persist($pr);
                $manager->flush();
            }
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d\'ajout   !');}


            $this->addFlash('success', 'piece de Rechange Bien Ajouter  !');
            return $this->redirectToRoute('piecesRechange');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_pieceRechange.html.twig', ['formpr' => $form->createView(), 'editMode' => $pr->getId() !== null]);


    }
    /**
     *   * @Route("/pieceRechange/{id}/edit" , name="editpr")
     */
    public function modifpr(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $pr = $entityManager->getRepository(PieceRechange::class)->find($id);
        $form = $this->createFormBuilder($pr)
            ->add('designation', TextType::class)
            ->add('quantite', TextType::class)

            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' un erreur se porduit lors de la modification   !');}
            $this->addFlash('success', 'piéce de rechange Bien  modifier !');
            return $this->redirectToRoute('piecesRechange', ['id' => $pr->getId()]);

        }

        return $this->render('ajouter_pieceRechange.html.twig', [

            "formpr" => $form->createView(),
            'editMode' => $pr->getId()  !== null
        ]);
    }
    /**
     * @Route("/piece/{id}/delete " , name="deletepr")
     */
    public function deletepr( PieceRechange $p)
    {
        $repo = $this->getDoctrine()->getManager();
        if ( $p->getPiecePourinterventionPrevtives()==null || $p->getEntrees()==null || $p->getPiecePourIntervention()==null ) {
            $repo->remove($p);
            $repo->flush();
            $this->addFlash('success', 'Piece de rechange  Bien supprimer !');
        }

        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
        }

        return $this->redirectToRoute('piecesRechange');

    }


    //class piece Entree

    /**
     * @Route("MAG/entrees" , name="entrees")
     **/
    public function getAllpieceentree(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $entrees = $repo->getRepository(Entree::class)->findAll();


        return $this->render('entrees.html.twig', ['controller_name' => 'DefaultController', 'entrees' => $entrees]);
    }

    //  ajout et modification d'un entree

    /**
     * @Route("/ajouter_entree ", name="ajouter_entree")

     */
    public function formentree(PieceRechange $pr = null, Entree $ent = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$ent) {
            $ent = new Entree();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($ent)
            ->add('pieceRechange', EntityType::class, ['class' => PieceRechange::class, 'choice_label' => 'designation',
                'placeholder' => '---- Aucune ----'])
            ->add('quantite', IntegerType::class)
          //  ->add('fournisseur', EntityType::class, ['class' => Fournisseur::class, 'choice_label' => 'nom'])
            ->add('source', ChoiceType::class, [
                'placeholder' => '---- Aucune ----',
                'choices' => [

                    'founisseur' => array(
                        'tout pieces' => 'tout pieces' ,
                        'SPAB' => 'SPAB',
                        'SosPieces' =>  'SosPieces',
                    ) ,

                    'Défaillance' =>  'Défaillance',
                    'Don' =>'Don'
                ]
            ])

          // ->add('fournisseur', EntityType::class, ['class' => Fournisseur::class, 'choice_label' => 'nom'])


            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $ent->setDate(new \DateTime());


                $manager->persist($ent);
                $manager->flush();
                $pr = new PieceRechange();
                $pr = $ent->getPieceRechange();
                $stock = $ent->getQuantite();
                $stockent = $pr->getQuantite();
                $stock = $stock + $stockent;
                $pr->setQuantite($stock);
                $manager->persist($pr);
                $manager->flush();
            }
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d\'ajout   !');}

            $this->addFlash('success', '  entrée de piece de Rechange Bien Ajouter  !');
            return $this->redirectToRoute('entrees');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_entree.html.twig', ['forment' => $form->createView(), 'editMode' => $ent->getId() !== null]);


    }
    /**
     * @Route("/entree/{id}/edit" , name="editent")
     */

    public function modifent(PieceRechange $pr = null ,Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ent= $entityManager->getRepository(Entree::class)->find($id);
          $form = $this->createFormBuilder($ent)
            ->add('pieceRechange', EntityType::class, ['class' => PieceRechange::class, 'choice_label' => 'designation',
            'placeholder' => '---- Aucune ----'])
                ->add('quantite', IntegerType::class)
                ->add('source', ChoiceType::class, [
                    'placeholder' => '---- Aucune ----',
                    'choices' => [

                        'founisseur' => true,
                        'Défaillance' => false,
                        'Don' => null,
                    ]
                ])

            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();
            $pr = new PieceRechange();
            $pr = $ent->getPieceRechange();
            $stock = $ent->getQuantite();
            $stockent = $pr->getQuantite();
            $stock = $stock + $stockent;
            $pr->setQuantite($stock);
            $entityManager->persist($pr);
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' un erreur se porduit lors de la modification   !');}

            $this->addFlash('success', ' entrée de piéce de rechange Bien  modifier !');
            return $this->redirectToRoute('entrees', ['id' => $ent->getId()]);

        }

        return $this->render('ajouter_entree.html.twig', [

            "forment" => $form->createView(),
            'editMode' => $ent->getId()  !== null
        ]);
    }


    // class fournisseur

    /**
     * @Route("/fournisseurs" , name="fournisseurs")
     **/
    public function getAllfournisseur(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $fournisseurs = $repo->getRepository(fournisseur::class)->findAll();


        return $this->render('fournisseurs.html.twig', ['controller_name' => 'DefaultController', 'fournisseurs' => $fournisseurs]);
    }



    /**
     * @Route("/ajouter_fournisseur ", name="ajouter_fournisseur")

     */
    public function formfr(Fournisseur $fr = null, Request $request, EntityManagerInterface $manager)
    {
       // $x = new Curative();
       // $x->setEtat('aa');
        if (!$fr) {
            $fr = new Fournisseur();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($fr)
            ->add('nom', TextType::class)
            ->add('adress', TextType::class)
            ->add('tel', NumberType::class ,['invalid_message' => 'numéro non valide'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       try{
            $manager->persist($fr);
            $manager->flush();}
      catch (\Doctrine\ORM\EntityNotFoundException $ex) {
    $this->addFlash('error', ' Echec d\'ajout   !');}

            $this->addFlash('success', ' fourssieur Bien Ajouter  !');
            return $this->redirectToRoute('fournisseurs');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_fournisseur.html.twig', ['formfr' => $form->createView(),'editMode' => $fr->getId()  !== null]);


    }
    /**
     * @Route("/fournisseur/{id}/edit ", name="editfr")

     */
    public function modiffournisseur(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $fr= $entityManager->getRepository(Fournisseur::class)->find($id);
        $form = $this->createFormBuilder($fr)
            ->add('nom', TextType::class)
            ->add('adress', TextType::class)
            ->add('tel',NumberType::class ,['invalid_message' => 'numéro non valide'])
            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' un erreur se porduit lors de la modification   !');}

            $this->addFlash('success', ' fournisseur Bien  modifier !');
            return $this->redirectToRoute('fournisseurs', ['id' => $fr->getId()]);

        }

        return $this->render('ajouter_fournisseur.html.twig', [

            "formfr" => $form->createView(),
            'editMode' => $fr->getId()  !== null
        ]);
    }




    /**
     * @Route("/fournisseur/{id}/delete " , name="deletefr")
     */
    public function deletefr( int $id)
    {

        $repo = $this->getDoctrine()->getManager();
        $fournisseurs = $repo->getRepository(Fournisseur::class)->findAll();
        $fr = $repo->getRepository(Fournisseur::class)->find($id);
        if ( $fr->getEntrees() == null) {
            $repo->remove($fr);
            $repo->flush();
            $this->addFlash('success', 'Fournisseur Bien supprimer !');
        }

        else{
            $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
        }

        return $this->redirectToRoute('fournisseurs');

    }


//calss vehicule

    /**
     * @Route("/vehicules" , name="vehicules")
     **/
    public function getAllvehicules(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $vehicules = $repo->getRepository(Vehicule::class)->findAll();


        return $this->render('Vehicules.html.twig', ['controller_name' => 'DefaultController', 'vehicules' => $vehicules]);
    }

    //  ajout et modification d'un entree

    /**
     * @Route("/ajouter_vehicule ", name="ajouter_vehicule")

     */
    public function formvc(Vehicule $vc = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$vc) {
            $vc = new Vehicule ();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($vc)
            ->add('matricule', TextType::class)
            ->add('type', TextType::class)
            //   ->add('etat' ,TextType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
      try{
            $manager->persist($vc);
            $manager->flush();}
      catch (\Doctrine\ORM\EntityNotFoundException $ex) {
          $this->addFlash('error', ' Echec d"ajout   !');}
            $this->addFlash('success', ' Vehicule Bien Ajouter  !');
            return $this->redirectToRoute('vehicules');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_vehicule.html.twig', ['formvc' => $form->createView(), 'editMode' => $vc->getId() !== null]);


    }
    /**
     * @Route("/vehicule/{id}/edit" , name="editvc")

     */
    public function modifvehicule(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $vc= $entityManager->getRepository(Vehicule::class)->find($id);
        $form = $this->createFormBuilder($vc)
            ->add('matricule', TextType::class)
            ->add('type', TextType::class)
            ->getForm();
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid())
        { try{
            $entityManager->flush();}
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' un erreur se porduit lors de la modification   !');}

            $this->addFlash('success', ' vehicule Bien  modifier !');
            return $this->redirectToRoute('vehicules', ['id' => $vc->getId()]);

        }

        return $this->render('ajouter_vehicule.html.twig', [

            "formvc" => $form->createView(),
            'editMode' => $vc->getId()  !== null
        ]);
    }


    /**
     * @Route("vehicule/{id}/delete " , name="deletevc")
     */
    public function deleteent($id)
    {
        $repo = $this->getDoctrine()->getManager();
        $entrees = $repo->getRepository(Vehicule::class)->findAll();
        $entree = $repo->getRepository(Vehicule::class)->find($id);
        if ( $entree->getPreventives()==null ||$entree->getCuratives()==null ) {
            $repo->remove($entree);
            $repo->flush();
            $this->addFlash('success', 'vehicule Bien supprimer !');}
        else{
                $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
            }

        return $this->redirectToRoute('vehicules');
    }
    //class soustraitant

    /**
     * @Route("/sousTraitants" , name="sousTraitants")
     **/
    public function getAllsoustraitant(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $sousTraitants = $repo->getRepository(SousTraitant::class)->findAll();


        return $this->render('sousTraitants.html.twig', ['controller_name' => 'DefaultController', 'sousTraitants' => $sousTraitants]);
    }

    //  ajout et modification d'un Soustraitant

    /**
     * @Route("/ajouter_sousTraitant ", name="ajouter_sousTraitant")
     */
    public function formst(SousTraitant $st = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$st) {
            $st = new SousTraitant ();

        }

        //creation du formulaire dans le controller
        $form = $this->createFormBuilder($st)
            ->add('nom', TextType::class)
            ->add('dateDebutContract', DateType::class)
            ->add('dateFinContract', DateType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         try{
            $manager->persist($st);
            $manager->flush();}
         catch (\Doctrine\ORM\EntityNotFoundException $ex) {
     $this->addFlash('error', ' Echec d"ajout   !');}
            $this->addFlash('success', ' Sous_traitant Bien Ajouter  !');
            return $this->redirectToRoute('sousTraitants');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_sousTraitant.html.twig', ['formst' => $form->createView(), 'editMode' => $st->getId() !== null]);


    }
    /**
    * @Route("/sousTraitant/{id}/edit" , name="edit")
     */

    public function modifsous_traitant(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $st= $entityManager->getRepository(SousTraitant::class)->find($id);
        $form = $this->createFormBuilder($st)
            ->add('nom', TextType::class)
            ->add('dateDebutContract', DateType::class)
            ->add('dateFinContract', DateType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        { try {
            $entityManager->flush();
        }
        catch (\Doctrine\ORM\EntityNotFoundException $ex) {
            $this->addFlash('error', ' un erreur se porduit lors de la modification   !');}
            $this->addFlash('success', ' sous-traitant Bien  modifier !');
            return $this->redirectToRoute('sousTraitants', ['id' => $st->getId()]);

        }

        return $this->render('ajouter_sousTraitant.html.twig', [

            "formst" => $form->createView(),
            'editMode' => $st->getId()  !== null
        ]);
    }
    /**
     * @Route("/esous_traitant/{id}/delete " , name="deletest")
     */
    public function deletest($id)
    {

        $repo = $this->getDoctrine()->getManager();

        $st = $repo->getRepository(SousTraitant::class)->find($id);
        if ($st->getCuratives()==null|| $st->getPreventives()==null ||$st->get()==null) {

            // $sup $st->$this->getPreventives()::Count();{
            //     $this->addFlash('error', ' imposible de supprimer ce sous-traitant car il est referencé dans intervention preventive  !');

            //  $this->redirectToRoute('sousTraitants');
            //}
            $repo->remove($st);
            $repo->flush();
            $this->addFlash('success', 'sous-traitant Bien supprimer !');}
        else{
                $this->addFlash('error', ' Cette Opération est bloquée a cause des contraintes d"integrité  !');
            }
        return $this->redirectToRoute('sousTraitants');

        }




    // class intervention preventive
    /**
     * @Route("/InterventionsPreventives" , name="InterventionsPreventives")
     **/
    public function getAllInterventionPreventive(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $InterventionsPreventives = $repo->getRepository(Preventive::class)->findAll();


        return $this->render('InterventionsPreventives.html.twig', ['controller_name' => 'DefaultController', 'InterventionsPreventives' => $InterventionsPreventives]);
    }

//class demandeIntervention

    /**
     * @Route("/demandeIntervention" , name="demandeInterventions")
     **/
    public function getAlldemandeInterventions(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();
        $demandeInterventions = $repo->getRepository(DemandeIntervention::class)->findAll();


        return $this->render('demandeInterventions.html.twig', ['controller_name' => 'DefaultController', 'demandeInterventions' => $demandeInterventions]);
    }

    //  ajout et modification d'un demandeIntervention



    /**
     * @Route("/ajouter_demandeIntervention ", name="ajouter_demandeIntervention")

     */
    public function formdemandeIntervention(DemandeIntervention $demandeIntervention = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$demandeIntervention) {
            $demandeIntervention = new DemandeIntervention();

        }

        //creation du formulaire dans le controller
        $form = $this->createForm(DemandeInterventionType::class,$demandeIntervention);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $demandeIntervention->setDate(new \DateTime());

                $machine=$demandeIntervention->getMachine();
                $machine->setEtat('en_panne');
                $manager->persist($machine);
                $manager->persist($demandeIntervention);

                $manager->flush();
            }
            catch (\Doctrine\ORM\EntityNotFoundException $ex) {
                $this->addFlash('error', ' Echec d"ajout  !');}
            $this->addFlash('success', 'demande d"intervention Bien Ajouter  !');
            return $this->redirectToRoute('demandeInterventions');

        } else {

            $this->generateUrl('erreur400');

        }
        return $this->render('ajouter_panne.html.twig', ['formpn' => $form->createView(), 'editMode' => $demandeIntervention->getId() !== null]);


    }
    /**
     * @Route("/demandeIntervention/{id}/edit" , name="editpn")

     * * @IsGranted("ROLE_ADMIN", statusCode=404, message="acces imposible")
     */
    public function modifdemandePanne(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dp= $entityManager->getRepository(DemandeIntervention::class)->find($id);
        $form = $this->createForm(DemandeInterventionType::class,$dp);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try{
            $entityManager->flush();}
        catch(\Doctrine\DBAL\DBALException $e) {
            $this->get('session')->getFlashBag()->add('error', ' un erreur se porduit lors de la modification .');
        }

            $this->addFlash('success', ' demande d"intervention Bien  modifier !');
            return $this->redirectToRoute('demandeInterventions', ['id' => $dp->getId()]);

        }

        return $this->render('ajouter_panne.html.twig', [

            "formpn" => $form->createView(),
            'editMode' => $dp->getId()  !== null
        ]);
    }


    /**
     * @Route("/interventionpreventive_ajouter_modifier/{id}", defaults={"id" = null}, name="interventionp_ajouter_modifier")
     */
    public function formpreventive(  Request $request, EntityManagerInterface $manager,  Preventive $preventive = null)
    {

            $new = false;
            if (!$preventive) {
                $preventive = new Preventive();
                $new=false;

            }

            //creation du formulaire dans le controller


            $form = $this->createForm(PreventiveType::class,$preventive);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                TRY {
                    $preventive->setDateDebut($preventive->getMachine()->getDatePrchaineEntretient());
                    $preventive->setEtat('en_attente');
                    $preventive->getMachine()->setEtat('en_cours_de_reparation');

                    $manager->persist($preventive);
                }
                catch (\Doctrine\ORM\EntityNotFoundException $ex)
                    { $this->addFlash('error', 'Intervention Préventive Bien Modifier  !');}
                $pieces = key_exists('pieces',$form->getExtraData()) ? $form->getExtraData()['pieces'] : [];
                foreach ($pieces as $pieceQuantity){

                    $pr = $manager->getRepository(PieceRechange::class)->find($pieceQuantity['piece_id']);
                    $ppi = new PiecePourinterventionPrevtive();
                    $ppi->setIntervention($preventive);
                    $ppi->setPiece($pr);
                    $ppi->setQuantite($pieceQuantity['quantity']);

                    if($pieceQuantity['quantity'] > $pr->getQuantite())
                    {
                        echo "<script language=\"javascript\" >alert(\"la quantité saisie non disponible! contacter le magasinier \")
                        </script>";
                    }

                    $pr->setQuantite($pr->getQuantite() - $pieceQuantity['quantity']);

                    $preventive->getMachine()->setEtat('en_cours_de_reparation');
                    $preventive->getMachine()->setDatePrchaineEntretient(new \DateTime());
                       $sysdate=new \DateTime();

                    if($preventive->getDateFin() >= $sysdate){
                        $preventive->setEtat('réalisée');
                        $preventive->getMachine()->setEtat('fonctionnelle');
                    }


                    $manager->persist($ppi);
                    $manager->persist($pr);
                   }
                $manager->flush();

               // $machine->setEtat('en demandeIntervention');;

                    if($new==true){
                        $this->addFlash('success', 'Intervention Préventive Bien Ajouter  !');
                    }
                    else{
                        $this->addFlash('success', 'Intervention Préventive Bien Modifier  !');
                    }

                return $this->redirectToRoute('interventionsPREVENTIVES');}


            return $this->render('ajouter_InterventionPreventive.html.twig', [
                'pieces' => $manager->getRepository(PieceRechange::class)->findAll(),
                'formip' => $form->createView(),
                'editMode' => $preventive->getId() !== null
            ]);
        }


    /**
     * @Route("/interventionsPREVENTIVES" , name="interventionsPREVENTIVES")
     **/
    public function getinterventionsPREVENTIVES(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $interventionps= $repo->getRepository(Preventive::class)->findAll();


        return $this->render('interventionPreventives.html.twig', ['controller_name' => 'DefaultController', 'interventionps' => $interventionps]);
    }

    /**
     * @Route("/interventionpreventive_imprimer/{id}" , name="interventionpreventive_imprimer")
     **/
    public function kk ($id)
    {
        $repo = $this->getDoctrine()->getManager();
        $interventionpreventive= $repo->getRepository(Preventive::class)->find($id);

        $ppi=$interventionpreventive->getPiecePourinterventionPrevtives();
        $technicien=$interventionpreventive->getTechnicien();
        return $this->render('interventionpreventive.html.twig', ['ppi'=>$ppi,'controller_name' => 'DefaultController', 'interventionpreventive' => $interventionpreventive,'technicien'=>$technicien]);
    }


    //class intervention sortie


    /**
     * @Route("/interventioncurative_ajouter_modifier/{id}", defaults={"id" = null}, name="interventioncurative_ajouter_modifier")
     */
    public function formcurative(  Request $request, EntityManagerInterface $manager,  Curative $curative = null)
    {

          $new = false;
        if (!$curative) {
            $curative = new Curative();
            $new=false;

        }

        //creation du formulaire dans le controller


        $form = $this->createForm(CurativeType::class,$curative);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            TRY {
                $curative->setDateDebut(new \DateTime());
                $curative->setEtat('en_attente');
                $sysdate=new \DateTime();
                if($curative->getDateFin()>=$sysdate){
                    $curative->setEtat('réalisée');
                    $curative->getDemandeIntervention()->getMachine()->setEtat('fonctionnelle');
                }
                $manager->persist($curative);
            }

            catch (\Doctrine\ORM\EntityNotFoundException $ex)
            { $this->addFlash('error', 'un erreur se produit   !');
            }

            $pieces = key_exists('pieces',$form->getExtraData()) ? $form->getExtraData()['pieces'] : [];

            foreach ($pieces as $pieceQuantity){
                $pr = $manager->getRepository(PieceRechange::class)->find($pieceQuantity['piece_id']);

                $ppi = new PiecesPourIntervention();
                $ppi->setIntervention($curative);
                $ppi->setPiece($pr);
                $ppi->setQuantite($pieceQuantity['quantity']);

                if($ppi>$pr->getQuantite())
                {
                    echo "<script language=\"javascript\"> alert(\"la quantité saisie non disponible! contacter le magasinier \")
                        </script>";
                    $this->addFlash('error', 'la quantité saisie non disponible! contacter le magasinier  !');
                }

                $pr->setQuantite($pr->getQuantite()-(float)$pieceQuantity['quantity']);

                $machine = $curative->getDemandeIntervention()->getMachine();
                $machine->setEtat('en_cours_de_reparation');

                $manager->persist($ppi);
                $manager->persist($pr);
                $manager->persist($machine);
            }


            $manager->flush();

            // $machine->setEtat('en demandeIntervention');;

            if($new==true){
                $this->addFlash('success', 'Intervention curative Bien Ajouter  !');
            }
            else{
                $this->addFlash('success', 'Intervention curative Bien Modifier  !');
            }

            return $this->redirectToRoute('interventionsCuratives');}


        return $this->render('ajouter_InterventionCuratives.html.twig', [
            'pieces' => $manager->getRepository(PieceRechange::class)->findAll(),
            'formic' => $form->createView(),
            'editMode' => $curative->getId() !== null
        ]);
    }


    /**
     * @Route("/interventionsCuratives" , name="interventionsCuratives")
     **/
    public function getinterventionsCuratives(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $interventionCs= $repo->getRepository(Curative::class)->findAll();


        return $this->render('interventionCuratives.html.twig', ['controller_name' => 'DefaultController', 'interventionCs' => $interventionCs]);
    }


    /**
     * @Route("/interventioncurative_imprimer/{id}" , name="interventioncurative_imprimer")
     **/
    public function getinterventionsCurativesprint($id)
    {

        $repo = $this->getDoctrine()->getManager();
        $interventioncurative= $repo->getRepository(Curative::class)->find($id);
        $ppi=$repo->getRepository(PiecesPourIntervention::class)->findAll();
        $ppi=$interventioncurative->getPiecePourIntervention();



        $piece=$repo->getRepository(PieceRechange::class)->findAll();
        $technicien=$interventioncurative->getdemandeIntervention()->getTechniciens();
        return $this->render('interventionCurative.html.twig', [ 'ppi'=>$ppi,'interventioncurative' => $interventioncurative,'technicien'=>$technicien,'piece'=>$piece]);
    }


    //  page erreur

    /**
     * @Route("/erreur400", name="erreur400")
     */
    public function error()
    {
        return $this->render('erreur400.html.twig', []);
    }


    //  page erreursuppression

    /**
     * @Route("/erreursuppression", name="erreursuppression")
     */
    public function erreursuppression()
    {
        return $this->render('erreursuppression.html.twig', []);
    }
    //calss fiche demontage
    /**
     * @Route("/ficheDemontage_ajouter_modifier/{id}", defaults={"id" = null}, name="ficheDemontage_ajouter_modifier")
     */
    public function formdemontage(  Request $request, EntityManagerInterface $manager,  FicheDemontage $ficheDemontage = null)
    {

        $new = false;
        if (!$ficheDemontage) {
            $ficheDemontage = new FicheDemontage();
            $new=false;

        }

        //creation du formulaire dans le controller

        $form = $this->createForm(FicheDemontageType::class,$ficheDemontage);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            TRY {
                $ficheDemontage->setDate(new \DateTime());
                $manager->persist($ficheDemontage);
            }
            catch (\Doctrine\ORM\EntityNotFoundException $ex)
            { $this->addFlash('error', 'un erreur se produit   !');
            }

            $pieces = key_exists('pieces',$form->getExtraData()) ? $form->getExtraData()['pieces'] : [];

            foreach ($pieces as $pieceQuantity){
                $pr = $manager->getRepository(PieceRechange::class)->find($pieceQuantity['idPiece']);
                $entree = new Entree();
                $entree->setDate((new \DateTime()));
                $entree->setDemontage($ficheDemontage);
                $entree->setPieceRechange($pr);
                $entree->setQuantite($pieceQuantity['quantity']);
                $entree->setSource('defaillence');

                $pr->setQuantite($pr->getQuantite() + (float)$pieceQuantity['quantity']);

                $manager->persist($pr);
                $manager->persist($entree);
            }

            $manager->persist($ficheDemontage);
            $manager->flush();

            $machine=$ficheDemontage->getIntervention()->getDemandeIntervention()->getMachine();
            $machine->setEtat('démontée');
            $manager->persist($machine);

            if($new==true){
                $this->addFlash('success', 'fiche de démontage Bien Ajouter  !');
            }
            else{
                $this->addFlash('success', 'fiche de démontage Bien Modifier  !');
            }

            return $this->redirectToRoute('ficheDemontage');}


        return $this->render('ajouterFD.html.twig', [
            'pieces' => $manager->getRepository(PieceRechange::class)->findAll(),
            'formFD' => $form->createView(),
            'editMode' => $ficheDemontage->getId() !== null
        ]);
    }


    /**
     * @Route("/ficheDemontage" , name="ficheDemontage")
     **/
    public function getallfiche(Request $request)
    {
        $repo = $this->getDoctrine()->getManager();


        $fiches= $repo->getRepository(FicheDemontage::class)->findAll();

        $entrees= $repo->getRepository(Entree::class)->findAll();


        return $this->render('fiches.html.twig', ['controller_name' => 'DefaultController', 'fiches' => $fiches,
            'entree'=> $entrees]);
    }
    /**
    * @Route("/fd_imprimer/{id}" , name="fd_imprimer")
    **/
    public function getfichedemontageprint($id)
    {

        $repo = $this->getDoctrine()->getManager();

        $fd = $repo->getRepository(FicheDemontage::class)->find($id);
        $interventioncurative = $fd->getIntervention();
        $ppi= $fd->getEntrees();

        return $this->render('imprimerficheDemontage.html.twig', [
            'interventioncurative'=> $interventioncurative,
            'ppi'=>$ppi,
            'fd'=>$fd
        ]);
    }

     //calss bon de sortie imprimer
    /**
    * @Route("/mag_bondesortie" , name="bonsortie")
    **/
        public function bns ()
    {
        $repo = $this->getDoctrine()->getManager();
        $interventionpreventive= $repo->getRepository(Preventive::class)->findAll();
        $interventioncurative= $repo->getRepository(Curative::class)->findAll();


        return $this->render('bonsSortie.html.twig', ['controller_name' => 'DefaultController', 'interventionpreventive' => $interventionpreventive,'interventioncurative'=>$interventioncurative]);
    }
    /**
     * @Route("/mag/bondesortie_imprimer/{id}" , name="bs_imprimer")
     **/
    public function bnprint ($id)
    {
        $repo = $this->getDoctrine()->getManager();
        $interventionpreventive= $repo->getRepository(Preventive::class)->find($id);
        $ppi=$interventionpreventive->getPiecePourinterventionPrevtives();
        $technicien=$interventionpreventive->getTechnicien();
        return $this->render('bonSortie.html.twig', ['ppi'=>$ppi,'controller_name' => 'DefaultController', 'interventionpreventive' => $interventionpreventive,'technicien'=>$technicien]);
    }
    /**
     * @Route("/mag/bondesortie_imprimer/{id}" , name="bsc_imprimer")
     **/
    public function bsprint ($id)
    {
        $repo = $this->getDoctrine()->getManager();
        $interventioncurative= $repo->getRepository(Curative::class)->find($id);
        $ppi=$interventioncurative->getPiecePourintervention();
        //$technicien=$interventionpreventive->getTechnicien();
        return $this->render('bonSortiec.html.twig', ['ppi'=>$ppi,'controller_name' => 'DefaultController', 'interventioncurative '=> $interventioncurative]);
    }
}

    

