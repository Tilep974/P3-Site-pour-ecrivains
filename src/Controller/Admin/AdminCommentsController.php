<?php
namespace Livre\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Livre\Form\Type\CommentType;

class AdminCommentsController {
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

