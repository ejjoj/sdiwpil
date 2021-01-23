<?php

namespace App\Controller;

use App\Classes\Tools;
use App\Classes\Validate;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController {
    /**
     * @Route("/", name="patient", methods={"GET"})
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function index(PatientRepository $patientRepository): Response {
        $patients = $patientRepository->getAll();
        if ($patients)
            return $this->json($patients);

        return $this->json([], 404);
    }

    /**
     * @Route("/new", name="patient_new", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response {
        $patient = new Patient();
        $content = json_decode($request->getContent());
        $errors = [];

        if (isset($content->firstname)
            && !empty($content->firstname))
            $patient->setFirstname(htmlspecialchars($content->firstname));
        else
            $errors['firstname_error'] = 'Patient\'s firstname cannot be null.';

        if (isset($content->second_name)
            && !empty($content->second_name))
            $patient->setSecondName(htmlspecialchars($content->second_name));

        if (isset($content->lastname)
            && !empty($content->lastname))
            $patient->setLastname(htmlspecialchars($content->lastname));
        else
            $errors['lastname_error'] = 'Patient\'s lastname cannot be null';

        if (isset($content->pesel_number)
            && !empty($content->pesel_number))
                if (Validate::isPesel($content->pesel_number))
                    $patient->setPeselNumber((int)$content->pesel_number);
                else
                    $errors['pesel_number_error'] = 'Patient\'s pesel number is invalid';
        else
            $errors['pesel_number_error'] = 'Patient\'s pesel number cannot be null';

        if (isset($content->date_of_birth)
            && !empty($content->date_of_birth)) {
            if (Validate::isDate($content->date_of_birth)) {
                $dt = new DateTime($content->date_of_birth);
                $patient->setDateOfBirth($dt);
            } else
                $errors['date_of_birth_error'] = 'Patient\'s date of birth is invalid';
        } else
            $errors['date_of_birth_error'] = 'Patient\'s date of birth cannot be null';

        if (isset($content->place_of_birth)
            && !empty($content->place_of_birth))
            $patient->setPlaceOfBirth($content->place_of_birth);
        else
            $errors['place_of_birth_error'] = 'Patient\'s place of birth cannot be null.';

        if (isset($content->fathers_first_name)
            && !empty($content->fathers_first_name))
            $patient->setFathersFirstName(htmlspecialchars($content->fathers_first_name));
        else
            $errors['fathers_first_name_error'] = 'Patient\'s father\'s firstname cannot be null';

        if (isset($content->mothers_first_name)
            && !empty($content->mothers_first_name))
            $patient->setMothersFirstName(htmlspecialchars($content->mothers_first_name));
        else
            $errors['mothers_first_name_error'] = 'Patient\'s mother\'s firstname cannot be null';

        if (isset($content->mothers_maiden_name)
            && !empty($content->mothers_maiden_name))
            $patient->setMothersMaidenName(htmlspecialchars($content->mothers_maiden_name));
        else
            $errors['mothers_maiden_name_error'] = 'Patient\'s mother\'s maiden name cannot be null';

        if (isset($content->profession)
            && !empty($content->profession))
            $patient->setProfession($content->profession);

        if (isset($content->education)
            && !empty($content->education))
            $patient->setEducation($content->education);

        if (isset($content->marital_state)
            && !empty($content->marital_state))
            $patient->setMaritalState($content->marital_state);

        if (count($errors))
            return $this->json(['errors' => $errors], 400);
        else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->json(['msg' => 'Successfully added patient!', 'patient_id' => $patient->getId()],  201);
        }
    }

    /**
     * @Route("/edit/{id}", name="patient_edit", methods={"PUT"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, int $id = 0): Response {
        $content = json_decode($request->getContent());
        $errors = [];

        if ($id)
            $patient = $this->getDoctrine()->getRepository(Patient::class)->getByID($id);
        else
            return $this->json([], 404);

        if (!$patient)
            return $this->json([], 404);

        if (isset($content->firstname)
            && !empty($content->firstname))
            $patient->setFirstname(htmlspecialchars($content->firstname));

        if (isset($content->second_name)
            && !empty($content->second_name))
            $patient->setSecondName(htmlspecialchars($content->second_name));

        if (isset($content->lastname)
            && !empty($content->lastname))
            $patient->setLastname(htmlspecialchars($content->lastname));

        if (isset($content->pesel_number)
            && !empty($content->pesel_number)) {
            if (Validate::isPesel($content->pesel_number))
                $patient->setPeselNumber($content->pesel_number);
            else
                $errors['pesel_number_error'] = 'Patient\'s pesel number is invalid';
        }

        if (isset($content->date_of_birth)
            && !empty($content->date_of_birth)) {
            if (Validate::isDate($content->date_of_birth))
                $patient->setDateOfBirth($content->date_of_birth);
            else
                $errors['date_of_birth_error'] = 'Patient\'s date of birth is invalid';
        }

        if (isset($content->fathers_first_name)
            && !empty($content->fathers_first_name))
            $patient->setFathersFirstName(htmlspecialchars($content->fathers_first_name));

        if (isset($content->mothers_first_name)
            && !empty($content->mothers_first_name))
            $patient->setMothersFirstName(htmlspecialchars($content->mothers_first_name));

        if (isset($content->mothers_maiden_name)
            && !empty($content->mothers_maiden_name))
            $patient->setMothersMaidenName(htmlspecialchars($content->mothers_maiden_name));

        if (isset($content->profession)
            && !empty($content->profession))
            $patient->setProfession(htmlspecialchars($content->profession));

        if (isset($content->education)
            && !empty($content->education))
            $patient->setEducation(htmlspecialchars($content->education));

        if (isset($content->marital_state)
            && !empty($content->marital_state))
            $patient->setMaritalState(htmlspecialchars($content->marital_state));

        if (empty($errors)) {
            $this->getDoctrine()->getManager()->flush();
            return $this->json(['msg' => 'Successfully updated patient', 'id_patient' => $patient->getId()], 200);
        }

        return $this->json(['errors' => $errors], 400);
    }

    /**
     * @Route("/delete/{id}", name="patient_delete", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, int $id = 0) : Response {
        if ($id)
            $patient = $this->getDoctrine()->getRepository(Patient::class)->getByID($id);
        else
            return $this->json([], 404);

        if (!$patient)
            return $this->json([], 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($patient);
        $em->flush();
        return $this->json([], 204);
    }
}
