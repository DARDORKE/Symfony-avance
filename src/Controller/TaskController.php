<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route("/assign-task/{task_id}/{employee_id}")]
    public function assignTaskToEmployee(int $task_id, int $employee_id, ManagerRegistry $doctrine, TaskRepository $taskRepository, EmployeeRepository $employeeRepository): Response
    {
        $entityManager = $doctrine->getManager();

        $task = $taskRepository->find($task_id);
        $employee = $employeeRepository->find($employee_id);

        $task->setEmployee($employee);

        $entityManager->flush();

        return new Response(sprintf('La tâche : %s a été assignée à %s', $task->getTitle(), $employee->getUsername()));
    }
}