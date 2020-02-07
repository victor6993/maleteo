<?php


namespace App\Controller;


use App\Entity\Series;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    /**
     * @Route("/muestraSeries", name="muestraSeries")
     */
    public function getSeries(EntityManagerInterface $em){
        $repo = $em->getRepository(Series::class);

        $series = $repo->findAll();

        return $this->render('showSeries.html.twig',
            ['series' => $series]);
    }

    /**
     * @Route("/serie", name="createSerie")
     */
    public function getPelicula(Request $request, EntityManagerInterface $em){

        $titulo = $request->get('titulo');
        $descripcion = $request->get('descripcion', 'Sin descripcion');
        $categoria = $request->get('categoria');

        if ($titulo){
            $serie = new Series();
            $serie->setTitulo($titulo);
            $serie->setDescripcion($descripcion);
            $serie->setCategoria($categoria);

            $em->persist($serie);
            $em->flush();


            /*if (!file_exists('series.json')){
                $series = [];
            } else {
                $seriesJson = file_get_contents('series.json');
                $series = json_decode($seriesJson);
            }

            $series[] = [
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'categoria' => $categoria
            ];

            file_put_contents('series.json', json_encode($series));
            */
        }

        return $this->render("createSerie.html.twig",
            [
                'title' => $titulo,
                'description'=>$descripcion,
                'category'=>$categoria
            ]);
    }
}