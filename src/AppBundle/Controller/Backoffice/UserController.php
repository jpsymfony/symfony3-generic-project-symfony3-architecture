<?php

namespace AppBundle\Controller\Backoffice;

use AppBundle\Entity\BackUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/back/users")
 */
class UserController extends Controller
{
     /**
     * Lists all users.
     *
     * @Route("/", name="user_list")
     * @Template("back/user/index.html.twig")
     */
    public function indexAction()
    {        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(BackUser::class)->findAll();

        return array(
            'users' => $entities,
        );
    }
    
     /**
     * Delete a user.
     *
     * @Route("/{id}/delete", name="user_delete")
     */
    public function deleteAction($id)
    {        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(BackUser::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        if (in_array('ROLE_SUPER_ADMIN' ,$entity->getRoles())){
            $message = 'You cannot delete the super admin.';
            $this->get('session')->getFlashBag()->add('error', $message);
        }
        else {
            $em->remove($entity);
            $em->flush();
            $message = 'You deleted the user named "' . $entity->getUsername() . '" with success.';
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('user_list'));
    }
}
