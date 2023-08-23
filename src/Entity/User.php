<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private $email = null;


   
    #[ORM\Column]
    private $roles = array();

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    public?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Library::class)]
    private Collection $lib;

    public function __construct()
    {
        $this->lib = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {  
        $roles = array($this->roles);

        // guarantee every user at least has ROLE_USER
        // $roles[] = array_push($roles,'ROLE_USER');
        $roles[] = 'ROLE_USER';
        // dd(array_unique($roles));
        // dd($roles);
        return $roles;
    }

    public function setRoles(string $role)
    {

         $this->roles = $role;
        //  dd($role);
        $roles = array($this->roles);
        //  dd($this->roles);

         return array($roles);
    }
    
    public function addRoles(string $roles)
    {
        $this->roles[] = $roles;
        dd($this->roles);
        return $this->roles;
    }

    public function becomeAdmin()
{   
    // dd(array($this->roles));
    $this->roles = '["ROLE_ADMIN"]';
    $roles = array($this->roles);
    // dd(array($this->roles));
    return array($roles);
}
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }
   
    
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Library>
     */
    public function getLib(): Collection
    {
        return $this->lib;
    }

    public function addLib(Library $lib): static
    {
        if (!$this->lib->contains($lib)) {
            $this->lib->add($lib);
            $lib->setUser($this);
        }

        return $this;
    }

    public function removeLib(Library $lib): static
    {
        if ($this->lib->removeElement($lib)) {
            // set the owning side to null (unless already changed)
            if ($lib->getUser() === $this) {
                $lib->setUser(null);
            }
        }

        return $this;
    }
}
