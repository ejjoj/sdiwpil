<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $second_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     */
    private $pesel_number;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_birth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place_of_birth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fathers_first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mothers_first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mothers_maiden_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marital_state;

    /**
     * @ORM\ManyToMany(targetEntity=Doctor::class, mappedBy="patients")
     */
    private $doctors;

    /**
     * @ORM\ManyToMany(targetEntity=Clinic::class, mappedBy="patients")
     */
    private $clinics;

    /**
     * @ORM\OneToOne(targetEntity=Visit::class, mappedBy="patient", cascade={"persist", "remove"})
     */
    private $visit;

    public function __construct()
    {
        $this->doctors = new ArrayCollection();
        $this->clinics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setSecondName(string $second_name): self
    {
        $this->second_name = $second_name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPeselNumber(): ?int
    {
        return $this->pesel_number;
    }

    public function setPeselNumber(int $pesel_number): self
    {
        $this->pesel_number = $pesel_number;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->place_of_birth;
    }

    public function setPlaceOfBirth(string $place_of_birth): self
    {
        $this->place_of_birth = $place_of_birth;

        return $this;
    }

    public function getFathersFirstName(): ?string
    {
        return $this->fathers_first_name;
    }

    public function setFathersFirstName(string $fathers_first_name): self
    {
        $this->fathers_first_name = $fathers_first_name;

        return $this;
    }

    public function getMothersFirstName(): ?string
    {
        return $this->mothers_first_name;
    }

    public function setMothersFirstName(string $mothers_first_name): self
    {
        $this->mothers_first_name = $mothers_first_name;

        return $this;
    }

    public function getMothersMaidenName(): ?string
    {
        return $this->mothers_maiden_name;
    }

    public function setMothersMaidenName(string $mothers_maiden_name): self
    {
        $this->mothers_maiden_name = $mothers_maiden_name;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getMaritalState(): ?string
    {
        return $this->marital_state;
    }

    public function setMaritalState(?string $marital_state): self
    {
        $this->marital_state = $marital_state;

        return $this;
    }

    /**
     * @return Collection|Doctor[]
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
            $doctor->addPatient($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->removeElement($doctor)) {
            $doctor->removePatient($this);
        }

        return $this;
    }

    /**
     * @return Collection|Clinic[]
     */
    public function getClinics(): Collection
    {
        return $this->clinics;
    }

    public function addClinic(Clinic $clinic): self
    {
        if (!$this->clinics->contains($clinic)) {
            $this->clinics[] = $clinic;
            $clinic->addPatient($this);
        }

        return $this;
    }

    public function removeClinic(Clinic $clinic): self
    {
        if ($this->clinics->removeElement($clinic)) {
            $clinic->removePatient($this);
        }

        return $this;
    }

    public function getVisit(): ?Visit
    {
        return $this->visit;
    }

    public function setVisit(Visit $visit): self
    {
        // set the owning side of the relation if necessary
        if ($visit->getPatient() !== $this) {
            $visit->setPatient($this);
        }

        $this->visit = $visit;

        return $this;
    }
}
