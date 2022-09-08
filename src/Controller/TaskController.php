<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/create-project')]
    public function createProject(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $project = new Project();
        $project->setTitle('Titre du projet');
        $project->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
        incididunt ut labore et dolore magna aliqua');

        $entityManager->persist($project);
        $entityManager->flush();

        return new Response(sprintf('Projet %s créé', $project->getTitle()));
    }

    #[Route('/create-task')]
    public function createTask(ManagerRegistry $doctrine): Response
    {
        $entityManger  = $doctrine->getManager();

        $task = new Task();
        $task->setTitle('Titre de la tâche');
        $task->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
        incididunt ut labore et dolore magna aliqua');

        $project = new Project();
        $project->setTitle('Titre du projet #2');
        $project->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
        incididunt ut labore et dolore magna aliqua');

        $task->setProject($project);

        $entityManger->persist($task);
        $entityManger->flush();

        return new Response(sprintf('Tâche %s créée', $task->getTitle()));
    }
}