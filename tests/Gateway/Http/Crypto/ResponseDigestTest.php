<?php

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
use TransactPro\Gateway\Exceptions\DigestMismatchException;
use TransactPro\Gateway\Exceptions\DigestMissingException;
use TransactPro\Gateway\Responses\CallbackResult;
use TransactPro\Gateway\Responses\GatewayResponse;

class ResponseDigestTest extends TestCase
{
    /**
     * @dataProvider getConstructorErrorCases
     *
     * @param string $authHeader
     * @param string $errorClass
     * @param string $expectedError
     *
     * @throws DigestMismatchException
     * @throws DigestMissingException
     */
    public function testConstructorFailure(string $authHeader, string $errorClass, string $expectedError): void
    {
        $this->expectException($errorClass);
        $this->expectExceptionMessage($expectedError);

        new ResponseDigest($authHeader);
    }

    public function getConstructorErrorCases(): array
    {
        $nonce = base64_encode("1:q");
        $noTsNonce = base64_encode("qqq");
        $wrongTsNonce = base64_encode("qqq:www");

        return [
            ["", DigestMissingException::class, "Digest is missing"],
            [
                sprintf("Digest uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=auth-int, response=e", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for username",
            ],
            [
                sprintf("Digest username=a, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=auth-int, response=e", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for uri",
            ],
            [
                sprintf("Digest username=a, uri=b, cnonce=%s, snonce=%s, qop=auth-int, response=e", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for algorithm",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, snonce=%s, qop=auth-int, response=e", $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for cnonce",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, qop=auth-int, response=e", $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for snonce",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, response=e", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for qop",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=auth", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: empty value for response",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=aaa, response=x", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: invalid value for qop",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=aaa, cnonce=%s, snonce=%s, qop=auth, response=x", $nonce, $nonce),
                DigestMismatchException::class,
                "Digest mismatch: invalid value for algorithm",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=auth, response=x", $nonce, $noTsNonce),
                DigestMismatchException::class,
                "Digest mismatch: corrupted value for snonce (missing timestamp)",
            ],
            [
                sprintf("Digest username=a, uri=b, algorithm=SHA-256, cnonce=%s, snonce=%s, qop=auth, response=x", $nonce, $wrongTsNonce),
                DigestMismatchException::class,
                "Digest mismatch: corrupted value for snonce (unexpected timestamp value)",
            ],
        ];
    }

    public function testConstructorSuccessful(): void
    {
        $headerValue = "Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTYyNTA2MzqydV+lpoF4ZtfSAifxoUretZdAzGaZa97iRogrQ8K/yg==\", " .
            "snonce=\"MTU5MTYyNDgwNzoUte6YsXIJmUo1EsA4yrYDCVbPrvCrEtqGq6CHTMhImg==\", qop=auth-int, " .
            "response=\"a21df219fd9bb2efb71554eb9ebb47f6a7a61769a289f9ab4fcbe41d7544e28d\"";
        $digest = new ResponseDigest($headerValue);

        $this->assertEquals("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", $digest->getUsername());
        $this->assertEquals("/v3.0/sms", $digest->getUri());
        $this->assertEquals(Digest::ALGORITHM_SHA256, $digest->getAlgorithm());
        $this->assertEquals(Digest::QOP_AUTH_INT, $digest->getQop());
        $this->assertEquals("a21df219fd9bb2efb71554eb9ebb47f6a7a61769a289f9ab4fcbe41d7544e28d", $digest->getResponse());
        $this->assertEquals(1591624807, $digest->getTimestamp());
        $this->assertEquals(base64_decode("MTU5MTYyNTA2MzqydV+lpoF4ZtfSAifxoUretZdAzGaZa97iRogrQ8K/yg=="), $digest->getCnonce());
        $this->assertEquals(base64_decode("MTU5MTYyNDgwNzoUte6YsXIJmUo1EsA4yrYDCVbPrvCrEtqGq6CHTMhImg=="), $digest->getSnonce());
    }

    /**
     * @dataProvider getVerifyErrorCases
     *
     * @param string $guid
     * @param string $originalUri
     * @param string $originalCnonce
     * @param string $expectedError
     *
     * @throws DigestMismatchException
     * @throws DigestMissingException
     */
    public function testVerifyErrors(string $guid, string $originalUri, string $originalCnonce, string $expectedError): void
    {
        $this->expectException(DigestMismatchException::class);
        $this->expectExceptionMessage($expectedError);

        $body = "{\"acquirer-details\":{},\"error\":{},\"gw\":{\"gateway-transaction-id\":\"37b88436-b69c-45f3-ad26-b945153ad9a8\"," .
            "\"redirect-url\":\"http://api.local/4f1f647d10e8296a2ed4d21e3639f1ee\",\"status-code\":30,\"status-text\":" .
            "\"INSIDE FORM URL SENT\"},\"warnings\":[\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded " .
            "for the account\"]}";

        $responseHeader = "Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTg2NjU3Mzo38zMeHvu4qcbhR8X158atP/BB4dDb5DbOMRT656yS7Q==\", " .
            "snonce=\"MTU5MTg2NjU3MzpvnttqUse7hfrkUHtPS8tWE1jl0D0G/DgMmEFwbk5/jw==\", qop=auth-int, " .
            "response=\"624478f45d33bbadc7cf0ae9b34462efd7b9736111f295e6330fe0bc3b20acda\"";

        $responseDigest = new ResponseDigest($responseHeader);
        $responseDigest->setOriginalUri($originalUri);
        $responseDigest->setOriginalCnonce($originalCnonce);
        $responseDigest->setBody($body);
        $responseDigest->verify($guid, "something wrong");
    }

    public function getVerifyErrorCases(): array
    {
        $validCnonce = base64_decode("MTU5MTg2NjU3Mzo38zMeHvu4qcbhR8X158atP/BB4dDb5DbOMRT656yS7Q==");
        $invalidCnonce = base64_decode("MTU5MTg2NjU3MzpvnttqUse7hfrkUHtPS8tWE1jl0D0G/DgMmEFwbk5/jw==");

        return [
            ["wrong-guid", "/v3.0/sms", $validCnonce, "Digest mismatch: username mismatch"],
            ["bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "http://another.local", $validCnonce, "Digest mismatch: uri mismatch"],
            ["bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "/v3.0/sms", $invalidCnonce, "Digest mismatch: cnonce mismatch"],
            ["bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "/v3.0/sms", $validCnonce, "Digest mismatch"],
        ];
    }

    public function testVerifySuccessFullChecks(): void
    {
        $body = "{\"acquirer-details\":{},\"error\":{},\"gw\":{\"gateway-transaction-id\":\"37b88436-b69c-45f3-ad26-b945153ad9a8\"," .
            "\"redirect-url\":\"http://api.local/4f1f647d10e8296a2ed4d21e3639f1ee\",\"status-code\":30,\"status-text\":" .
            "\"INSIDE FORM URL SENT\"},\"warnings\":[\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded " .
            "for the account\"]}";

        $responseHeader = "Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTg2NjU3Mzo38zMeHvu4qcbhR8X158atP/BB4dDb5DbOMRT656yS7Q==\", " .
            "snonce=\"MTU5MTg2NjU3MzpvnttqUse7hfrkUHtPS8tWE1jl0D0G/DgMmEFwbk5/jw==\", qop=auth-int, " .
            "response=\"dda7026eebbeeee19fda191fd951d470b2064e3e1bc416365835abc775352552\"";

        $responseDigest = new ResponseDigest($responseHeader);
        $responseDigest->setOriginalUri("/v3.0/sms");
        $responseDigest->setOriginalCnonce(base64_decode("MTU5MTg2NjU3Mzo38zMeHvu4qcbhR8X158atP/BB4dDb5DbOMRT656yS7Q=="));
        $responseDigest->setBody($body);
        $responseDigest->verify("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "tPMOogw7YBumh6RpXxi2nvGW0C9lJq3L");

        // no exception means success
        $this->assertTrue(true);
    }

    public function testVerifySuccessMinimalChecks(): void
    {
        $body = "{\"acquirer-details\":{},\"error\":{},\"gw\":{\"gateway-transaction-id\":\"37b88436-b69c-45f3-ad26-b945153ad9a8\"," .
            "\"redirect-url\":\"http://api.local/4f1f647d10e8296a2ed4d21e3639f1ee\",\"status-code\":30,\"status-text\":" .
            "\"INSIDE FORM URL SENT\"},\"warnings\":[\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded " .
            "for the account\"]}";

        $responseHeader = "Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTg2NjU3Mzo38zMeHvu4qcbhR8X158atP/BB4dDb5DbOMRT656yS7Q==\", " .
            "snonce=\"MTU5MTg2NjU3MzpvnttqUse7hfrkUHtPS8tWE1jl0D0G/DgMmEFwbk5/jw==\", qop=auth-int, " .
            "response=\"dda7026eebbeeee19fda191fd951d470b2064e3e1bc416365835abc775352552\"";

        $responseDigest = new ResponseDigest($responseHeader);
        $responseDigest->setBody($body);
        $responseDigest->verify("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "tPMOogw7YBumh6RpXxi2nvGW0C9lJq3L");

        // no exception means success
        $this->assertTrue(true);
    }

    public function testVerifyCallback(): void
    {
        $jsonFromPost = "{\"result-data\":{\"gw\":{\"gateway-transaction-id\":\"8d77f986-de7f-4d47-97ef-9de7f8561684\",\"status-code\":7,\"status-text\":\"SUCCESS\"}," .
            "\"error\":{},\"acquirer-details\":{\"eci-sli\":\"503\",\"terminal-mid\":\"3201210\",\"transaction-id\":\"7146311464333929\"," .
            "\"result-code\":\"000\",\"status-text\":\"Approved\",\"status-description\":\"Approved\"},\"warnings\":" .
            "[\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded for the account\"," .
            "\"Soon counters will be exceeded for the terminal group\",\"Soon counters will be exceeded for the terminal\"]}}";

        $signFromPost = "Digest username=bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b, uri=\"/v3.0/sms\", algorithm=SHA-256, " .
            "cnonce=\"MTU5MTg2OTQ3OTpbmPfGQxVAh5z7MdWnRjF1cavfwKyxiLVrX4p7IHNwWA==\", " .
            "snonce=\"MTU5MTg2OTQ4MTqfPxash/0hfNpI/gHuaoSiV+6PwVKYEawxchE0nxHTkA==\", qop=auth-int, " .
            "response=\"87bd753875e28da54dfcb5e61614e10a7120aba9a3f8bed0e6eaa9acb85aa9f9\"";

        $responseDigest = new ResponseDigest($signFromPost);
        $responseDigest->setOriginalUri("/v3.0/sms");
        $responseDigest->setOriginalCnonce(base64_decode("MTU5MTg2OTQ3OTpbmPfGQxVAh5z7MdWnRjF1cavfwKyxiLVrX4p7IHNwWA=="));
        $responseDigest->setBody($jsonFromPost);
        $responseDigest->verify("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", "tPMOogw7YBumh6RpXxi2nvGW0C9lJq3L");

        /** @var CallbackResult $parsedResult */
        $parsedResult = GatewayResponse::createFromJSON($jsonFromPost, CallbackResult::class);
        $this->assertEquals("8d77f986-de7f-4d47-97ef-9de7f8561684", $parsedResult->gw->gatewayTransactionId);
    }
}
