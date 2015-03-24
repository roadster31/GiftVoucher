<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace GiftVoucher;

use Propel\Generator\Model\Database;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Model\Message;
use Thelia\Model\MessageQuery;
use Thelia\Module\BaseModule;

class GiftVoucher extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'giftvoucher';

    const GIFT_VOUCHER_MESSAGE_NAME = 'gift_voucher_customer_message';

    const SEND_MAIL_EVENT = 'gift_voucher.send-email';

    public function getHooks()
    {
        return [
            [
                'type' => TemplateDefinition::BACK_OFFICE,
                'code' => 'product-edit.right-column.bottom',
                'title' => [
                    'en_US' => 'Bottom of right column of general product tab',
                    'fr_FR' => 'Bas de la colonne de droite du tab "Général" des produits'
                ],
                'active' => true,
                'block' => false
            ]
        ];
    }

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new \Thelia\Install\Database($con->getWrappedConnection());
        $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);


        // Create voucher messages from templates, if not already defined
        $email_templates_dir = __DIR__.DS.'I18n'.DS.'email-templates'.DS;

        if (null === MessageQuery::create()->findOneByName(self::GIFT_VOUCHER_MESSAGE_NAME)) {
            $message = new Message();

            $message
                ->setName(self::GIFT_VOUCHER_MESSAGE_NAME)

                ->setLocale('en_US')
                ->setTitle('Gift voucher sent to customer')
                ->setSubject('Your gift voucher for {config key="store_name"}')
                ->setHtmlMessage(file_get_contents($email_templates_dir.'en.html'))
                ->setTextMessage(file_get_contents($email_templates_dir.'en.txt'))

                ->setLocale('fr_FR')
                ->setTitle('Bon cadeau envoyé au client')
                ->setSubject('Votre bon cadeau pour {config key="store_name"}')
                ->setHtmlMessage(file_get_contents($email_templates_dir.'fr.html'))
                ->setTextMessage(file_get_contents($email_templates_dir.'fr.txt'))

                ->save()
            ;
        }
    }
}
