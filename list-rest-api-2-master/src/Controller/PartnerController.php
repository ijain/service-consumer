<?php
declare(strict_types=1);

namespace ListRestAPI\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use ListRestAPI\Entity\Partner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PartnerController
 * @package ListRestAPI\Controller
 */
class PartnerController extends FOSRestController
{
    /**
     * Partners List
     *
     * @FOSRest\Get("/partners")
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     *
     * @return Response
     * @throws \Exception
     */
    public function searchList(Request $request, EntityManagerInterface $entityManager): Response
    {
        $status = $request->get('status');
        $limit = $request->get('limit');

        if (!($status && $limit)) {
            throw new \Exception(
                json_encode([
                    'error' => 'Status and Limit are required.',
                    'code' => Response::HTTP_BAD_REQUEST
                ])
            );
        }

        try {
            $partners = $entityManager
                ->getRepository(Partner::class)
                ->getSearchResults($status, $limit);

            $context = new Context();

            $view = $this->view(['data' => $partners], Response::HTTP_OK);
            $view->setContext($context);

            return $this->handleView($view);
        } catch (\Exception $e) {
            return new Response(json_encode([
                'error' => $e->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST
            ]));
        }
    }

    /**
     * Create Partner
     *
     * @FOSRest\Post("/partners/create")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partnerName = $request->get('partner');
        $iconName = $request->get('icon');

        if (!($partnerName && $iconName)) {
            throw new \Exception(
                json_encode([
                    'error' => 'Partner Name and Icon Name are required.',
                    'code' => Response::HTTP_BAD_REQUEST
                ])
            );
        }

        try {
            $partner = new Partner();
            $partner->setName($partnerName);
            $partner->setIcon($iconName);

            $entityManager->persist($partner);
            $entityManager->flush();

            $context = new Context();
            $view = $this->view(['data' => [$partner->getId(), $partner->getName()], 'code' => Response::HTTP_CREATED, 'message' => 'Partner successfully created.']);
            $view->setContext($context);

            return $this->handleView($view);
        } catch(\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Partner cannot be created.'
            ]);
        }
    }
}
