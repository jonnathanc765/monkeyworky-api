<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBannerRequest;
use App\Models\Banner;
use App\Utils\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return Banner::all();
    }

    public function store(CreateBannerRequest $request)
    {
        $data = $request->validated();
        $this->check_availability($data['position']);
        $banner = Banner::create([
            'position' => $data['position'],
        ]);
        $banner->picture()->create([])->attach($request->picture);
        return $banner;
    }

    public function show(Request $request)
    {
        $banner = Banner::where('position', $request->position)->first();
        return $banner->toJson();
    }

    public function destroy (Request $request)
    {
        $banner = Banner::find($request->id); 
        $banner->picture->delete();
        $banner->delete();
    }

    protected function check_availability($position = Banner::MAIN)
    {
        if (Banner::count() >= Banner::MAX_PER_POSITION[Banner::MAIN]) {
            $this->pop_banner($position);
        }
    }

    protected function pop_banner($position = Banner::MAIN)
    {
        $banner = Banner::where('position', $position)->first();
        $banner->picture->delete();
        $banner->delete();
    }
}
