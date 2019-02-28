<?php

namespace AppBundle\Controller;


use AppBundle\Entity\File;
use AppBundle\Form\NewFileType;
use AppBundle\Manager\ProcessManager;
use AppBundle\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var PersonRepository $personRepo */
        $personRepo = $this->get(PersonRepository::class);

        $people = $personRepo->findAll();

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($people as $person){

            $data[] = $person->getCount();
            $labels[] = $person->getCountry();
            $colors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

       return $this->render('app/index.html.twig', ['people' => $data, 'labels' => $labels, 'colors' => $colors]);
    }

    /**
     * @Route("/file/new", name="new_file")
     */
    public function newFileAction(Request $request)
    {
        /** @var File $file */
        $file = new File();

        $form = $this->createForm(NewFileType::class, $file, [
        'action' => $this->generateUrl('compute_data')
            ]);

        return $this->render('app/new_file.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/compute/data", name="compute_data")
     */
    public function computeDataAction(Request $request)
    {
        $file = $request->files->get('new_file');

        if(!empty($file['file'])){

            $pathName = $file['file']->getPathName();

            $fileType = $file['file']->getMimeType();

            if($fileType !== 'text/plain' && $fileType !== 'text/csv'){

                $this->addFlash(
                    'warning',
                    'Please put .csv file'
                );

                return $this->redirectToRoute('new_file');
            }
        }

        if(!empty($pathName)){

            $handle = fopen($pathName, "r");
        }

        if(!empty($handle)){

            $processManager = $this->get(ProcessManager::class);
            $processManager->processCSV($handle);
        }

        return $this->redirectToRoute('homepage');
    }

}
