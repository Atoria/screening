<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreeningRequest;
use App\Http\Resources\ScreeningResource;
use App\Models\Screening;
use App\Services\ScreeningService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScreeningController extends Controller
{
    public function __construct(private readonly ScreeningService $screeningService)
    {
    }

    public function index()
    {
        $screenings = Screening::latest()->paginate(20);

        return view('screenings.index', [
            'screenings' => ScreeningResource::collection($screenings),
        ]);
    }

    public function create()
    {
        return view('screenings.create');
    }

    public function store(StoreScreeningRequest $request)
    {
        $data = $request->validated();

        $screening = $this->screeningService->createFromData($data);

        return view('screenings.show', compact('screening'));
    }

    public function show(Screening $screening)
    {
        return view('screenings.show', compact('screening'));
    }

}
