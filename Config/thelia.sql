
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_gift_voucher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_gift_voucher`;

CREATE TABLE `product_gift_voucher`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_product_gift_voucher_product_id` (`product_id`),
    CONSTRAINT `fk_product_gift_voucher_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_product_gift_voucher
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_product_gift_voucher`;

CREATE TABLE `order_product_gift_voucher`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `cart_item_id` INTEGER NOT NULL,
    `coupon_id` INTEGER NOT NULL,
    `customer_message` LONGTEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `FI_product_gift_voucher_cart_item_id` (`cart_item_id`),
    INDEX `FI_order_product_gift_voucher_order_id` (`order_id`),
    INDEX `FI_order_product_gift_voucher_coupon_id` (`coupon_id`),
    CONSTRAINT `fk_product_gift_voucher_cart_item_id`
        FOREIGN KEY (`cart_item_id`)
        REFERENCES `cart_item` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_product_gift_voucher_order_id`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_order_product_gift_voucher_coupon_id`
        FOREIGN KEY (`coupon_id`)
        REFERENCES `coupon` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
