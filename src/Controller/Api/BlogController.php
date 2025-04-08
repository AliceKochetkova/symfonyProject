<?php

namespace App\Controller\Api;

use App\Dto\BlogDto;
use App\Entity\Blog;
use App\Entity\User;
use App\Filter\BlogFilter;
use App\Repository\BlogRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class BlogController extends AbstractController
{
    #[Route('/api/blog', name: 'api-blog', methods: ['GET'], format: 'json')]
    public function index(BlogRepository $blogRepository): Response
    {
        $blogs = $blogRepository->getBlogs();

        return $this->json($blogs, context: [
            AbstractNormalizer::GROUPS => ['select_box']
        ]);
    }

    #[Route('/api/blog', name: 'api_blog_add', methods: ['POST'], format: 'json')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $blogData = $request->toArray();

        $user = $em->getRepository(User::class)->findOneBy(['email' => $blogData['user_email'] ?? '']);
        if ($user === null) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $blog = new Blog($user);
        $blog
            ->setCreatedAt(new DateTime())
            ->setTitle($blogData['title'] ?? '')
            ->setDescription($blogData['description'] ?? '')
            ->setText($blogData['text'] ?? '');

        $em->persist($blog);
        $em->flush();

        return $this->json($blog, Response::HTTP_CREATED);
    }

    #[Route('/api/blog/dto', name: 'api_blog_add_dto', methods: ['POST'], format: 'json')]
    public function addDto(#[MapRequestPayload] BlogDto $blogDto, EntityManagerInterface $em): Response
    {
        $blog = Blog::createFromDto($this->getUser(), $blogDto);

        $em->persist($blog);
        $em->flush();

        return $this->json($blog);
    }

    #[Route('/api/blog/{blogId}', name: 'api_blog_update', methods: ['PUT'], format: 'json',)]
    public function update(Request $request, int $blogId, EntityManagerInterface $em): Response
    {
        $blogData = $request->toArray();

        $blog = $em->getRepository(Blog::class)->findOneBy(['id' => $blogId]);
        if ($blog === null) {
            return new JsonResponse(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }

        $blog
            ->setTitle($blogData['title'] ?? '')
            ->setDescription($blogData['description'] ?? '')
            ->setText($blogData['text'] ?? '');

        $em->persist($blog);
        $em->flush();

        return $this->json($blog, Response::HTTP_CREATED);
    }

    #[Route('/api/blog/dto/{blogId}', name: 'api_blog_update_dto', methods: ['PUT'], format: 'json')]
    public function updateFromDto(#[MapRequestPayload] BlogDto $blogDto, int $blogId, EntityManagerInterface $em): Response
    {
        $blog = $em->getRepository(Blog::class)->findOneBy(['id' => $blogId]);
        if ($blog === null) {
            return new JsonResponse(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }

        $blog
            ->setTitle($blogDto->title ?? '')
            ->setDescription($blogDto->description ?? '')
            ->setText($blogDto->text ?? '');

        $em->persist($blog);
        $em->flush();

        return $this->json($blog);
    }

    #[Route('/api/blog/filter', name: 'api_blog_filter', methods: ['GET'], format: 'json')]
    public function filter(#[MapQueryString] BlogFilter $blogFilter, BlogRepository $blogRepository): Response
    {
        $blogs = $blogRepository->findByBlogFilter($blogFilter);

        return $this->json($blogs->getQuery()->getResult());
    }

    #[Route('/api/blog/{blog}', name: 'api_blog_delete', methods: ['DELETE'], format: 'json')]
    public function delete(Blog $blog, EntityManagerInterface $em): Response
    {
        $em->remove($blog);
        $em->flush();

        return $this->json([]);
    }
}