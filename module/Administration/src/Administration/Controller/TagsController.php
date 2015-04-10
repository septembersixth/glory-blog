<?php

namespace Administration\Controller;

use Application\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;

class TagsController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page') ? $this->params()->fromRoute('page') : 1;

        $rep = $this->getEntityManager()->getRepository('Application\Entity\Tag');
        $tags = $rep->findByDeleted(false);
        $paginator = new Paginator(new Collection(new ArrayCollection($tags)));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(15);

        return [
            'entities'              => $paginator,
            'flashMessages'         => $this->flashMessenger()->getMessages(),
        ];
    }

    public function addAction()
    {
        $form = $this->getForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $tag = new Tag;
            $form->setData($request->getPost());
            $form->bind($tag);

            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($tag);
                $em->flush();

                $this->flashMessenger()->addMessage('Your Tag was added');
                $this->redirect()->toRoute('administration/tags');
            }
        }

        return compact('form');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('administration/tags');
        }

        if (! $tag = $this->getEntityManager()->getRepository('Application\Entity\Tag')->findOneById($id)) {
            $this->flashMessenger()->addMessage(sprintf('The tag with the id %d doesn\'t exist', $id));
            return $this->redirect()->toRoute('administration/tags');
        }


        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $em = $this->getEntityManager();
                $tag = $em->getRepository('Application\Entity\Tag')->findOneById($id);
                $tag->setDeleted(true);

                $em->flush();

                $this->flashMessenger()->addMessage(sprintf('Your tag "%s" was deleted', $tag->getName()));
                return $this->redirect()->toRoute('administration/tags');

            }

            $this->redirect()->toRoute('administration/tags');
        }

        return [
            'id'        => $id,
            'entity'    => $tag,
        ];

    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function getForm()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Administration\Form\TagForm');
        return $form;
    }
}