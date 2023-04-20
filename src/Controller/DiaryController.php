<?php

namespace App\Controller;

use App\Entity\Diary;
use App\Form\DiaryType;
use App\Repository\DiaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/diary')]
class DiaryController extends AbstractController
{
    #[Route('/list', name: 'app_diary_index', methods: ['GET'])]
    public function index(DiaryRepository $diaryRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $diaryRepository->findAll();
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        $pagination->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'size' => 'large', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('diary/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/new', name: 'app_diary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DiaryRepository $diaryRepository): Response
    {
        $diary = new Diary();
        $form = $this->createForm(DiaryType::class, $diary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diaryRepository->save($diary, true);

            return $this->redirectToRoute('app_diary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diary/new.html.twig', [
            'diary' => $diary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diary_show', methods: ['GET'])]
    public function show(Diary $diary): Response
    {
        return $this->render('diary/show.html.twig', [
            'diary' => $diary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Diary $diary, DiaryRepository $diaryRepository): Response
    {
        $form = $this->createForm(DiaryType::class, $diary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diaryRepository->save($diary, true);

            return $this->redirectToRoute('app_diary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diary/edit.html.twig', [
            'diary' => $diary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diary_delete', methods: ['POST'])]
    public function delete(Request $request, Diary $diary, DiaryRepository $diaryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diary->getId(), $request->request->get('_token'))) {
            $diaryRepository->remove($diary, true);
        }

        return $this->redirectToRoute('app_diary_index', [], Response::HTTP_SEE_OTHER);
    }
}
