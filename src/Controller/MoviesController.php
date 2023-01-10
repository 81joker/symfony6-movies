<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MovieFormType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $movieRepository;
    private $em;
    public function __construct(MoviesRepository $movieRepository, EntityManagerInterface $em)
    {
        // public function __construct(EntityManagerInterface $em) {
        $this->movieRepository = $movieRepository;
        $this->em = $em;

    }

    #[Route('/', name:'movies')]
// #[Route('/movies/{name}', name:'app_movies', methods:['GET', 'HEAD'], defaults:['name' => 'Nehad'])]
function index(): Response
    {
    // function index(MoviesRepository $moviesRepository): Response
    // $findAll() - SELECT * FROM  movies
    // $find(2) - SELECT * FROM  movies WHERE id = 2
    // $findBy([] , 'id' => 'DESC') - SELECT * FROM  movies ORDER  BY id DESC
    // findOneBy() - SELECT * FROM movie WHERE id = 5 AND title = ''
    // count() - SELECT COUNT() from movie WHERE id = 1
    // $repository = $this->em->getRepository(Movie::class);
    // $movies = $repository->getClassName();
    // $movies = $repository->count(['id' => 5]);
    // $movies = $movieRepository->findAll();
    // $movies = $repository->findOneBy(['id' => '2', 'title' => 'This is Title Fixtures Doctrine test'], ['id' => 'DESC']);
    // $movies = $repository->findBy([], ['id' => 'DESC']);

    // $repository = $this->em->getRepository(Movies::class);
    // $movies = $repository->findBy(['id' => 7, 'title' => 'This is Title movie'], ['id' => 'DESC']);
    // $movies = $repository->findAll();
    // $movies = $repository->count(['id' => 7]);
    // $movies = $repository->getClassName();

    // dd($movies);
    return $this->render('movies/index.html.twig', [
        'movies' => $this->movieRepository->findAll(),
    ]);
}

#[Route('/movies/edit/{id}', name:'edit_movies')]
function edit($id, Request $request): Response
    {
    // $movie = $this->movieRepository->find($id);
    // $form = $this->createForm(MovieFormType::class, $movie);
    // $form->handleRequest($request);

    // $imagePath = $form->get('imagePath')->getData();
    // if ($form->isSubmitted() && $form->isValid()) {
    //     if ($imagePath) {
    //         # Handle image upload
    //         if ($movie->getImagePath() !== null) {
    //             if (file_exists($this->getParameter('kernel.project.dir') . $movie->getImagePath())) {
    //                 $this->getParameter('parameterName');
    //             }
    //         }
    //     } else {
    //         $movie->setTitle($form->get('title')->getData());
    //         $movie->setReleaseYear($form->get('releaseYear')->getData());
    //         $movie->setDescription($form->get('description')->getData());

    //         $this->em->flush();
    //         return $this->redirectToRoute('movies');
    //     }
    // }

    // if ($form->isSubmitted() && $form->isValid()) {

    // }

    // return $this->render('movies/edit.html.twig', [
    //     'movie' => $movie,
    //     'form' => $form->createView(),
    // ]);
    // $this->checkLoggedInUser($id);
    $movie = $this->movieRepository->find($id);

    $form = $this->createForm(MovieFormType::class, $movie);

    $form->handleRequest($request);
    $imagePath = $form->get('imagePath')->getData();

    if ($form->isSubmitted() && $form->isValid()) {
        if ($imagePath) {
            if ($movie->getImagePath() !== null) {
                if (file_exists(
                    $this->getParameter('kernel.project_dir') . $movie->getImagePath()
                )) {
                    $this->GetParameter('kernel.project_dir') . $movie->getImagePath();
                }
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $movie->setImagePath('/uploads/' . $newFileName);
                $this->em->flush();

                return $this->redirectToRoute('movies');
            }
        } else {
            $movie->setTitle($form->get('title')->getData());
            $movie->setReleaseYear($form->get('releaseYear')->getData());
            $movie->setDescription($form->get('description')->getData());

            $this->em->flush();
            return $this->redirectToRoute('movies');
        }
    }

    return $this->render('movies/edit.html.twig', [
        'movie' => $movie,
        'form' => $form->createView(),
    ]);

}

#[Route('/movies/create', name:'create_movies')]
function create(Request $request): Response
    {
    $movie = new Movies();
    $form = $this->createForm(MovieFormType::class, $movie);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $newMovie = $form->getData();

        $imagePath = $form->get('imagePath')->getData();
        if ($imagePath) {
            $newFileName = uniqid() . '.' . $imagePath->guessExtension();

            try {
                //code...
                $imagePath->move($this->getParameter('kernel.project_dir') . '/public/uploads', $newFileName);

            } catch (FileException $e) {
                return new Response($e->getMessage());
            }

            $newMovie->setImagePath('uploads/' . $newFileName);
        }

        $this->em->persist($newMovie);
        $this->em->flush();
        return $this->redirectToRoute('movies');
    }
    return $this->render('movies/create.html.twig', [
        'form' => $form->createView(),
    ]);

}

#[Route('/movies/{id}', name:'show_movies', methods:['GET'])]
// #[Route('/movies/{name}', name:'app_movies', methods:['GET', 'HEAD'], defaults:['name' => 'Nehad'])]
function show($id): Response
    {

    // $movie = $this->movieRepository->find($id);
    return $this->render('movies/show.html.twig', [
        'movie' => $this->movieRepository->find($id),
    ]);
}

#[Route('/movies/delete/{id}', methods:['GET', 'DELETE'], name:'delete_movie')]
function delete($id): Response
    {
    // $this->checkLoggedInUser($id);
    $movie = $this->movieRepository->find($id);
    $this->em->remove($movie);
    $this->em->flush();

    return $this->redirectToRoute('movies');
}

/**
 * oldMethod
 *
 * @Route("/old",name="Old")
 */
function oldMethod(): Response
    {
    return $this->json(['Halloo symfony']);
}

}
