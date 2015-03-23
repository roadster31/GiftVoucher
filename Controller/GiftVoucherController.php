<?php
/**
 * @author Franck Allimant <franck@cqfdev.fr>
 *
 * Creation date: 24/03/2015 00:13
 */

namespace GiftVoucher\Controller;

use GiftVoucher\Event\GiftVoucherEvent;
use GiftVoucher\GiftVoucher;
use GiftVoucher\Model\OrderProductGiftVoucherQuery;
use Thelia\Controller\Admin\BaseAdminController;

class GiftVoucherController extends BaseAdminController
{
    public function sendMail($orderId, $couponId)
    {
        if (null !== $opgv = OrderProductGiftVoucherQuery::create()
            ->filterByOrderId($orderId)
            ->findOneByCouponId($couponId)) {
            $event = new GiftVoucherEvent();

            $event->setOrder($opgv->getOrder())->setCouponId($couponId);

            $this->getDispatcher()->dispatch(GiftVoucher::SEND_MAIL_EVENT, $event);
        }

        return $this->generateRedirectFromRoute(
            'admin.order.update.view',
            [],
            ['order_id' => $orderId]
        );
    }
}
