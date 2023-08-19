<?php

namespace AppPaymentClient\Controller;

use AppPaymentClient\Entity\StripePlanInterface;
use AppPaymentClient\Service\ServiceNameProvider;
use AppPaymentClient\Service\ServiceUrlsProvider;
use AppPaymentClient\Service\Stripe\StripeCheckoutRequestDTOBuilder;
use AppPaymentClient\Service\Stripe\StripeClient;
use AppPaymentClient\Service\Stripe\StripeCustomerPortalRequestDTOBuilder;
use AppPaymentClient\Service\Stripe\StripePlansProvider;
use AppPaymentClient\Service\Stripe\StripeRequestDTOBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;

/**
 * @Route("/payment-client/stripe")
 */
class StripeController extends AbstractController
{
    /**
     * @Route("/get-form", name="payment-client_stripe_form", methods={"POST"})
     * @param Request $request
     * @param ServiceNameProvider $serviceNameProvider
     * @param ServiceUrlsProvider $serviceUrlsProvider
     * @param UrlGeneratorInterface $urlGenerator
     * @return Response
     */
    public function getStripeForm(
        Request $request,
        ServiceNameProvider $serviceNameProvider,
        ServiceUrlsProvider $serviceUrlsProvider,
        UrlGeneratorInterface $urlGenerator
    ): Response
    {
        $orderId = $request->request->get('order_id');
        $orderIdUrl = $request->request->get('order_id_url');
        $plan = $request->request->getInt('plan');
        $test = $request->request->getInt('stripe_test');
        $successUrl = $request->request->get('success_url');
        $cancelUrl = $request->request->get('cancel_url');
        $formName = $request->request->get('form_name');
        if (
            !isset($successUrl, $cancelUrl)
            ||
            !in_array($plan, StripePlansProvider::getStripePlans(), true)
        ) {
            throw $this->createNotFoundException();
        }
        $webhookUrl = $urlGenerator
            ->generate($serviceUrlsProvider->getWebhookUrl(), [], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->render('@AppPaymentClient/stripe/stripe_form.html.twig', [
            'order_id' => $orderId,
            'plan' => $plan,
            'service_name' => $serviceNameProvider->getServiceName(),
            'test' => $test,
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'webhook_url' => $webhookUrl,
            'order_id_url' => $orderIdUrl,
            'form_name' => $formName,
        ]);
    }

    /**
     * @Route("/to-checkout", name="payment-client_stripe_checkout", methods={"POST"})
     * @param Request $request
     * @param StripeClient $stripeClient
     * @return Response
     */
    public function redirectToCheckout(
        Request $request,
        StripeClient $stripeClient
    ): Response
    {
        $stripeRequestDTO = StripeRequestDTOBuilder::buildFromRequest($request);
        if (!$stripeRequestDTO) {
            return $this->redirect($request->request->get('cancel_url') ?? '/');
        }
        $url = $stripeClient->getCheckoutUrl($stripeRequestDTO);
        if (!$url) {
            return $this->redirect($request->request->get('cancel_url') ?? '/');
        }
        return $this->redirect($url);
    }

    /**
     * @Route("/to-payment", name="payment-client_stripe_payment", methods={"POST"})
     * @param Request $request
     * @param StripeClient $stripeClient
     * @param StripeCheckoutRequestDTOBuilder $stripeCheckoutRequestDTOBuilder
     * @return Response
     */
    public function redirectToPayment(
        Request $request,
        StripeClient $stripeClient,
        StripeCheckoutRequestDTOBuilder $stripeCheckoutRequestDTOBuilder
    ): Response
    {
        $stripeCheckoutRequest = $stripeCheckoutRequestDTOBuilder->buildFromRequest($request);
        if (!$stripeCheckoutRequest) {
            return $this->redirect($request->request->get('cancel_url', '/'));
        }
        $url = $stripeClient->getPaymentUrl($stripeCheckoutRequest);
        return $this->redirect($url ?? $request->request->get('cancel_url', '/'));
    }

    /**
     * @Route("/to-customer-portal", name="payment-client_stripe_customer_portal", methods={"POST"})
     * @param Request $request
     * @param StripeClient $stripeClient
     * @param StripeCustomerPortalRequestDTOBuilder $stripeCustomerPortalRequestDTOBuilder
     * @return Response
     */
    public function toCustomerPortal(
        Request $request,
        StripeClient $stripeClient,
        StripeCustomerPortalRequestDTOBuilder $stripeCustomerPortalRequestDTOBuilder,
        LoggerInterface $logger
    ): Response
    {
        $modeAjax = (bool)$request->request->getInt('ajax_mode');
        $returnUrl = $request->request->get('return_url', '/');
        $stripeCustomerPortalRequest = $stripeCustomerPortalRequestDTOBuilder->buildFromRequest($request);
        if (!$stripeCustomerPortalRequest) {
            if ($modeAjax) {
                $message = 'Invalid Request ' . $request->request->get('order_id');
                $logger->error($message);
                return $this->json(['error' => $message], Response::HTTP_BAD_REQUEST);
            }
            return $this->redirect($returnUrl);
        }
        $url = $stripeClient->customerPortal($stripeCustomerPortalRequest);
        if (!$url) {
            if ($modeAjax) {
                $message = 'Stripe client error! ' . $request->request->get('order_id');
                $logger->error($message);
                return $this->json(['error' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $this->redirect($returnUrl);
        }
        if ($modeAjax) {
            return $this->json(['url' => $url]);
        }
        return $this->redirect($url);
    }
}