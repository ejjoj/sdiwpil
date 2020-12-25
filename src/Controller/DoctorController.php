<?php

namespace App\Controller;

use App\Classes\Tools;
use App\Entity\Doctor;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/doctor")
 */
class DoctorController extends AbstractController {
    /**
     * @Route("/", name="doctor_index", methods={"GET"})
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(DoctorRepository $doctorRepository): Response {
        $doctors = $doctorRepository->getAll();
        if ($doctors)
            return $this->json(['doctors' => $doctors]);
        return $this->json([], 404);
    }

    /**
     * @Route("/new", name="doctor_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response {
        $doctor = new Doctor();
        $content = json_decode($request->getContent());
        $errors = [];

        if (isset($content->firstname)
            && !empty($content->firstname))
            $doctor->setFirstname(htmlspecialchars($content->firstname));
        else
            $errors['firstname_error'] = 'Doctor\'s firstname cannot be null';

        if (isset($content->second_name)
            && !empty($content->second_name))
            $doctor->setSecondName(htmlspecialchars($content->second_name));

        if (isset($content->lastname)
            && !empty($content->lastname))
            $doctor->setLastname(htmlspecialchars($content->lastname));
        else
            $errors['lastname_error'] = 'Doctor\'s lastname cannot be null';

        if (isset($content->major_discipline)
            && !empty($content->major_discipline))
            $doctor->setMajorDiscipline(htmlspecialchars($content->major_discipline));
        else
            $errors['major_discipline_error'] = 'Doctor\'s major discipline cannot be null';

        if (!empty($errors))
            return $this->json(['errors' => $errors], 403);

        $em = $this->getDoctrine()->getManager();
        $em->persist($doctor);
        $em->flush();

        return $this->json(['msg' => 'Successfully added a doctor', 'id_doctor' => $doctor->getId()], 201);
    }
}
