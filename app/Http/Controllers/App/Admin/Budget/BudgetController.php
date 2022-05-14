<?php

namespace App\Http\Controllers\App\Admin\Budget;

use App\Http\Controllers\Controller;
use App\Services\Azure\Contracts\AzureServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    private AzureServiceContract $azureService;

    public function __construct(AzureServiceContract $azureService)
    {
        $this->azureService = $azureService;
    }

    public function live(Request $request): View
    {

        return View('app.admin.budget.live');
    }

    public function getAzureDetail(Request $request): jsonResponse
    {
        try
        {
            $data = [];
            $detail = $this->azureService->getUsageDetails();

            foreach ($detail['value'] as $item)
            {
                $property = $item['properties'];

                if (!array_key_exists($property['consumedService'], $data))
                {
                    $data[$property['consumedService']] = [];
                }

                if (!array_key_exists($property['meterCategory'], $data[$property['consumedService']]))
                {
                    $data[$property['consumedService']][$property['meterCategory']] = [];
                }

                if (!array_key_exists($property['meterName'], $data[$property['consumedService']][$property['meterCategory']]))
                {
                    $data[$property['consumedService']][$property['meterCategory']][$property['meterName']] = [];
                }

                if (!array_key_exists($property['product'], $data[$property['consumedService']][$property['meterCategory']][$property['meterName']]))
                {
                    $unitOfMeasure = match ($property['unitOfMeasure'])
                    {
                        '1 Hour' => '1 시간',
                        '1 GB' => '1 GB',
                        '10K' => '10,000 건',
                        '1/Month' => '1 개월',
                        '1' => '1회',
                        default => $property['unitOfMeasure']
                    };

                    $data[$property['consumedService']][$property['meterCategory']][$property['meterName']][$property['product']] = [
                        'service' => $property['consumedService'] ,
                        'category' => $property['meterCategory'],
                        'name' => $property['meterName'],
                        'unitOfMeasure' => $unitOfMeasure,
                        'quantity' => 0.0,
                        'unitPrice' => (float) $property['unitPrice'],
                        'exchangeRate' => (float) $property['exchangeRate'],
                        'totalPrice' => 0.0,
                    ];
                }

                $data[$property['consumedService']][$property['meterCategory']][$property['meterName']][$property['product']]['quantity'] += $property['quantity'];
                $data[$property['consumedService']][$property['meterCategory']][$property['meterName']][$property['product']]['totalPrice'] += (float) $property['paygCostInUSD'];
            }

            ksort($data);

            return $this->jsonResponse(200, 'SUCCESS', $data);
        }
        catch (\Exception $e)
        {
            return $this->jsonResponse($e->getCode(), $e->getMessage(), config('app.debug') ? $e->getTrace() : []);
        }
    }

}
