# Gift Voucher

The module allow your customer to buy gifts vouchers. 

To create a gift-voucher, create a new product, and check the 'This product is a gift voucher' box in the product's 
general tab (please see 'Hook' section below). When this product will be bought and paid, a gift voucher will be generated.
The gift amount is just the price of the product.
 
When a customer put this product in his cart, a special discount code will be created when the order will be paid. This
discount code gives a fixed amount discount equals to the price of the product. An email which contains this discount
code is then sent to your customer.

The provided email is... well, raw. But you can prettify it as tou like. Just edit the `gift_voucher_customer_message`
in your Back-Office.

Future versions will allow a customization of the coupon parameters.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is GiftVoucher.
* Activate it in your Thelia administration panel

### Composer

Add it in your main Thelia composer.json file

```
composer require cqfdev/gift-voucher-module:~1.0
```

## Hook

This module uses a specific hook in the back-office. You should add it in templates/backOffice/default/includes/product-general-tab.html,
just after the 'visible' form field declaration :

`{hook name="product-edit.right-column.bottom" product_id=$ID form=$form}`

Example:

```
...
                {form_field field='visible'}
                    <div class="form-group {if $error}has-error{/if}">
                        <label for="{$label_attr.for}" class="control-label">{intl l='Visibility'}</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="{$label_attr.for}" name="{$name}" value="1" {if $value != 0}checked="checked"{/if}>
                                {$label}
                            </label>
                        </div>
                    </div>
                {/form_field}

                {hook name="product-edit.right-column.bottom" product_id=$ID form=$form}
            </div>
        </div>
...
```