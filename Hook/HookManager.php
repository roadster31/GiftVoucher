<?php
/**
 * @author Franck Allimant <franck@cqfdev.fr>
 *
 * Creation date: 23/03/2015 12:09
 */

namespace GiftVoucher\Hook;

use GiftVoucher\Model\OrderProductGiftVoucher;
use GiftVoucher\Model\OrderProductGiftVoucherQuery;
use GiftVoucher\Model\ProductGiftVoucherQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class HookManager extends BaseHook
{
    public function onProductEditRightColumnBottom(HookRenderEvent $event)
    {
        $isGiftVoucher = (null !== ProductGiftVoucherQuery::create()->findOneByProductId($event->getArgument('product_id')));

        $event->add(
            $this->render(
                "gift-voucher-indicator.html",
                [
                    'is_gift_voucher' => $isGiftVoucher,
                    'form' => $event->getArgument('form')
                ]
            )
        );
    }

    public function onOrderEditCartBottom(HookRenderEvent $event)
    {
        $couponIds = [];

        $gifts = OrderProductGiftVoucherQuery::create()->findByOrderId($event->getArgument('order_id'));

        /** @var OrderProductGiftVoucher $gift */
        foreach ($gifts as $gift) {
            $couponIds[] = $gift->getCouponId();
        }

        $event->add(
            $this->render(
                "order-gift-voucher-list.html",
                [
                    'couponIds' => implode(',', $couponIds),
                    'orderId' => $event->getArgument('order_id')
                ]
            )
        );
    }

}
