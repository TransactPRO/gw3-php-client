<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway;

use stdClass;
use TransactPro\Gateway\DataSets\Auth;
use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\Customer;
use TransactPro\Gateway\DataSets\FilterData;
use TransactPro\Gateway\DataSets\Info;
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\DataSets\PaymentMethod;
use TransactPro\Gateway\DataSets\System;
use TransactPro\Gateway\DataSets\Verify3dEnrollment;
use TransactPro\Gateway\DataSets\VerifyCardData;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Http\Client\Client;
use TransactPro\Gateway\Http\Request;
use TransactPro\Gateway\Http\Transport\Curl;
use TransactPro\Gateway\Interfaces\HttpClientInterface;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Helpers\RetrieveForm;
use TransactPro\Gateway\Operations\Info\History;
use TransactPro\Gateway\Operations\Info\Limits;
use TransactPro\Gateway\Operations\Info\Recurrents;
use TransactPro\Gateway\Operations\Info\Refunds;
use TransactPro\Gateway\Operations\Info\Result;
use TransactPro\Gateway\Operations\Info\Status;
use TransactPro\Gateway\Operations\Reporting\Report;
use TransactPro\Gateway\Operations\Token\CreateToken;
use TransactPro\Gateway\Operations\Transactions\B2P;
use TransactPro\Gateway\Operations\Transactions\Cancel;
use TransactPro\Gateway\Operations\Transactions\Credit;
use TransactPro\Gateway\Operations\Transactions\DmsCharge;
use TransactPro\Gateway\Operations\Transactions\DmsHold;
use TransactPro\Gateway\Operations\Transactions\InitRecurrentDms;
use TransactPro\Gateway\Operations\Transactions\InitRecurrentSms;
use TransactPro\Gateway\Operations\Transactions\MotoDms;
use TransactPro\Gateway\Operations\Transactions\MotoSms;
use TransactPro\Gateway\Operations\Transactions\P2P;
use TransactPro\Gateway\Operations\Transactions\RecurrentDms;
use TransactPro\Gateway\Operations\Transactions\RecurrentSms;
use TransactPro\Gateway\Operations\Transactions\Refund;
use TransactPro\Gateway\Operations\Transactions\Reversal;
use TransactPro\Gateway\Operations\Transactions\Sms;
use TransactPro\Gateway\Operations\Verify\Enrolled3D;
use TransactPro\Gateway\Operations\Verify\VerifyCard;
use TransactPro\Gateway\Responses\PaymentResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Gateway.
 *
 * Gateway is the main class of the library.
 */
class Gateway
{
    /**
     * URL of the API.
     *
     * @var string
     */
    private $url = 'https://api.sandbox.transactpro.io/v3.0';

    /**
     * HTTP Client.
     *
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * Gateway constructor.
     *
     * If no custom URL is passed default will be used.
     * If you provide custom URL, it should be *without* trailing slash (/).
     *
     * @param string $url
     */
    public function __construct($url = '')
    {
        if ($url !== '') {
            $this->url = $url;
        }

        // set defaults
        $this->auth = new Auth();

        $transport = new Curl();
        $transport->setDefaultOptions();
        $this->httpClient = new Client($this->url, $transport);
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Authentication block setup.
     *
     * @return Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * SMS transaction request builder.
     *
     * SMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return Sms
     */
    public function createSms()
    {
        return new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * DMS HOLD transaction request builder.
     *
     * DMS HOLD transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return DmsHold
     */
    public function createDmsHold()
    {
        return new DmsHold(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * DMS CHARGE transaction request builder.
     *
     * DMS CHARGE transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return DmsCharge
     */
    public function createDmsCharge()
    {
        return new DmsCharge(new Validator(), new Money(), new Command(), new Order());
    }

    /**
     * CANCEL transaction request builder.
     *
     * CANCEL transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return Cancel
     */
    public function createCancel()
    {
        return new Cancel(new Validator(), new Command(), new Order());
    }

    /**
     * MOTO SMS transaction request builder.
     *
     * MOTO SMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return MotoSms
     */
    public function createMotoSms()
    {
        return new MotoSms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * MOTO DMS transaction request builder.
     *
     * MOTO DMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return MotoDms
     */
    public function createMotoDms()
    {
        return new MotoDms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * Credit transaction request builder.
     *
     * Credit transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return Credit
     */
    public function createCredit()
    {
        return new Credit(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * P2P transaction request builder.
     *
     * P2P transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return P2P
     */
    public function createP2P()
    {
        return new P2P(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * B2P transaction request builder.
     *
     * B2P transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return B2P
     */
    public function createB2P()
    {
        return new B2P(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * Init Recurrent SMS transaction request builder.
     *
     * Init Recurrent SMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return InitRecurrentSms
     */
    public function createInitRecurrentSms()
    {
        return new InitRecurrentSms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * Init Recurrent DMS HOLD transaction request builder.
     *
     * Init Recurrent DMS HOLD transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return InitRecurrentDms
     */
    public function createInitRecurrentDms()
    {
        return new InitRecurrentDms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
    }

    /**
     * RECURRENT SMS transaction request builder.
     *
     * RECURRENT SMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return RecurrentSms
     */
    public function createRecurrentSms()
    {
        return new RecurrentSms(new Validator(), new Money(), new Command(), new Order());
    }

    /**
     * RECURRENT DMS transaction request builder.
     *
     * RECURRENT DMS transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return RecurrentDms
     */
    public function createRecurrentDms()
    {
        return new RecurrentDms(new Validator(), new Money(), new Command(), new Order());
    }

    /**
     * REFUND transaction request builder.
     *
     * REFUND transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return Refund
     */
    public function createRefund()
    {
        return new Refund(new Validator(), new Money(), new Command(), new Order());
    }

    /**
     * REVERSAL transaction request builder.
     *
     * REVERSAL transaction request builder provide all
     * needed methods to prepare request.
     *
     * @return Reversal
     */
    public function createReversal()
    {
        return new Reversal(new Validator(), new Command(), new Order());
    }

    /**
     * RESULT information request builder.
     *
     * RESULT information builder provide all
     * needed methods to prepare request.
     *
     * @return Result
     */
    public function createResult()
    {
        return new Result(new Validator(), new Info());
    }

    /**
     * HISTORY information request builder.
     *
     * HISTORY information builder provide all
     * needed methods to prepare request.
     *
     * @return History
     */
    public function createHistory()
    {
        return new History(new Validator(), new Info());
    }

    /**
     * STATUS information request builder.
     *
     * STATUS information builder provide all
     * needed methods to prepare request.
     *
     * @return Status
     */
    public function createStatus()
    {
        return new Status(new Validator(), new Info());
    }

    /**
     * RECURRENTS information request builder.
     *
     * RECURRENTS information builder provide all
     * needed methods to prepare request.
     *
     * @return Recurrents
     */
    public function createRecurringTransactions()
    {
        return new Recurrents(new Validator(), new Info());
    }

    /**
     * REFUNDS information request builder.
     *
     * REFUNDS information builder provide all
     * needed methods to prepare request.
     *
     * @return Refunds
     */
    public function createRefunds()
    {
        return new Refunds(new Validator(), new Info());
    }

    /**
     * LIMITS information request builder.
     *
     * LIMITS information builder provide all
     * needed methods to prepare request.
     *
     * @return Limits
     */
    public function createLimits()
    {
        return new Limits(new Validator());
    }

    /**
     * Verify 3D-Secure enrollment request builder.
     *
     * Verify 3D-Secure enrollment builder provide all
     * needed methods to prepare request.
     *
     * @return Enrolled3D
     */
    public function createVerify3dEnrollment(): Enrolled3D
    {
        return new Enrolled3D(new Validator(), new Verify3dEnrollment());
    }

    /**
     * Card verification completion request builder.
     *
     * Card verification completion builder provide all
     * needed methods to prepare request.
     *
     * @return VerifyCard
     */
    public function createCardVerification(): VerifyCard
    {
        return new VerifyCard(new Validator(), new VerifyCardData());
    }

    /**
     * Payment data tokenization request.
     *
     * Payment data tokenization builder provide all
     * needed methods to prepare request.
     *
     * @return CreateToken
     */
    public function createToken(): CreateToken
    {
        return new CreateToken(new Validator(), new PaymentMethod(), new Money(), new Order(), new System(), new Command());
    }

    /**
     * Transactions CSV report loading request.
     *
     * Transactions CSV report loading request builder provide all
     * needed methods to prepare request.
     *
     * @return Report
     */
    public function createReport(): Report
    {
        return new Report(new Validator(), new FilterData());
    }

    /**
     * Retrieve an HTML form request.
     * Retrieve an HTML form loading request builder provide all
     * needed methods to prepare request.
     *
     * @param PaymentResponse $paymentResponse
     *
     * @throws Exceptions\RequestException
     * @return RetrieveForm
     */
    public function createRetrieveForm(PaymentResponse $paymentResponse): RetrieveForm
    {
        return new RetrieveForm(new Validator(), $paymentResponse);
    }

    /**
     * Process prepares and apply provided request
     *
     * @param Request $request
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ResponseException
     * @return ResponseInterface
     */
    public function process(Request $request)
    {
        $payload = $request->getPreparedData();
        if (empty($payload) && strtolower($request->getMethod()) !== 'GET') {
            $payload = $this->generatePayload($request->getData());
            $request->setPreparedData($payload);
        }

        $url = $request->getPath();
        if (!preg_match('/^http.+/', $request->getPath())) {
            $url = $this->httpClient->createUrl($url);
        }

        return $this->httpClient->request($this->auth->getObjectGUID(), $this->auth->getSecretKey(), $request->getMethod(), $url, $payload);
    }

    /**
     * Generate request generates Request object filled with data for processing
     *
     * @param  OperationInterface $operation
     * @throws ValidatorException
     * @return Request
     */
    public function generateRequest(OperationInterface $operation)
    {
        $req = $operation->build();

        $payload = $this->generatePayload($req->getData());

        $req->setPreparedData($payload);

        return $req;
    }

    /**
     * Generate JSON string payload for the request.
     *
     * @param  array  $data
     * @return string
     */
    private function generatePayload(array $data = [])
    {
        $mergedPayload = array_merge($this->auth->getRaw(), $data);

        $finalPayload = [];
        foreach ($mergedPayload as $k => $v) {
            $finalPayload = array_merge_recursive($finalPayload, $this->setByPath($k, $v));
        }

        if (empty($finalPayload)) {
            $finalPayload = new stdClass();
        }

        return json_encode($finalPayload);
    }

    /**
     * Create array by provided path.
     *
     * @param  string $path  JSON path
     * @param  mixed  $value Value to be by JSON path
     * @return array
     */
    private function setByPath($path, $value)
    {
        $storage = [];

        $aPath = $this->explode($path);

        $tmp = &$storage;
        foreach ($aPath as $path) {
            $tmp = &$tmp[$path];
        }

        $tmp = $value;
        unset($tmp);

        return $storage;
    }

    /**
     * Explode JSON path.
     *
     * @param  string $path Path as "some.json.path"
     * @return array
     */
    private function explode(string $path): array
    {
        return explode('.', $path);
    }
}
