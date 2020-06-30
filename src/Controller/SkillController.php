<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/skill", name="skill", options={"sitemap"=true} )
     */
    public function index(): Response
    {
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }

    /**
     * @Route("/skill/{slug}", name="skill_slug")
     */
    public function bySlug(Skill $skill, ProfileRepository $profileRepository): Response
    {
        $profiles = $profileRepository->findBySkill($skill);

        return $this->render('skill/index.html.twig', [
            'skill' => $skill,
            'profiles' => $profiles,
        ]);
    }
}
