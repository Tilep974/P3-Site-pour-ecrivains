<?php
namespace Livre\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Livre\Form\Type\CommentType;

class AdminCommentsController {
    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'The comment was successfully updated.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $comment = $app['dao.comment']->find($id);

        $errors = $app['validator']->validate($comment);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $app['session']->getFlashBag()->add('error', $error->getMessage());
            }
        }
        else {
            $app['dao.comment']->delete($id);
            $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé avec succès.');
        }

        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}

