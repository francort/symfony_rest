<?php

namespace AppBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\NoteEntity;


class NoteManager
{

    /** @var Doctrine\ORM\EntityManager */
    protected $em;

    /** @var array notes */
    protected $data = array();

    /**
     * @var \Symfony\Component\Security\Core\Util\SecureRandomInterface
     */
    protected $randomGenerator;

    public function __construct(SecureRandomInterface $randomGenerator, EntityManager $em)
    {
        $this->em = $em;
        $this->randomGenerator = $randomGenerator;
    }

    private function flush()
    {
        file_put_contents($this->cacheDir . '/sf_note_data', serialize($this->data));
    }

    public function fetch($start = 0, $limit = 5, $order = "DESC")
    {
        $page = 1;
        $itemsPerPage = 10;
        $repository = $this->em->getRepository('AppBundle:NoteEntity');

        $notes = $repository->findBy(
            array(),
            array('id' => $order),
            $itemsPerPage,
            ($page - 1) * $itemsPerPage
        );

        return $notes;
    }

    public function get($id)
    {
        $note = $this->em->getRepository('AppBundle:NoteEntity')->find($id);

        return $note;
    }

    public function set($note)
    {

        if (null === $note->getSecret()) {
            $note->setSecret(base64_encode($this->randomGenerator->nextBytes(64)));
        }

        $this->em->persist($note);
        $this->em->flush();
    }

    public function remove($id)
    {
        $note = $this->em->getRepository('AppBundle:NoteEntity')->find($id);
        if($note){
          $this->em->remove($note);
          $this->em->flush();

          return true;
        }

        return false;
    }
}
