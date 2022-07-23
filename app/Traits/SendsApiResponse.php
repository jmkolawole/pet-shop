<?php


namespace App\Traits;


use Illuminate\Http\Response;

trait SendsApiResponse
{
    public static $validStatusCodes = [
        "100", "101", "200", "201", "202", "203", "204", "205", "206", "300", "301", "302",
        "303", "304", "305", "306", "307", "400", "401", "402", "403", "404", "405", "406", "407", "408", "409", "410", "411",
        "412", "413", "414", "415", "416", "417", "500", "501", "502", "503", "504", "505"
    ];

    /**
     * Handles response for successful requests
     *
     * @param $data
     * @param string|null $message
     * @param bool $paginatedData
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, string $message = null, bool $paginatedData = false)
    {
        $array = ['status' => Response::HTTP_OK, 'message' => $message ?? 'Successful'];

        if ($paginatedData) {
            $array['pagination'] = $data;
        } else {
            $array['data'] = $data;
        }

        return response()->json($array);
    }


    /**
     * Handle response for resource creation
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function createdResponse(string $message = null)
    {
        $code = 201;

        return response()->json([
            'status' => $code,
            'message' => $message ?? 'Created Successfully'
        ], $code);
    }



    /**
     * Handles response for failed requests
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function failureResponse(string $message, int $code)
    {
        $code = (!in_array($code, self::$validStatusCodes)) ? 500 : $code;

        return response()->json([
            'status' => $code,
            'message' => $message ?? 'Request failed'
        ], $code);
    }
}