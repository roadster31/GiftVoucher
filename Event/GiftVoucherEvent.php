<?php
/**
 * @author Franck Allimant <franck@cqfdev.fr>
 *
 * Creation date: 24/03/2015 00:03
 */

namespace GiftVoucher\Event;

use Thelia\Core\Event\ActionEvent;
use Thelia\Model\Order;

class GiftVoucherEvent extends ActionEvent
{
    /** @var  Order */
    protected $order;
    protected $couponId;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCouponId()
    {
        return $this->couponId;
    }

    /**
     * @param mixed $couponId
     * @return $this
     */
    public function setCouponId($couponId)
    {
        $this->couponId = $couponId;
        return $this;
    }
}
