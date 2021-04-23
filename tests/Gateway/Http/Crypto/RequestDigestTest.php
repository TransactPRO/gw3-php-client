<?php declare(strict_types=1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http\Crypto;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RequestDigestTest extends TestCase
{
    public function testCreateHeader()
    {
        $expected = "Authorization: Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTYyNTA2MzqydV+lpoF4ZtfSAifxoUretZdAzGaZa97iRogrQ8K/yg==\", qop=auth-int, " .
            "response=\"a21df219fd9bb2efb71554eb9ebb47f6a7a61769a289f9ab4fcbe41d7544e28d\"";

        $instance = new RequestDigest("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "agHJSthpTPfKEORLDynBuIl07i4sYVmw", "https://some.url/v3.0/sms");
        $this->assertEquals(Digest::ALGORITHM_SHA256, $instance->getAlgorithm());
        $this->assertEquals(Digest::QOP_AUTH_INT, $instance->getQop());
        $this->assertEquals(43, strlen($instance->getCnonce()));

        $instance->setBody(
            "{\"auth-data\":{},\"data\":{\"command-data\":{},\"general-data\":{\"customer-data\":{\"email\":\"test@test.domain\",\"birth-date\":\"01/00\"," .
            "\"phone\":\"123456789\",\"billing-address\":{\"country\":\"FR\",\"state\":\"FR\",\"city\":\"Chalon-sur-Saône\",\"street\":\"Rue Garibaldi\"," .
            "\"house\":\"10\",\"flat\":\"10\",\"zip\":\"71100\"},\"shipping-address\":{\"country\":\"FR\",\"state\":\"FR\",\"city\":\"Chalon-sur-Saône\"," .
            "\"street\":\"Rue Garibaldi\",\"house\":\"10\",\"flat\":\"10\",\"zip\":\"71100\"}},\"order-data\":{\"merchant-transaction-id\":\"\"," .
            "\"order-id\":\"Order ID\",\"order-description\":\"Payment\",\"merchant-side-url\":\"https://domain.com/custom-url/\"," .
            "\"merchant-referring-name\":\"Test payment\",\"custom3d-return-url\":\"https://domain.com\"}},\"payment-method-data\":" .
            "{\"pan\":\"4111111111111111\",\"exp-mm-yy\":\"09/31\",\"cvv\":\"123\",\"cardholder-name\":\"John Doe\"},\"money-data\":" .
            "{\"amount\":100,\"currency\":\"EUR\"},\"system\":{\"user-ip\":\"127.0.0.1\"}}}"
        );

        $rc = new ReflectionClass($instance);
        $oProperty = $rc->getProperty('cnonce');
        $oProperty->setAccessible(true);
        $oProperty->setValue($instance, base64_decode("MTU5MTYyNTA2MzqydV+lpoF4ZtfSAifxoUretZdAzGaZa97iRogrQ8K/yg=="));

        $actual = $instance->createHeader();
        $this->assertEquals($expected, $actual);
    }
}
