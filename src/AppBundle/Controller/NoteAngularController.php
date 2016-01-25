<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use AppBundle\Form\NoteType;
use AppBundle\Model\Note;

/**
 * Character controller.
 *
 * @Route("/nota")
 */
class NoteAngularController  extends Controller
{
    /**
     * Lists all Character entities.
     *
     * @Route("/pancho", name="noteangular_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $form = $this->createForm(new NoteType());
        return $this->render('@AppBundle/Resources/views/NoteAngular/index.html.twig', array(
          'form' => $form->createView(),
        ));
    }
}
