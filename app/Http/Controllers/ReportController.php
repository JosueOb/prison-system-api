<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private string $directory_name = 'reports';

    public function __construct()
    {
        $this->authorizeResource(Report::class, 'report');
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $reports = $user->reports;
        return $this->sendResponse(message: 'Report list generated successfully', result: [
            'reports' => ReportResource::collection($reports)
        ]);
    }

    public function store(ReportRequest $request): JsonResponse
    {
        $report_data = $request->only(['title', 'description']);
        $report = new Report($report_data);
        $user = Auth::user();
        $user->reports()->save($report);

        if ($request->has('image')) {
            $image_path = ImageHelper::getLoadedImagePath(
                uploaded_image: $request->file('image'),
                directory: $this->directory_name
            );
            $report->attachImage($image_path);
        }

        return $this->sendResponse(message: 'Report stored successfully');
    }

    public function show(Report $report): JsonResponse
    {
        return $this->sendResponse(message: 'Report details', result: [
            'report' => new ReportResource($report),
        ]);
    }

    public function update(ReportRequest $request, Report $report): JsonResponse
    {
        $report_data = $request->only(['title', 'description']);
        $report->fill($report_data);
        $report->save();

        if ($request->has('image')) {
            $image_path = ImageHelper::getLoadedImagePath(
                uploaded_image: $request->file('image'),
                previous_image_path: $report->image?->path,
                directory: $this->directory_name
            );
            $report->attachImage($image_path);
        }

        return $this->sendResponse(message: 'Report updated successfully');
    }

    public function destroy(Report $report): JsonResponse
    {
        $report_state = $report->state;
        $message = $report_state ? 'inactivated' : 'activated';
        $report->state = !$report_state;
        $report->save();

        return $this->sendResponse(message: "Report $message successfully");
    }
}
