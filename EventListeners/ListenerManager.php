<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 *
 * Creation date: 23/03/2015 12:26
 */

namespace GiftVoucher\EventListeners;

use GiftVoucher\Event\GiftVoucherEvent;
use GiftVoucher\GiftVoucher;
use GiftVoucher\Model\OrderProductGiftVoucher;
use GiftVoucher\Model\OrderProductGiftVoucherQuery;
use GiftVoucher\Model\ProductGiftVoucher;
use GiftVoucher\Model\ProductGiftVoucherQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Coupon\CouponCreateOrUpdateEvent;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\Product\ProductEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Translation\Translator;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\OrderAddress;
use Thelia\Model\OrderAddressQuery;

class ListenerManager implements EventSubscriberInterface
{
    /** @var  MailerFactory */
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function addFieldToProductForm(TheliaFormEvent $event)
    {
        $event->getForm()->getFormBuilder()->add(
            'gift_voucher',
            'checkbox',
            [
                'required' => false,
                'label' => Translator::getInstance()->trans(
                    'This product is a gift voucher',
                    [],
                    GiftVoucher::DOMAIN_NAME
                )
            ]
        );
    }

    public function manageGiftVoucherStatus(ProductEvent $event)
    {
        if ($event->hasProduct()) {
            // Utilise le principe NON DOCUMENTE qui dit que si une form bindée à un event trouve
            // un champ absent de l'event, elle le rend accessible à travers une méthode magique.
            // (cf. ActionEvent::bindForm())
            $giftVoucherStatus = $event->gift_voucher;

            $productId = $event->getProduct()->getId();

            $pv = ProductGiftVoucherQuery::create()->findOneByProductId($productId);

            if ($giftVoucherStatus) {
                if (null === $pv) {
                    $pv = new ProductGiftVoucher();

                    $pv->setProductId($productId)->save();
                }
            } else {
                if (null !== $pv) {
                    $pv->delete();
                }
            }
        }
    }

    public function generateVoucher(OrderEvent $event)
    {
        if ($event->getOrder()->isPaid(true)) {
            // Create a coupon for each of the gift voucher products in the order
            $order = $event->getOrder();
            $cartId = $order->getCartId();
            $cart = CartQuery::create()->findPk($cartId);

            if($cart == null){
                return;
            }
            
            $cartItems = $cart->getCartItems();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->getProduct();

                // If the product is a gift voucher
                if (null !== ProductGiftVoucherQuery::create()->findOneByProductId($product->getId())) {
                    // Check if we have already generated the coupon
                    if (null === OrderProductGiftVoucherQuery::create()
                        ->findOneByCartItemId($cartItem->getId())) {
                        // Generate a coupon for each item
                        for ($idx = 1; $idx <= $cartItem->getQuantity(); $idx++) {
                            // Générer le code du coupon
                            $code = 'BC' . $cartItem->getId() . 'X' . $idx;

                            $expirationDate = new \DateTime('now');
                            $expirationDate->add(new \DateInterval('P1Y'));

                            // Get the product price with tax
                            $deliveryCountry = OrderAddressQuery::create()
                                ->findPk($order->getDeliveryOrderAddressId())
                                ->getCountry();

                            $price = $cartItem->getTaxedPrice($deliveryCountry);

                            /*
                             * @param string    $code                       Coupon Code
                             * @param string    $serviceId                  Coupon Service id
                             * @param string    $title                      Coupon title
                             * @param array     $effects                    Coupon effects ready to be serialized
                             *                                              'amount' key is mandatory and reflects
                             *                                              the amount deduced from the cart
                             * @param string    $shortDescription           Coupon short description
                             * @param string    $description                Coupon description
                             * @param bool      $isEnabled                  Enable/Disable
                             * @param \DateTime $expirationDate             Coupon expiration date
                             * @param boolean   $isAvailableOnSpecialOffers Is available on special offers
                             * @param boolean   $isCumulative               Is cumulative
                             * @param boolean   $isRemovingPostage          Is removing Postage
                             * @param int       $maxUsage                   Coupon quantity
                             * @param string    $locale                     Coupon Language code ISO (ex: fr_FR)
                             * @param array     $freeShippingForCountries   ID of Countries to which shipping is free
                             * @param array     $freeShippingForMethods     ID of Shipping modules for which shipping is free
                             * @param boolean   $perCustomerUsageCount      Usage count is per customer
                             */
                            $couponEvent = new CouponCreateOrUpdateEvent(
                                $code,
                                'thelia.coupon.type.remove_x_amount',
                                Translator::getInstance()->trans(
                                    "Bon cadeau pour produit %ref, commande %order",
                                    [
                                        '%ref' => $product->getRef(),
                                        '%order' => $order->getRef()
                                    ],
                                    GiftVoucher::DOMAIN_NAME
                                ),
                                ['amount' => $price],
                                Translator::getInstance()->trans(
                                    "Ce code promo a été généré automatiquement par le module Bon Cadeau, suite à l'achat du produit %title (référence %ref), commande %order",
                                    [
                                        '%ref' => $product->getRef(),
                                        '%title' => $product->getTitle(),
                                        '%order' => $order->getRef()
                                    ],
                                    GiftVoucher::DOMAIN_NAME
                                ),
                                '',
                                true,
                                $expirationDate,
                                true,
                                true,
                                false,
                                1,
                                $order->getLang()->getLocale(),
                                [],
                                [],
                                false
                            );

                            $event->getDispatcher()->dispatch(TheliaEvents::COUPON_CREATE, $couponEvent);

                            // Create the voucher
                            $voucher = new OrderProductGiftVoucher();

                            $voucher
                                ->setCartItemId($cartItem->getId())
                                ->setOrderId($order->getId())
                                ->setCouponId($couponEvent->getCouponModel()->getId())
                                ->save();

                            // Send the mail to the customer
                            $giftVoucherEvent = new GiftVoucherEvent();
                            $giftVoucherEvent
                                ->setOrder($order)
                                ->setCouponId($couponEvent->getCouponModel()->getId())
                                ;

                            $event->getDispatcher()->dispatch(GiftVoucher::SEND_MAIL_EVENT, $giftVoucherEvent);
                        }
                    }
                }
            }
        } elseif (! $event->getOrder()->isPaid(false)) {
            // Supprimer tous les coupons
            $gifts = OrderProductGiftVoucherQuery::create()->filterByOrderId($event->getOrder()->getId())->find();

            /** @var OrderProductGiftVoucher $gift */
            foreach ($gifts as $gift) {
                $gift->getCoupon()->delete();

                $gift->delete();
            }
        }
    }

    public function sendVoucherMail(GiftVoucherEvent $event)
    {
        // Send the mail to the customer
        $this->mailer->sendEmailToCustomer(
            GiftVoucher::GIFT_VOUCHER_MESSAGE_NAME,
            $event->getOrder()->getCustomer(),
            [
                'order_id' => $event->getOrder()->getId(),
                'coupon_id' => $event->getCouponId()
            ]
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_creation" => ['addFieldToProductForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_modification" => ['addFieldToProductForm', 128],

            TheliaEvents::PRODUCT_UPDATE  => ['manageGiftVoucherStatus', 100],
            TheliaEvents::PRODUCT_CREATE  => ['manageGiftVoucherStatus', 100],

            TheliaEvents::ORDER_UPDATE_STATUS  => ['generateVoucher', 10],

            GiftVoucher::SEND_MAIL_EVENT => ['sendVoucherMail', 128],
        ];
    }
}
