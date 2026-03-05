<?php

namespace App\Http\Controllers;

use App\DeviceTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Native\Mobile\Facades\Device;
use Termwind\Components\Div;

class DeviceTestController extends Controller
{
    /**
     * Save a new name into the device_tests table.
     */
    public function save(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $item = DeviceTest::create(['name' => $validated['name']]);
        Log::info('saved todo item', ['id' => $item->id, 'name' => $item->name]);

        return response()->json([
            'success' => true,
            'message' => 'Name saved successfully.',
            'item' => $item,
        ]);
    }

    /**
     * Return all saved names.
     */
    public function list(): JsonResponse
    {
        $items = DeviceTest::orderBy('created_at', 'desc')->get(['id', 'name']);
        return response()->json([
            'success' => true,
            'items' => $items,
        ]);
    }
    public function delete(Request $request): JsonResponse
    {
        //deletar todos os dados
        DeviceTest::truncate();
        return response()->json([
            'success' => true,
            'message' => 'All items deleted successfully.',
        ]);

    }

    public function testVibration()
    {
        try {
            // Triggers the native OS vibration
            Device::vibrate();
            Log::info('log vibration tes successfully');

        } catch (\Throwable $th) {
            log::error($th->getMessage());
            throw new \Exception($th->getMessage());
        }
        return response()->json([
            'success' => true,
            'message' => 'Vibration triggered successfully.',
        ]);

    }
    public function testLogTelegram()
    {
        Log::channel('telegram')->info('log test successfully');
        return response()->json([
            'success' => true,
            'message' => 'Log test successfully.',
        ]);
    }
}
