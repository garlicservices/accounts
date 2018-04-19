<?php

namespace App\Controller;

use Garlic\User\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swagger\Annotations as SWG;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    use ControllerTrait;

    /**
     * Get user (admin) data.
     *
     * @Route("/admin/user", name="get_admin_user")
     *
     * @Method({"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="User data"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Access denied"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Server error"
     * )
     *
     * @return JsonResponse|Response
     */
    public function user()
    {
        return new JsonResponse(
            [
                'data' => $this->get('jms_serializer')
                    ->toArray($this->getUser(false)),
            ],
            JsonResponse::HTTP_OK
        );
    }
}
