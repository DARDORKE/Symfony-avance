<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    #[Route('/remove-employee/{id}')]
    public function removeEmployee(int $id, EmployeeRepository $employeeRepository, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $employee = $employeeRepository->find($id);

        if ($employee === null){
            return new Response("L'utilisateur n'existe pas");
        } else {
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return new Response('L\'employé à été supprimé');
    }
}